
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {
			srch_date_checkin: '',
			srch_date_checkout: '',
			srch_name_surname: '',
			srch_whatsapp: '',
			srch_situation: ''
		}
	},
	mutations: {
		SET_GUEST (state, order) {
			state.data = order;
		},
		SET_FILTERS (state, filters) {
			state.filters.srch_date_checkin = filters.srch_date_checkin;
			state.filters.srch_date_checkout = filters.srch_date_checkout;
			state.filters.srch_name_surname = filters.srch_name_surname;
			state.filters.srch_whatsapp = filters.srch_whatsapp;
			state.filters.srch_situation = filters.srch_situation;
		}
	},
	actions: {
		async getGuest(context, params) {
			try {
				const response = await Api.apiPost('/guest', params);
				context.commit('SET_GUEST', response.data.data);
				context.commit('SET_FILTERS', params);
			}
			catch(error) {
				context.commit('SET_GUEST', []);
				return Promise.reject(error);
			}
		},
		async insertGuest(_, params) {
			try {
				const response = await Api.apiPost('/guest/create', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async updateGuest(context, params) {
			try {
				const response = await Api.apiPost('/guest/update', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async destroyGuest(context, params) {
			try {
				const response = await Api.apiPost('/guest/destroy', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}