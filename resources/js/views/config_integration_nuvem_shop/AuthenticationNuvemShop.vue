<template>
	<div id="container">
		<div id="header">
			<h2>Integração Nuvem Shop</h2>
			<p id="instruction">Copie ID  do Aplicativo e Código da Loja e cole no campo ID do Aplicativo e Código da Loja na página de integração Nuvem Shop no Avisa APP.</p>
		</div>
		<div id="instruction_data">
			<p>ID do Aplicativo: {{ idApp }}</p>
			<p>Código da Loja: {{ code }}</p>
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
#instruction_data {
	margin-top: 40px;
	background-color: #fff;
	width: 550px;
	box-shadow: 0 0 3px #ddd;
	padding: 20px 40px;
}
#instruction_data div {
	margin: 15px 0px;
}
#instruction_data label{
	font-size: 14px;
	color: #000;
	opacity: 1;
}
</style>
<script setup>
import { ref, watch, onMounted } from 'vue';
import router from '@/router';

import { useRoute } from 'vue-router';
import { empty, show_msgbox } from '@/helpers/Helpers';

/* Ref or Reactive */
const route = useRoute();
const idApp = ref("");
const code = ref("");

/* Events */
onMounted(async () => {

	if(empty(route.params.id) || empty(router.currentRoute.value.query.code))
	{
		return show_msgbox('Incapaz de processar a solicitação!', 'error');
	}

	idApp.value = route.params.id;
	code.value = router.currentRoute.value.query.code;
});
</script>
