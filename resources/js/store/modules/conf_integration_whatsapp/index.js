
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {}
	},
	mutations: {},
	actions: {
		async activeConfigIntegrationWhatsApp(_, params) {
			try {
				const response = await Api.apiPost('/integration_whatsapp/active', params);
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async disabledConfigIntegrationWhatsApp(context, params) {
			try {
				const response = await Api.apiPost('/integration_whatsapp/disabled', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async getIntegrationWhatsAppConfigIntegrationWhatsApp(context, params) {
			try {
				const response = await Api.apiPost('/integration_whatsapp/getIntegrationWhatsApp', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async getStatusIntegrationWhatsAppConfigIntegrationWhatsApp(context, params) {
			try {
				const response = await Api.apiPost('/integration_whatsapp/getStatusIntegrationWhatsApp', params);
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}