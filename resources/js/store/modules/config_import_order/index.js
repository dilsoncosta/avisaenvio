
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {}
	},
	mutations: {},
	actions: {
		async importConfigImportOrder(_, params) {
			try {
				const response = await Api.apiPost('/config/import_order', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
	}
}