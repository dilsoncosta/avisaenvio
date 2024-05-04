import { createRouter, createWebHistory } from 'vue-router';
import Register from '../views/auth/Register.vue';
import ConfirmRegister from '../views/auth/ConfirmRegister.vue';
import Login from '../views/auth/Login.vue';
import ForgotPassword from '../views/auth/ForgotPassword.vue';
import ResetPassword from '../views/auth/ResetPassword.vue';
import Home from '../views/Home.vue';
import Profile from '../views/profile/Profile.vue';

import Template from '../views/template/Template.vue';
import Order from '../views/order/Order.vue';
import Hospitality from '../views/config_hospitality/ConfigHospitality.vue';
import Guest from '../views/guest/Guest.vue';

// Configs
import ConfigIntegrationWhatsApp from '../views/config_integration_whatsapp/ConfigIntegrationWhatsApp.vue';
import ConfigImportOrder from '../views/config_import_order/ConfigImportOrder.vue';
import ConfigIntegrationBestShipping from '../views/config_integration_best_shipping/ConfigIntegrationBestShipping.vue';
import ConfigFinancial from '../views/config_financial/ConfigFinancial.vue';

import ConfigAuthenticationNuvemShop from '../views/config_integration_nuvem_shop/AuthenticationNuvemShop.vue';
import ConfigIntegrationNuvemShop from '../views/config_integration_nuvem_shop/ConfigIntegrationNuvemShop.vue';

// Configuration
import Collaborator from '../views/collaborator/Collaborator.vue';

// Administrador
import adminAccess from '../views/admin_access/Access.vue';
import adminTokenWhatsAppWeb from '../views/admin_token_whatsappweb/AdminTokenWhatsAppWeb.vue';

// Helpers
import store from "@/store/index";
import Api from "@/helpers/Api";
import { NAME_TOKEN } from '../configs';

// Validated Subdomain
const requireDomainExists = async (to, from, next) => {
	const token            = await localStorage.getItem(NAME_TOKEN);
	const subdomainCurrent = window.location.hostname.split('.')[0];
	const subdomain        = store.state.auth.me.subdomain;
	
	if(!token)
	{
		try {
			await Api.apiPost('/checkSubdomain', {
				"subdomain" : subdomainCurrent
			});
			next();
			return;
		}
		catch(error) {
			next('/404');
			return;
		}
	}
	
	if(subdomain != subdomainCurrent)
	{
		next('/404');
		return;
	}
	
	next();
}

const routes = [
	{
		path: '/',
		name: 'DefaultTemplate',
		component: () => import('@/layouts/DefaultTemplate.vue'),
		beforeEnter: requireDomainExists,
		children: [
			{
				path: '',
				name: 'home',
				component: Home,
				meta: { 
					auth: true,
					can: ['show-home']
				}
			},
			{
				path: '/template',
				name: 'template',
				component: Template,
				meta: { 
					auth: true,
					can: ['show-template', 'show-validated-access', 'access_template']
				}
			},
			{
				path: '/order',
				name: 'order',
				component: Order,
				meta: { 
					auth: true,
					can: ['show-order', 'show-validated-access', 'access_order']
				}
			},
			{
				path: '/guest',
				name: 'guest',
				component: Guest,
				meta: { 
					auth: true,
					can: ['show-guest', 'show-validated-access', 'access_guest']
				}
			},
			{
				path: '/config/hospitality',
				name: 'hospitality',
				component: Hospitality,
				meta: { 
					auth: true,
					can: ['show-config-hospitality', 'show-validated-access', 'access_config_hospitality']
				}
			},
			// Configuration
			{
				path: '/collaborator',
				name: 'collaborator',
				component: Collaborator,
				meta: { 
					auth: true,
					can: ['show-collaborator', 'show-validated-access', 'access_config_collaborator']
				}
			},
			{
				path: '/config/integration_whatsapp',
				name: 'config.integration_whatsapp',
				component: ConfigIntegrationWhatsApp,
				meta: { 
					auth: true,
					can: ['show-integartion-whatsapp', 'show-validated-access', 'access_config_integration_whatsapp']
				}
			},
			{
				path: '/config/integration_best_shipping',
				name: 'config.integration_best_shipping',
				component: ConfigIntegrationBestShipping,
				meta: { 
					auth: true,
					can: ['show-best-shipping', 'show-validated-access', 'access_config_integration_best_shipping']
				}
			},
			{
				path: '/config/integration_nuvem_shop',
				name: 'config.integration_nuvem_shop',
				component: ConfigIntegrationNuvemShop,
				meta: { 
					auth: true,
					can: ['show-best-shipping', 'show-validated-access', 'access_config_integration_nuvem_shop']
				}
			},
			{
				path: '/config/import_order',
				name: 'config.import_order',
				component: ConfigImportOrder,
				meta: { 
					auth: true,
					can: ['show-import-order', 'show-validated-access', 'access_config_import_order']
				}
			},
			{
				path: '/config/financial',
				name: 'config.financial',
				component: ConfigFinancial,
				meta: { 
					auth: true,
					can: ['show-financial', 'access_config_financial']
				}
			},
			// End Configuration
			{
				path: '/profile',
				name: 'profile',
				component: Profile,
				meta: { 
					auth: true,
					can: ['show-profile']
				}
			},
			// Administrador
			{
				path: '/admin/access',
				name: 'admin.access',
				component: adminAccess,
				meta: { 
					auth: true,
					can: ['show-admin']
				}
			},
			{
				path: '/admin/token-whatsappweb',
				name: 'admin.token-whatsappweb',
				component: adminTokenWhatsAppWeb,
				meta: { 
					auth: true,
					can: ['show-admin']
				}
			},
		],
	},
	{
		path: '/register',
		name: 'register',
		component: Register,
		beforeEnter: requireDomainExists,
		meta: { auth: false }
	},
	{
		path: '/register/confirm/:token',
		name: 'register-confirm',
		component: ConfirmRegister,
		beforeEnter: requireDomainExists,
		meta: { auth: false }
	},
	{
		path: '/login',
		name: 'login',
		component: Login,
    beforeEnter: requireDomainExists,
		meta: { auth: false }
	},
	{
		path: '/forgot-password/',
		name: 'forgot-password',
		component: ForgotPassword,
		beforeEnter: requireDomainExists,
		meta: { auth: false }
	},
	{
		path: '/reset-password/:id',
		name: 'reset-password',
		beforeEnter: requireDomainExists,
		component: ResetPassword,
		meta: { auth: false }
	},
	{
		path: '/404',
		name: 'error404',
		component: () => import('../views/NotFound.vue'),
		meta: { auth: false },
	},
	{
		path: '/authentication_nuvem_shop/:id',
		name: 'authentication-nuveme-shop',
		component: ConfigAuthenticationNuvemShop,
    beforeEnter: requireDomainExists,
		meta: { auth: false }
	},
	{
		path: '/:catchAll(.*)',
		redirect: '/404',
		meta: { auth: false },
	}
]

const router = createRouter({
	history: createWebHistory(),
	routes
});

router.beforeEach(async (to, from, next) => {
	const loggedIn  = store.state.auth.authenticated;
	
	store.commit('CHANGE_META_AUTH', to.meta.auth);
	
	if(to.meta.auth && !loggedIn){
		const token = await localStorage.getItem(NAME_TOKEN);
		
		if(!token)
		{
			router.push({name : 'login'});
		}
	}
	
	next();
});

export default router
