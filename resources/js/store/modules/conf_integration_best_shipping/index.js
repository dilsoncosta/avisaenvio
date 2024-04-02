
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {}
	},
	mutations: {},
	actions: {
		async activeConfigIntegrationBestShipping(_, params) {
			try {
				const response = await Api.apiPost('/integration_best_shipping/active', params);
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async disabledConfigIntegrationBestShipping(context, params) {
			try {
				const response = await Api.apiPost('/integration_best_shipping/disabled', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async getStatusIntegrationBestShippingConfigIntegrationBestShipping(context, params) {
			try {
				const response = await Api.apiPost('/integration_best_shipping/getStatusIntegrationBestShipping', params);
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}