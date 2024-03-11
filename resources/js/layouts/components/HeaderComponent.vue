<template>
	<!--<header :style="{ backgroundColor: colorGeneral || '#2957a7'}">-->
	<header>
		<div>
			<a href="#" target="_self" class="navbar-brand" @click.prevent="toggleSidebar"><i class="fas fa-bars fa-lg"></i></a>
		</div>
		<div>
			<ul  @click="toggleProfile = !toggleProfile">
				<li v-if="avata_url">
					<img :src="avata_url" alt="Avatar">
				</li>
				<li v-else>
					<img src="@/assets/images/avatar_profile.jpeg" alt="Avatar">
				</li>
				<li>{{ nameProfile }}</li>
				<li><i class="fas fa-chevron-down"></i></li>
			</ul>
			<ul class="profile-dropdown" v-if="toggleProfile" id="profileDropdown">
				<li @click.prevent="handleProfile"><a href="#"><i class="fas fa-user"></i> Perfil</a></li>
				<li @click.prevent="handleLogout"><a href="#"><i class="far fa-sign-out"></i> Sair</a></li>
			</ul>
		</div>
	</header>
</template>
<style scoped>
header {
	display: flex;
	justify-content: space-between;
	height: 55px;
	background-color:#fff;
	border-bottom: 1px solid #dee4ec;
}
.navbar-brand {
	display: inline-block;
	color: #000;
	padding: 18px 15px;
}
header ul {
	display: flex;
	list-style: none;
	justify-content: center;
	align-items: center;
	cursor: pointer;
	height: 100%;
	margin-right: 17px;
}
header ul li{
	padding: 0px 3px;
	color: #000;
	font-size: 14px;
}
header ul li i{
	padding: 0px 3px;
	color: #000;
	font-size: 13px;
}
header ul li img {
	width: 32px;
	height: 32px;
	border-radius: 50%;
}
.profile-dropdown {
	background-color: #fff;
	position:absolute;
	width: 140px;
	height: auto;
	display: flex;
	flex-direction: column;
	justify-content: flex-start;
	align-items: flex-start;
	border-bottom-left-radius: 10px;
	border-bottom-right-radius: 10px;
	right: 0px;
}
.profile-dropdown li{
	padding: 10px;
	width: 100%;
}
.profile-dropdown li:hover {
	background-color: #EDEDED;
}
.profile-dropdown li a{
	text-decoration: none;
	font-size: 15px;
	color: #000;
}
.profile-dropdown li a i{
	color: #000;
}
</style>
<script setup>
import { ref, computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import router from '../../router';
import { limiteTextWithPoints } from '@/helpers/Helpers';

/* Ref or Reactive */
const store         = useStore();
const toggleProfile = ref(false);
const avata_url     = store.state.auth.me.avatar;

/* Events */
const statusToggleSidebar = computed(() => store.state.toggleSidebar);
const nameProfile = computed(() => store.state.auth.me.people == 'F' ? limiteTextWithPoints(`${store.state.auth.me.name} ${store.state.auth.me.surname}`, 16) : limiteTextWithPoints(store.state.auth.me.corporate_name), 16);

onMounted(() => {
	document.addEventListener('mousedown', (event) => {
		if (!event.target.closest('#profileDropdown')) {
			toggleProfile.value = false
		}
	});
});

/* Functions */
const toggleSidebar = () => {
	store.commit('CHANGE_TOGGLE_SIDEBAR', statusToggleSidebar.value);
}

const handleLogout = () => {
	store.dispatch('logout');
	router.push({ name: 'login'})
}

const handleProfile = () => {
	router.push({ name: 'profile'})
}
</script>