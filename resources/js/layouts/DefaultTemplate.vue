<template>
	<div class="sidebar-wrapper" v-if="toggleSidebar">
		<sidebar-component/>
	</div>
	<div class="page-content-wrapper">
		<header-component/>
		<router-view></router-view>
	</div>
</template>
<style scoped>
.sidebar-wrapper {
	max-width: 250px;
	width: 250px;
}
.page-content-wrapper {
	flex:1;
	width:100vh;
}
</style>
<script setup>
import { onBeforeMount, computed } from 'vue'
import { useStore } from 'vuex';
import SidebarComponent from './components/SidebarComponent.vue';
import HeaderComponent from './components/HeaderComponent.vue';

/* Ref or Reactive */
const store = useStore();

/* Events */
const toggleSidebar = computed(() => store.state.toggleSidebar);

onBeforeMount(() => {
	document.title = 'Controlei';
});
</script>