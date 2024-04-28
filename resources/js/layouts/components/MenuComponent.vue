<template>
	<div>
		<ul class="accordion-menu">
			<li :class="menu.open ? {'link' :'link', 'active': 'active'} : ''" v-for="(menu, i) in menus" :key="i" @click.prevent="toggleMenu(i)" v-can="menu.can[0]">
				<router-link :to="menu.href" v-if="menu.type == 0 && (user_category == 'CL' || user_category == 'MT' || $can(menu.can[1]))" >
					<div class="dropdown" 
						:style="[itemMenuHover === i ?  'background-color:#05314A;color:#fff;' : '']"
						@mouseover="itemMenuHover = i"
						@mouseleave="itemMenuHover = null"
						>
						<i :class="menu.icon"></i>
						{{ menu.title }}
						<i class="fas fa-chevron-down" v-if="menu.type == 1"></i>
					</div>
				</router-link>
				<router-link :to="menu.href" v-if="menu.type == 0 && !$can(menu.can[1])" >
					<div class="dropdown" 
						:style="[itemMenuHover === i ? 'background-color:#05314A;color:#fff;': 'color: #c8c8c8; cursor: pointer;']"
						@mouseover="itemMenuHover = i"
						@mouseleave="itemMenuHover = null"
						>
						<i :class="menu.icon"></i>
						{{ menu.title }}
						<i class="fas fa-chevron-down" v-if="menu.type == 1"></i>
					</div>
				</router-link>
				<div class="dropdown" v-if="menu.type == 1"
					:style="[itemMenuHover === i ? 'background-color:#05314A;color:#fff;': '']"
					@mouseover="itemMenuHover = i"
					@mouseleave="itemMenuHover = null"
				>
					<i :class="menu.icon"></i>
					{{ menu.title }}
					<i class="fas fa-chevron-down"></i>
				</div>
				<ul class="submenuItems" v-if="menu.type == 1">
					<li v-for="(submenu, index) in menu.submenus" :key="index" :class="submenu.open ? {'link' :'link', 'active': 'active'} : ''"
					v-can="submenu.can[0]">
						<router-link :to="submenu.href"
						v-if="user_category == 'CL' || user_category == 'MT' || $can(submenu.can[1])"
						:style="[itemSubmenuHover === index ? 'background-color:#05314A;color:#fff;': '']"
						@mouseover="itemSubmenuHover = index"
						@mouseleave="itemSubmenuHover = null"
						>
							<div v-if="submenu.type == 1" class="subSubmenuDropDown" 
								@click.prevent="toggleSubSubMenu(i, index)">
								{{ submenu.title }}
								<i class="fas fa-chevron-down"></i>
							</div>
							<div v-else >
								{{ submenu.title }}
							</div>
						</router-link>
						<router-link :to="submenu.href"
						v-else
						:style="[itemSubmenuHover === index ? 'background-color:#05314A;color:#fff;': 'color: #c8c8c8; cursor: not-allowed;']"
						@mouseover="itemSubmenuHover = index"
						@mouseleave="itemSubmenuHover = null"
						> {{ submenu.title}} </router-link>
						
						<ul class="subSubmenuItems" v-if="submenu.type == 1 && submenu.open">
							<li v-for="(subSubmenu, index) in submenu.submenus" :key="index" >
								<router-link :to="subSubmenu.href"
								:style="[itemSubSubmenuHover === index ? 'background-color:#05314A;color:#fff;': '']"
								@mouseover="itemSubSubmenuHover = index"
								@mouseleave="itemSubSubmenuHover = null"
								>{{ subSubmenu.title }}</router-link>
							</li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</template>
<style scoped>
a {
	text-decoration: none;
}
.accordion-menu {
	max-width: 250px;
	margin: 20px auto 20px;
	overflow: hidden;
}
.accordion-menu .link :hover, .accordion-menu .link :active{
	color:#fff;
}
.accordion-menu li:last-child .dropdown{
	border-bottom: 0;
}
.accordion-menu li.active .dropdown {
	color: #000;
}
.accordion-menu li.active .dropdown:hover {
	color: #fff;
}
.accordion-menu li.active .dropdown .fa-chevron-down {
	transform: rotate(180deg);
}
.dropdown{
	cursor: pointer;
	display: block;
	padding: 16px 15px 15px 45px;
	position: relative;
	font-size: 15px;
	color: #454550;
}
.dropdown i {
	position: absolute;
	top: 17px;
	left:16px
}
.dropdown .fa-chevron-down {
	right: 20px;
	left: auto;
}
.submenuItems {
	display: none;
}
.accordion-menu li.active .submenuItems {
	display: block;
	color: #ffff;
	transition: opacity 0.5s ease-in-out;
}
.submenuItems a {
	display: block;
	color: #454550;
	padding: 10px 12px 10px 50px;
	cursor: pointer;
	font-size: 12px;
	text-decoration: none;
}

