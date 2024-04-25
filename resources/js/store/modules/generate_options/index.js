
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
		},
		async generateOptionsTemplates(context, params) {
			try {
				const response = await Api.apiPost('/generateOptionsTemplates', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async generateOptionsStates(context, params) {
			try {
				const response = await Api.apiPost('/generateOptionsStates', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async generateOptionsCep(context, params) {
			try {
				const response = await Api.apiPost('/generateOptionsCep', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async generateOptionsCities(context, params) {
			try {
				const response = await Api.apiPost('/generateOptionsCities', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}