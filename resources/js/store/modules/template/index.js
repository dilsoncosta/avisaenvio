
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {
			srch_type: '',
			srch_title: '',
			srch_situation: ''
		}
	},
	mutations: {
		SET_TEMPLATE (state, template) {
			state.data = template;
		},
		SET_FILTERS (state, filters) {
			state.filters.srch_type = filters.srch_type;
			state.filters.srch_title = filters.srch_title;
			state.filters.srch_situation = filters.srch_situation;
		}
	},
	actions: {
		async getTemplate(context, params) {
			try {
				const response = await Api.apiPost('/template', params);
				context.commit('SET_TEMPLATE', response.data.data);
				context.commit('SET_FILTERS', params);
			}
			catch(error) {
				context.commit('SET_TEMPLATE', []);
				return Promise.reject(error);
			}
		},
		async insertTemplate(_, params) {
			try {
				const response = await Api.apiPost('/template/create', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async updateTemplate(context, params) {
			try {
				const response = await Api.apiPost('/template/update', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async destroyTemplate(context, params) {
			try {
				const response = await Api.apiPost('/template/destroy', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async destroyFileTemplate(context, params) {
			try {
				const response = await Api.apiPost('/template/destroyFile', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async sendModelWhatsAppTemplate(context, params) {
			try {
				const response = await Api.apiPost('/template/sendModelWhatsApp', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}