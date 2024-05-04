
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {}
	},
	mutations: {},
	actions: {
		async activeConfigIntegrationNuvemShop(_, params) {
			try {
				const response = await Api.apiPost('/integration_nuvem_shop/active', params);
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async disabledConfigIntegrationNuvemShop(context, params) {
			try {
				const response = await Api.apiPost('/integration_nuvem_shop/disabled', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async getStatusIntegrationNuvemShopConfigIntegrationNuvemShop(context, params) {
			try {
				const response = await Api.apiPost('/integration_nuvem_shop/getStatusIntegrationNuvemShop', params);
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}