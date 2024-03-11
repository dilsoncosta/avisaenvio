<template>
	<div id="container">
		<div id="header">
			<h2>Conclusão de Recuperação de Conta</h2>
		</div>
		<div id="form_reset_password">
			<div>
				<label for="password">Usuário</label>
				<input type="text" name="username" id="username" v-model="username" maxlength="45" @keyup="validateUsername">
			</div>
			<div>
				<label for="password">Senha</label>
				<input type="password" name="password" id="password"  maxlength="45" v-model="password">
			</div>
				<div>
				<label for="confirm_password">Confirmação de Senha</label>
				<input type="password" name="confirm_password" id="confirm_password"  maxlength="45" v-model="confirm_password">
			</div>
			<div>
				<button @click.prevent="handleResetPassword">Concluir Recuperação</button>
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
#form_reset_password {
	margin-top: 40px;
	background-color: #fff;
	width: 450px;
	box-shadow: 0 0 3px #ddd;
	padding: 20px 40px;
}
#form_reset_password div {
	margin: 15px 0px;
}
#form_reset_password label{
	font-size: 14px;
	color: #000;
	opacity: 1;
}
#form_reset_password input {
	margin-top: 5px;
	width: 100%;
	border: 1px solid #ccc;
	padding: 10px;
	outline: 0;
	color: #6b7280;
}
button {
	width: 100%;
	padding: 10px;
	color: #fff;
	background-color: #2957a7;
	border: none;
	font-size: 14px;
	margin-top: 10px;
	cursor: pointer;
	transition: all ease .0.3s;
}
button:hover {
	opacity: .9;
}
input {
	font-size:12px;
}
#form_reset_password a {
	text-decoration: none;
	color: #2957a7;
	font-weight: 530;
	font-size: 14px;
}
@media(max-width: 500px){
	#form_reset_password {
		width: 100%;
	}
	#container {
		margin-left: 20px;
		margin-right: 20px;
	}
}
</style>
<script setup>
import { watch } from 'vue';
import { validatedUsername, empty, show_msgbox } from '@/helpers/Helpers';
import { ref } from '@vue/reactivity';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import router from '@/router';
import Api from '@/helpers/Api';

/* Ref ou Reactive */
const store            = useStore();
const route            = useRoute();
const username         = ref('');
const password         = ref('');
const confirm_password = ref('');

/* Events */
watch(() => store.state.auth.authenticated,
	(loggedIn) => {
		if (loggedIn) {
			router.push({name: 'home'})
		}
	}
);

/* Functions */
const validateUsername = () => {
	username.value = validatedUsername(username.value);
}

const  handleResetPassword = async () => {
	if(empty(route.params.id))
	{
		return show_msgbox('Incapaz de processar a solicitação!', 'error');
	}
	if(empty(username.value))
	{
		return show_msgbox('O Campo USUÁRIO é obrigatório!', 'warning');
	}
	if(empty(password.value))
	{
		return show_msgbox('O Campo SENHA é obrigatório!', 'warning');
	}
	if(empty(confirm_password.value))
	{
		return show_msgbox('O Campo CONFIRMAÇÃO DE SENHA é obrigatório!', 'warning');
	}
	if(confirm_password.value !== password.value)
	{
		return show_msgbox('A confirmação da senha não corresponde!', 'warning');
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await Api.apiPost('/reset-password', {
			username : username.value,
			password: password.value,
			password_confirmation: confirm_password.value,
			token : route.params.id
		})
		
		username.value         = '',
		password.value         = '';
		confirm_password.value = '';
		
		return show_msgbox(response.data.message, 'success');
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}
</script>
