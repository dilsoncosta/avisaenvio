
import Api from "../../../helpers/Api";

export default {
	state: {},
	mutations: {},
	actions: {
		async getTenants(context, params) {
			try {
				const response = await Api.apiPost('/listOfTenants', params);
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfCollaborators(context, params) {
			try {
				const response = await Api.apiPost('/listOfCollaborators', params);

				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfClients(context, params) {
			try {
				const response = await Api.apiPost('/listOfClients', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfSegmentatonsFranchise(context, params) {
			try {
				const response = await Api.apiPost('/listOfSegmentatonsFranchise', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listCep(context, params) {
			try {
				const response = await Api.apiPost('/listCep', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfCities(context, params) {
			try {
				const response = await Api.apiPost('/listOfCities', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfStates(context, params) {
			try {
				const response = await Api.apiPost('/listOfStates', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfFranchises(context, params) {
			try {
				const response = await Api.apiPost('/listOfFranchises', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfTrainings(context, params) {
			try {
				const response = await Api.apiPost('/listOfTrainings', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfModulesOfTraining(context, params) {
			try {
				const response = await Api.apiPost('/listOfModulesOfTraining', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfCategoriesOfMaterial(context, params) {
			try {
				const response = await Api.apiPost('/listOfCategoriesOfMaterial', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfBusiness(context, params) {
			try {
				const response = await Api.apiPost('/listOfBusiness', params);

				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async listOfFunnels(context, params) {
			try {
				const response = await Api.apiPost('/listOfFunnels', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async checkSubdomain(context, params) {
			try {
				const response = await Api.apiPost('/checkSubdomain', params);
				return Promise.resolve(response.data.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		}
	}
}