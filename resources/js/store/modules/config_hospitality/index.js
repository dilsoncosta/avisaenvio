
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {}
	},
	mutations: {},
	actions: {
		async getConfigHospitality(_, params) {
			try {
				const response = await Api.apiPost('/config/hospitality', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async updateConfigHospitality(_, params) {
			try {
				const response = await Api.apiPost('/config/hospitality/update', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
	}
}