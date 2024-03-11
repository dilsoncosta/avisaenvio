import router from "../router"; 
import store from "../store";

import { computed, toRaw } from 'vue';
import { createAcl, defineAclRules } from 'vue-simple-acl';

const user = computed(() => toRaw(store.state.auth.me));

let onDeniedRoute = '/';

/*
if(store.state.auth.authenticated == true && user.value.category != 'MT' && user.value.access != 'A')
{
	//onDeniedRoute = '/access-expiration';
	onDeniedRoute = '/';
}
*/

const rules = () => defineAclRules((setRule) => {
	setRule('show-home', () => {
		return true;
	});
	setRule('show-profile', () => {
		return true;
	});
	setRule('show-admin', () => {
		return user.value.category == 'MT';
	});
	setRule('show-account', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-settings', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-collaborator', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-help', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-validated-access', () => {
		return user.value.access == 'A';
	});

	// Start List Permissions
	
	// Module Franchise
	setRule('access_template', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'access_template');
	});
	setRule('view_template', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'view_template');
	});
	setRule('edit_template', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'edit_template');
	});
	setRule('delete_template', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'delete_template');
	});

	// Module Tracking
	setRule('access_tracking', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'access_tracking');
	});
	setRule('view_tracking', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'view_tracking');
	});
	setRule('edit_tracking', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'edit_tracking');
	});
	setRule('delete_tracking', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'delete_tracking');
	});
	
	// Module Config Collaborator
	setRule('access_config_collaborator', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'access_config_collaborator');
	});
	setRule('view_config_collaborator', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'view_config_collaborator');
	});
	setRule('edit_config_collaborator', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'edit_config_collaborator');
	});
	setRule('delete_config_collaborator', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'delete_config_collaborator');
	});
	
	// Module Config Integration WhatsApp
	setRule('access_config_integration_whatsapp', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'access_config_integration_whatsapp');
	});
	
	// End List Permissions
});

const simpleAcl = createAcl({
	user,
	rules,
	router,
	onDeniedRoute: { path: onDeniedRoute, replace: true }
});

export default simpleAcl;