<template>
	<div id="container">
		<div id="container-item">
			<div id="header">
				<h2>Confirmação de Cadastro</h2>
			</div>
			<div :id="alert_class">
				<p>{{ alert_msg }}</p>
			</div>
			<div>
				<router-link :to="{name: 'login'}"><i class="fas fa-arrow-circle-left"></i> Área de Login</router-link>
			</div>
		</div>
	</div>
</template>

<style scoped>
#container {
	display: flex;
	justify-content: center;
	align-items: center;
	flex:1;
}
#container-item {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
	margin-top: 70px;
	margin-bottom: 70px;
}
#alert_success {
	margin: 20px;
	background-color: #d1e7dd;
	padding: 10px;
	border-radius: 5px;
	border: 1px solid #badbcc;
	font-size: 14px;
	color: #0f5132;
}
#alert_danger {
	margin: 20px;
	background-color: #f8d7da;
	padding: 10px;
	border-radius: 5px;
	border: 1px solid #f5c2c7;
	font-size: 14px;
	color: #842029;
}
#container a {
	text-decoration: none;
	color: #2957a7;
	font-weight: 530;
	font-size: 14px;
}
</style>

<script setup>
import { onMounted, ref } from '@vue/runtime-core';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import Api from '@/helpers/Api';
import { empty, show_msgbox } from '@/helpers/Helpers';

/* Ref ou Reactive */
const store       = useStore();
const route       = useRoute();
const alert_class = ref('');
const alert_msg   = ref('');

/* Events */
onMounted(async () => {
	
	if(empty(route.params.token))
	{
		return show_msgbox('Incapaz de processar a solicitação!', 'error');
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		await Api.apiPost('/confirmed-register',{
			token : route.params.token
		});
		
		alert_class.value = 'alert_success';
		alert_msg.value   = 'Cadastro confirmado com sucesso!';
	}
	catch(error) {
		alert_class.value = 'alert_danger';
		alert_msg.value   = error.data.message;
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
});
</script>



