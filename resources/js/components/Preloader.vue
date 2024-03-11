<template>
	<div class="vl-parent" v-if="preloader.isLoading"><div tabindex="0" class="vl-overlay vl-active vl-full-page" aria-busy="true" aria-label="Loading"><div class="vl-background" style="background: rgb(0, 0, 0);"></div><div class="vl-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" height="112" width="112" fill="#007bff"><rect x="0" y="13" width="4" height="5"><animate attributeName="height" attributeType="XML" values="5;21;5" begin="0s" dur="0.6s" repeatCount="indefinite"></animate><animate attributeName="y" attributeType="XML" values="13; 5; 13" begin="0s" dur="0.6s" repeatCount="indefinite"></animate></rect><rect x="10" y="13" width="4" height="5"><animate attributeName="height" attributeType="XML" values="5;21;5" begin="0.15s" dur="0.6s" repeatCount="indefinite"></animate><animate attributeName="y" attributeType="XML" values="13; 5; 13" begin="0.15s" dur="0.6s" repeatCount="indefinite"></animate></rect><rect x="20" y="13" width="4" height="5"><animate attributeName="height" attributeType="XML" values="5;21;5" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate><animate attributeName="y" attributeType="XML" values="13; 5; 13" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate></rect></svg></div></div></div>
</template>
<style scoped>
.vl-shown {
	overflow: hidden;
}
.vl-overlay {
	bottom: 0;
	left: 0;
	position: absolute;
	right: 0;
	top: 0;
	align-items: center;
	display: none;
	justify-content: center;
	overflow: hidden;
	z-index: 9999;
}
.vl-overlay.vl-active {
	display: flex;
}
.vl-overlay.vl-full-page {
	z-index: 9999;
	position: fixed;
}
.vl-overlay .vl-background {
	bottom: 0;
	left: 0;
	position: absolute;
	right: 0;
	top: 0;
	background: #fff;
	opacity: 0.5;
}
.vl-overlay .vl-icon, .vl-parent {
	position: relative;
}
</style>
<script setup>
import { computed } from 'vue';
import { reactive } from '@vue/reactivity';
import { useStore } from 'vuex';

/* Ref or Reactive */
const store = useStore();
const preloader = reactive({
	isLoading: false,
});

/* Events */
preloader.isLoading = computed(() => store.state.preloader);
</script>