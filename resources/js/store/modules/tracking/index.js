
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {
			srch_destination: '',
			srch_object: '',
			srch_situation: ''
		}
	},
	mutations: {
		SET_TRACKING (state, tracking) {
			state.data = tracking;
		},
		SET_FILTERS (state, filters) {
			state.filters.srch_destination = filters.srch_destination;
			state.filters.srch_object = filters.srch_object;
			state.filters.srch_situation = filters.srch_situation;
		}
	},
	actions: {
		async getTracking(context, params) {
			try {
				const response = await Api.apiPost('/tracking', params);
				context.commit('SET_TRACKING', response.data.data);
				context.commit('SET_FILTERS', params);
			}
			catch(error) {
				context.commit('SET_TRACKING', []);
				return Promise.reject(error);
			}
		},
		async destroyTracking(context, params) {
			try {
				const response = await Api.apiPost('/tracking/destroy', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}