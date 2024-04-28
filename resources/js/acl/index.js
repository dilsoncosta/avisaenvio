import router from "../router"; 
import store from "../store";

import { computed, toRaw } from 'vue';
import { createAcl, defineAclRules } from 'vue-simple-acl';

const user = computed(() => toRaw(store.state.auth.me));

let onDeniedRoute = '/';


if(store.state.auth.authenticated == true && user.value.category != 'MT' && user.value.access != 'A')
{
	onDeniedRoute = '/config/financial';
}

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
	setRule('show-best-shipping', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-integartion-whatsapp', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-import-order', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-financial', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-help', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-order', () => {
		return (user.value.category == 'CL' || user.value.category == 'CLB') && user.value.ind_mod_order_tracking == 1;
	});
	setRule('show-guest', () => {
		return (user.value.category == 'CL' || user.value.category == 'CLB') && user.value.ind_mod_hotel == 1;
	});
	setRule('show-template', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-validated-access', () => {
		return user.value.access == 'A';
	});
	setRule('show-config-integration-whatsapp', () => {
		return user.value.category == 'CL' || user.value.category == 'CLB';
	});
	setRule('show-config-integration-best-shipping', () => {
		return (user.value.category == 'CL' || user.value.category == 'CLB') && user.value.ind_mod_order_tracking == 1;
	});
	setRule('show-config-hospitality', () => {
		return (user.value.category == 'CL' || user.value.category == 'CLB') && user.value.ind_mod_hotel == 1;
	});
	setRule('show-config-import', () => {
		return (user.value.category == 'CL' || user.value.category == 'CLB') && user.value.ind_mod_order_tracking == 1;;
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

	// Module Order
	setRule('access_order', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'access_order');
	});
	setRule('view_order', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'view_order');
	});
	setRule('edit_order', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'edit_order');
	});
	setRule('delete_order', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'delete_order');
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
	
	// Module Config Import Order
	setRule('access_config_import_order', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'access_config_import_order');
	});
	
	// Module Config Integration Best Billing
	setRule('access_config_integration_best_shipping', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'access_config_integration_best_shipping');
	});
	
	// Module Config Hospitality
	setRule('access_config_hospitality', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'access_config_hospitality');
	});

	// Module Config Financial
	setRule('access_config_financial', () => {
		return true;
		//if(user.value.category == 'CL'){ return true; }
		//return user.value.permissions.find(permission => permission.name === 'access_config_financial');
	});
	
	// Module Guest
	setRule('access_guest', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'access_guest');
	});
	setRule('view_guest', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'view_guest');
	});
	setRule('edit_guest', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'edit_guest');
	});
	setRule('delete_guest', () => {
		if(user.value.category == 'CL'){ return true; }
		return user.value.permissions.find(permission => permission.name === 'delete_guest');
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