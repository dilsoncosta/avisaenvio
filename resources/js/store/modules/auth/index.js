import Api from "../../../helpers/Api";

export default {
	state: {
		me: {},
		authenticated: false,
	},
	mutations: {
		AUTH_USER_OK(state, user) {
			state.authenticated  = true;
			state.me = user;
			state.username = user.username;
		},
		AUTH_USER_LOGOUT(state) {
			state.authenticated  = false;
			state.me = {};
		},
		ALTER_NAME_USERNAME(state, data) {
			state.me.name    = data.name;
			state.me.surname = data.surname;
		}
	},
	actions: {
		async login(context, params) {
			
			return new Promise((resolve, reject) => {
				const subdomainCurrent = window.location.hostname.split('.')[0];
				
				Api.apiPost('/auth', {
					username: params.username,
					password: params.password,
					device_name: params.device_name,
					subdomain: subdomainCurrent
				})
				.then(response => {
						context.commit('AUTH_USER_OK', response.data.user);
						localStorage.setItem(import.meta.env.VITE_APP_NAME_TOKEN, response.data.token);
						resolve(response);
				})
				.catch(error => reject(error))
			});
		},
		async checkLogin(context) {
			const token = await localStorage.getItem(import.meta.env.VITE_APP_NAME_TOKEN);
			
			if(!token)
			{
				return Promise.reject('Token Not Found');
			}
			
			await Api.apiGet('/me')
			.then(response => {
				context.commit('AUTH_USER_OK', response.data.data);
			})
			.catch(() => {
				context.commit('CHANGE_LOADING', false);
				localStorage.removeItem(import.meta.env.VITE_APP_NAME_TOKEN);
			});
		},
		async logout(context) {
			await Api.apiPost('/logout')
			.then(() => {
				localStorage.removeItem(import.meta.env.VITE_APP_NAME_TOKEN);
				context.commit('AUTH_USER_LOGOUT');
			})
			.catch(() => {
				localStorage.removeItem(import.meta.env.VITE_APP_NAME_TOKEN);
			});
		},
		async alter_name_surname(context) {
			try {
				const response =  await Api.apiGet('/me');
				context.commit('ALTER_NAME_USERNAME', {
					name: response.data.data.name,  
					surname: response.data.data.surname
				});
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}