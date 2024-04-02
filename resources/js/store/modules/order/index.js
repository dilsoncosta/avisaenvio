
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {
			srch_code: '',
			srch_destination: '',
			srch_object: '',
			srch_situation: ''
		}
	},
	mutations: {
		SET_ORDER (state, order) {
			state.data = order;
		},
		SET_FILTERS (state, filters) {
			state.filters.srch_code = filters.srch_code;
			state.filters.srch_destination = filters.srch_destination;
			state.filters.srch_object = filters.srch_object;
			state.filters.srch_situation = filters.srch_situation;
		}
	},
	actions: {
		async getOrder(context, params) {
			try {
				const response = await Api.apiPost('/order', params);
				context.commit('SET_ORDER', response.data.data);
				context.commit('SET_FILTERS', params);
			}
			catch(error) {
				context.commit('SET_ORDER', []);
				return Promise.reject(error);
			}
		},
		async insertOrder(_, params) {
			try {
				const response = await Api.apiPost('/order/create', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async updateOrder(context, params) {
			try {
				const response = await Api.apiPost('/order/update', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async destroyOrder(context, params) {
			try {
				const response = await Api.apiPost('/order/destroy', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}