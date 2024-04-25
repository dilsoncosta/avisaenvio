
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {}
	},
	mutations: {
		SET_FINANCIAL (state, financials) {
			state.data = financials;
		},
	},
	actions: {
		async getFinancial(context, params) {
			try {
				const response = await Api.apiPost('/financial', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				context.commit('SET_FINANCIAL', []);
				return Promise.reject(error);
			}
		},
		async getChargeFinancial(context, params) {
			try {
				const response = await Api.apiPost('/financial/charge', params);
				return Promise.resolve(response.data.data.data);
			}
			catch(error) {
				context.commit('SET_FINANCIAL', []);
				return Promise.reject(error);
			}
		},
		async insertSignatureFinancial(_, params) {
			try {
				const response = await Api.apiPost('/financial/createSignature', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async canceledSignatureFinancial(_, params) {
			try {
				const response = await Api.apiPost('/financial/canceledSignature', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
	}
}