/* Menu do Submenu */
.subSubmenuDropDown {
	cursor: pointer;
	display: block;
	position: relative;
	font-size: 12px;
}
.subSubmenuDropDown .fa-chevron-down {
	left: auto;
}
.subSubmenuDropDown i {
	float:right;
	right:16px;
	padding-right: 10px;
	font-size:15px;
}
.subSubmenuItems {
	display: none;
}
li.active .subSubmenuItems {
	display: block;
	color: #ffff;
	transition: opacity 0.5s ease-in-out;
}
li.active .submenuItems li.active .fa-chevron-down {
	transform: rotate(180deg);
	margin-right: 9px;
}
.subSubmenuItems a {
	display: block;
	padding-left:60px;
	color: #454550;
	cursor: pointer;
	font-size: 12px;
	text-decoration: none;
}
</style>
<script setup>
import { onMounted, ref, computed } from 'vue';
import { useStore } from 'vuex';

/* Ref or Reactive */
const store            = useStore();
const user_category    = computed(() => store.state.auth.me.category);
const itemMenuHover    = ref(null);
const itemSubmenuHover = ref(null);
const itemSubSubmenuHover = ref(null);
let menus = ref([
	{
		icon: 'fas fa-tachometer-alt fa-fw fa-lg',
		type: 0,
		title: 'Dashboard',
		open: false,
		href: '/',
		can: ['show-home', 'show-home'],
		submenus : []
	},
	{
		icon: 'fas fa-align-left',
		type: 0,
		title: 'Pedido',
		open: false,
		href: '/order',
		can: ['show-order', 'access_order'],
		submenus : []
	},
	{
		icon: 'fas fa-comment fa-lg',
		type: 0,
		title: 'Template',
		open: false,
		href: '/template',
		can: ['show-template', 'access_template'],
		submenus : []
	},
	{
		icon: 'fas fa-archway fa-lg',
		type: 0,
		title: 'Hospede',
		open: false,
		href: '/guest',
		can: ['show-guest', 'access_guest'],
		submenus : []
	},
	{
		icon: 'fas fa-cog fa-fw fa-lg',
		type: 1,
		title: 'Configuração',
		open: false,
		can: ['show-settings'],
		submenus : [
			{
				title: 'Colaborador',
				href: '/collaborator',
				can: ['show-collaborator', 'access_config_collaborator'],
			},
			{
				title: 'Integração WhatsApp',
				href: '/config/integration_whatsapp',
				can: ['show-config-integration-whatsapp', 'access_config_integration_whatsapp'],
			},
			{
				title: 'Integração Melhor Envio',
				href: '/config/integration_best_shipping',
				can: ['show-config-integration-best-shipping', 'access_config_integration_best_shipping'],
			},
			{
				title: 'Hotelaria',
				href: '/config/hospitality',
				can: ['show-config-hospitality', 'access_config_hospitality'],
			},
			{
				title: 'Importação',
				href: '/config/import_order',
				can: ['show-config-import', 'access_config_import_order'],
			},
			{
				title: 'Financeiro',
				href: '/config/financial',
				can: ['show-config-import', 'access_config_financial'],
			}
		]
	},
	{
		icon: 'fas fa-question-circle',
		type: 1,
		title: 'Ajuda',
		open: false,
		href: '/portal/manager',
		can: ['show-help'],
		submenus : [
			{
				title: 'Suporte',
				href: '/',
				can: ['show-home', 'show-home'],
			},
			{
				title: 'Tutoriais',
				href: '/',
				can: ['show-home', 'show-home'],
			},
			{
				title: 'O que há de novo?',
				href: '/',
				can: ['show-home', 'show-home'],
			}
		]
	},
		
	// Menu Administrator
	{
		icon: 'fas fa-key fa-lg',
		type: 0,
		title: 'Acesso',
		open: false,
		href: '/admin/access',
		can: ['show-admin', 'show-admin'],
		submenus : []
	},
	{
		icon: 'fab fa-whatsapp-square fa-lg',
		type: 0,
		title: 'Token WhatsApp Web',
		open: false,
		href: '/admin/token-whatsappweb',
		can: ['show-admin', 'show-admin'],
		submenus : []
	},
]);

/* Events */
onMounted(() => {
	menus.value.forEach((menu, index) => {
		const menu_id = localStorage.getItem('menu_id');
		
		if(index == menu_id){
			menu.open = true;
		} else {
			menu.open = false;
		}
	});
});

/* Functions */
const toggleMenu = (index) => {
	menus.value.forEach((menu, i) => {
		menu.submenus.open = false;
		
		if(index === i){
			localStorage.setItem('menu_id',index);
			
			menu.open = true;
		} else {
			menu.open = false;
		}
	});
}

const toggleSubSubMenu = (index_menu, indexsubmenu) => {
  menus.value[index_menu].submenus.forEach((item, index) => {
		if(index === indexsubmenu){
			localStorage.setItem('sub_submenu_id',index);
			
			item.open = true;
		} else {
			item.open = false;
		}
	});
};
</script>