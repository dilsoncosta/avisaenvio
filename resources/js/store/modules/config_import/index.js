
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {}
	},
	mutations: {},
	actions: {
		async importConfigImportContact(_, params) {
			try {
				const response = await Api.apiPost('/config/import_contact', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
	}
}