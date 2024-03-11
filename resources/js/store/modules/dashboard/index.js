
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
		async getDatasDashbboard(context, params) {
			try {
				const response = await Api.apiPost('/portal/page/dashboard', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
	}
}