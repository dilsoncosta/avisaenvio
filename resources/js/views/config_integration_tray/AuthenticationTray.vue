<template>
	<div id="container">
		<div id="header">
			<h2>Integração Tray</h2>
		</div>
		<div id="message">
			<p>Instalação concluída com sucesso. Feche esta janela.</p>
		</div>
	</div>
</template>

<style scoped>
#container {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	margin-top: 70px;
	margin-bottom: 70px;
	flex:1;
}
#header {
	text-align: center;
}
input[name=name], input[name=surname] {
  text-transform: uppercase;
}
#header h2 {
	font-size: 28px;
	font-weight: 900;
	color: #000000;
}
#header p {
	margin-top: 5px;
	font-size: 14px;
	color: #2957a7;
}
#header #instruction {
	width: 400px;
}
#message {
	margin: 20px;
	background-color: #d1e7dd;
	padding: 10px;
	border-radius: 5px;
	border: 1px solid #badbcc;
	font-size: 14px;
	color: #0f5132;
}
</style>
<script setup>
import { onMounted } from 'vue';
import router from '@/router';
import { useStore } from 'vuex';
import { empty, show_msgbox } from '@/helpers/Helpers';

/* Ref or Reactive */
const store       = useStore();

/* Events */
onMounted(async () => {
	store.commit('CHANGE_LOADING', true);
	
	if(empty(router.currentRoute.value.query.adm_user) || empty(router.currentRoute.value.query.store_plan) ||
	empty(router.currentRoute.value.query.token) || empty(router.currentRoute.value.query.user_id) ||
	empty(router.currentRoute.value.query.store_host) || empty(router.currentRoute.value.query.store) ||
	empty(router.currentRoute.value.query.api_address) || empty(router.currentRoute.value.query.code))
	{
		return show_msgbox('Incapaz de processar a solicitação!', 'error');
	}

	try {
		await store.dispatch('activeAutenticationTray', {
			api_address : router.currentRoute.value.query.api_address,
			adm_user : router.currentRoute.value.query.adm_user,
			user_id : router.currentRoute.value.query.user_id,
			code : router.currentRoute.value.query.code,
			store_plan : router.currentRoute.value.query.store_plan,
			store : router.currentRoute.value.query.store,
			store_host : router.currentRoute.value.query.store_host,
		});
	}
	catch(error)
	{
		if(error.status != 404)
		{
			return show_msgbox(error.data.message, 'warning');
		}
	}
	
	store.commit('CHANGE_LOADING', false);
});
</script>
