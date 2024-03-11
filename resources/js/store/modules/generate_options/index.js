
import Api from "../../../helpers/Api";

export default {
	state: {},
	mutations: {},
	actions: {
		async genereateOptionsCollaborators(context, params) {
			try {
				const response = await Api.apiPost('/genereateOptionsCollaborators', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async genereateOptionsTenants(context, params) {
			try {
				const response = await Api.apiPost('/genereateOptionsTenants', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async genereateOptionsIntegrationWhatsApp(context, params) {
			try {
				const response = await Api.apiPost('/generateOptionsIntegrationWhatsApp', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}