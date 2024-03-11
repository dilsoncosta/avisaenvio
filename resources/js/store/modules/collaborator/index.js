
import Api from "../../../helpers/Api";

export default {
	state: {
		data: [],
		filters: {
			srch_username: '',
			srch_email : '',
			srch_situation: ''
		}
	},
	mutations: {
		SET_COLLABORATORS (state, collaborators) {
			state.data = collaborators;
		},
		SET_FILTERS (state, filters) {
			state.filters.srch_username = filters.srch_username;
			state.filters.srch_email = filters.srch_email;
			state.filters.srch_situation = filters.srch_situation;
		}
	},
	actions: {
		async getCollaborators(context, params) {
			try {
				const response = await Api.apiPost('/collaborator', params);
				context.commit('SET_COLLABORATORS', response.data.data);
				context.commit('SET_FILTERS', params);
			}
			catch(error) {
				context.commit('SET_COLLABORATORS', []);
				return Promise.reject(error);
			}
		},
		async insertCollaborator(_, params) {
			try {
				const response = await Api.apiPost('/collaborator/create', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async updateCollaborator(context, params) {
			try {
				const response = await Api.apiPost('/collaborator/update', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async destroyCollaborator(context, params) {
			try {
				const response = await Api.apiPost('/collaborator/destroy', params);
				return Promise.resolve(response.data.message);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async totalCollaborators() {
			try {
				const response = await Api.apiGet('/dashboard/totalCollaborators');
				return Promise.resolve(response.data);
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
		async getResourcesCollaborator(context, params) {
			try {
				const response = await Api.apiPost('/collaborator/resources', params);
				return response.data.data;
			}
			catch(error) {
				return Promise.reject(error);
			}
		},
	}
}