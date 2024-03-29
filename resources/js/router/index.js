import { createRouter, createWebHistory } from 'vue-router';
import Register from '../views/auth/Register.vue';
import ConfirmRegister from '../views/auth/ConfirmRegister.vue';
import Login from '../views/auth/Login.vue';
import ForgotPassword from '../views/auth/ForgotPassword.vue';
import ResetPassword from '../views/auth/ResetPassword.vue';
import Home from '../views/Home.vue';
import Profile from '../views/profile/Profile.vue';


import Template from '../views/template/Template.vue';
import Tracking from '../views/tracking/Tracking.vue';

// Configs
import ConfigIntegrationWhatsApp from '../views/config_integration_whatsapp/ConfigIntegrationWhatsApp.vue';
import ConfigImport from '../views/config_import/ConfigImport.vue';

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
					can: ['show-validated-access', 'access_template']
				}
			},
			{
				path: '/tracking',
				name: 'tracking',
				component: Tracking,
				meta: { 
					auth: true,
					can: ['show-tracking', 'show-validated-access', 'access_tracking']
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
					can: ['show-collaborator', 'show-validated-access', 'access_config_integration_whatsapp']
				}
			},
			{
				path: '/config/import_lead',
				name: 'config.import_lead',
				component: ConfigImport,
				meta: { 
					auth: true,
					can: ['show-collaborator', 'show-validated-access', 'access_config_import']
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
