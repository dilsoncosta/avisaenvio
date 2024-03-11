
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {}
	},
	mutations: {
		SET_ACCOUNT (state, account) {
			state.data = account;
		}
	},
	actions: {
		async getAccount(context, params) {
			try {
				const response = await Api.apiPost('/account', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async updateAccount(context, params) {
			try {
				const response = await Api.apiPost('/account/update', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async destroyCertificateAccount(context, params) {
			try {
				const response = await Api.apiPost('/account/destroyCertificate', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async destroyLogoPortalAccount(context, params) {
			try {
				const response = await Api.apiPost('/account/destroyLogoPortal', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
	}
}