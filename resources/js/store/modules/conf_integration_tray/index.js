
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {}
	},
	mutations: {},
	actions: {
		async activeConfigIntegrationTray(_, params) {
			try {
				const response = await Api.apiPost('/integration_tray/active', params);
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async activeAutenticationTray(context, params) {
			try {
				const response = await Api.apiPost('/integration_tray/activeAutentication', params);
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async disabledConfigIntegrationTray(context, params) {
			try {
				const response = await Api.apiPost('/integration_tray/disabled', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async getStatusIntegrationTrayConfigIntegrationTray(context, params) {
			try {
				const response = await Api.apiPost('/integration_tray/getStatusIntegrationTray', params);
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}