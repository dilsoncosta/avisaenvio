<template>
	<div class="sidebar">
		<div class="sidebar-avatar">
			<img :src="`${path_storage}/${logo_portal}`" alt="Avatar" v-if="logo_portal && (categoryProfile == 'FR' || categoryProfile == 'FRCLB')" width="180" height="100">
			<img src="@/assets/images/logo_header.png" alt="Logo" v-else width="140" height="60">
			<h3>{{ nameProfile }}</h3>
			<h6 v-if="categoryProfile == 'MT'">Master</h6>
			<h6 v-if="categoryProfile == 'CL'">Administrator</h6>
			<h6 v-if="categoryProfile == 'CLB'">Colaborador</h6>
			<h6 v-if="categoryProfile == 'FR'">Franqueado</h6>
			<h6 v-if="categoryProfile == 'FRCLB'">Colaborador do Franqueado</h6>
		</div>
		<nav class="menus">
			<MenuComponent/>
		</nav>
	</div>
</template>
<style scoped>
.sidebar {
	width: 250px;
	min-height: 100vh;
	height: 100%;
	min-width: 250px;
	background-color: #fff;
	display: flex;
	flex-direction: column;
	position: relative;
}
.sidebar-avatar {
	margin: 0 auto;
	margin-top: 20px;
}
.sidebar-avatar h6 {
	text-align: center;
}
.sidebar-avatar h3 {
	margin-top: 10px;
	font-size: 16px;
	text-align: center;
	line-height: 1.2;
	font-weight: 330;
}
</style>
<script setup>
import MenuComponent from './MenuComponent.vue';
import { useStore } from 'vuex';
import { computed } from '@vue/runtime-core';
import { limiteTextWithPoints } from '@/helpers/Helpers';

/* Ref or Reactive */
const store = useStore();
const path_storage = import.meta.env.VITE_APP_PATH_STORAGE;
const logo_portal = store.state.auth.me.logo_portal;

/* Events */
const nameProfile = computed(() => store.state.auth.me.people == 'F' ? limiteTextWithPoints(`${store.state.auth.me.name} ${store.state.auth.me.surname}`, 16) : limiteTextWithPoints(store.state.auth.me.corporate_name, 16));
const categoryProfile = computed(() => store.state.auth.me.category);
</script>