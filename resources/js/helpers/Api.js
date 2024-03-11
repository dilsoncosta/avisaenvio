import axios from 'axios';
import {  NAME_TOKEN } from '../configs';

const BASE_URL = import.meta.env.VITE_APP_PATH_API;

const Api = {

	apiPost: async (endpoint, body) => {
		const token = localStorage.getItem(NAME_TOKEN);
		
		try {
			const response = await axios.post(`${BASE_URL}${endpoint}`, body, 
			{
				headers: {
					'Content-Type': 'multipart/form-data',
					'Authorization': `${token !== undefined ? 'Bearer '+token : ''}`
				}
			}
			);
			return Promise.resolve(response);
		}
		catch(error) {
			return Promise.reject(error.response);
		}
	},
	apiGet: async (endpoint) => {
		const token = localStorage.getItem(NAME_TOKEN);
		
		try {
			const response = await axios.get(`${BASE_URL}${endpoint}`,{
				headers: {
					'Authorization': `${token !== undefined ? 'Bearer '+token : ''}`
				}
			});
			return Promise.resolve(response);
		}
		catch(error) {
			return Promise.reject(error.response);
		}
	}
}
export default Api;