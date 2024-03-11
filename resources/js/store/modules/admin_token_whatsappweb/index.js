
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {
			srch_client: '',
			srch_situation: ''
		}
	},
	mutations: {
		SET_ADMIN_TOKEN_WHATSAPPWEB (state, admin_token_whatsappweb) {
			state.data = admin_token_whatsappweb;
		},
		SET_FILTERS (state, filters) {
			state.filters.srch_client    = filters.srch_client;
			state.filters.srch_situation = filters.srch_situation;
		}
	},
	actions: {
		async getAdminTokenWhatsAppWeb(context, params) {
			try {
				const response = await Api.apiPost('/admin/token-whatsappweb', params);
				context.commit('SET_ADMIN_TOKEN_WHATSAPPWEB', response.data.data);
				context.commit('SET_FILTERS', params);
			}
			catch(error) {
				context.commit('SET_ADMIN_TOKEN_WHATSAPPWEB', []);
				return Promise.reject(error);
			}
		},
		async insertAdminTokenWhatsAppWeb(_, params) {
			try {
				const response = await Api.apiPost('/admin/token-whatsappweb/create', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async updateAdminTokenWhatsAppWeb(context, params) {
			try {
				const response = await Api.apiPost('/admin/token-whatsappweb/update', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async destroyAdminTokenWhatsAppWeb(context, params) {
			try {
				const response = await Api.apiPost('/admin/token-whatsappweb/destroy', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}