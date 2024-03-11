
import Api from "../../../helpers/Api";

export default {
	state: {},
	mutations: {},
	actions: {
		async getAccess(context, params) {
			try {
				const response = await Api.apiPost('/admin/access', params);
				
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async updateAccess(context, params) {
			try {
				const response = await Api.apiPost('/admin/access/update', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}