import { createStore } from 'vuex';
import auth from './modules/auth';
import collaborator from './modules/collaborator';
import account from './modules/account';
import dashboard from './modules/dashboard';
import helpers from './modules/helpers';
import generate_options from './modules/generate_options';

import template from './modules/template';
import tracking from './modules/tracking';

/* Configuration */
import conf_integration_whatsapp from './modules/conf_integration_whatsapp';
import config_import from './modules/config_import';

import createPersistedState from "vuex-persistedstate";
import SecureLS from "secure-ls";

/* Administrator */
import admin_access from './modules/admin_access';
import admin_token_whatsappweb from './modules/admin_token_whatsappweb';
import admin_resource from './modules/admin_resource';

var ls = new SecureLS({ isCompression: false });

export default createStore({
	state: {
		toggleSidebar: true,
		addMenuId: 0,
		preloader: false,
		requiredPageAuth: '',
	},
	mutations: {
		CHANGE_TOGGLE_SIDEBAR (state, status) {
			state.toggleSidebar = !status
		},
		ADD_MENU_ID (state, id) {
			state.addMenuId = id
		},
		CHANGE_LOADING (state, status) {
			state.preloader = status
		},
		CHANGE_META_AUTH (state, status) {
			state.requiredPageAuth = status
		}
	},
	actions: {
	},
	modules: {
		auth,
		collaborator,
		account,
		helpers,
		generate_options,
		dashboard,
		admin_access,
		admin_token_whatsappweb,
		admin_resource,
		template,
		conf_integration_whatsapp,
		config_import,
		tracking
	},
	plugins: [
    createPersistedState({
			paths: ['auth'],
      storage: {
        getItem: (key) => ls.get(key),
        setItem: (key, value) => ls.set(key, value),
        removeItem: (key) => ls.remove(key),
      },
    }),
  ],
})
