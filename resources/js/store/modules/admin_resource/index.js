
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {
			srch_name: '',
			srch_situation: ''
		}
	},
	mutations: {
		SET_ADM_RESOURCE(state, adm_resource) {
			state.data = adm_resource;
		},
		SET_FILTERS (state, filters) {
			state.filters.srch_name = filters.srch_name;
			state.filters.srch_situation = filters.srch_situation;
		}
	},
	actions: {
		async getAdmResources(context, params) {
			try {
				const response = await Api.apiPost('/admin/resource', params);
				context.commit('SET_ADM_RESOURCE', response.data.data);
				context.commit('SET_FILTERS', params);
			}
			catch(error) {
				context.commit('SET_ADM_RESOURCE', []);
				return Promise.reject(error);
			}
		},
		async insertAdmResource(_, params) {
			try {
				const response = await Api.apiPost('/admin/resource/create', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async updateAdmResource(context, params) {
			try {
				const response = await Api.apiPost('/admin/resource/update', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async destroyAdmResource(context, params) {
			try {
				const response = await Api.apiPost('/admin/resource/destroy', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}