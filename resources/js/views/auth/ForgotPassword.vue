<template>
	<div id="container">
		<div id="header">
			<h2>Recuperação de Conta</h2>
			<p>Perdeu sua senha? Não se preocupe! Recupere a senha agora.</p>
		</div>
		<div id="form_forgot_password">
			<div>
				<label for="username">Usuário</label>
				<input type="text" name="username" id="username" v-model="username" @keyup="validateUsername">
			</div>
			<div>
				<label for="email">E-mail</label>
				<input type="text" name="email" id="email" v-model="email">
			</div>
			<div>
				<button @click.prevent="handleForgotPassword">Iniciar Recuperação</button>
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
input {
	font-size:12px;
}
#header h2 {
	font-size: 28px;
	font-weight: 900;
	color: #000000;
}
#header p {
	margin-top: 5px;
	font-size: 14px;
	color: #5f76e8;
}
#form_forgot_password {
	margin-top: 40px;
	background-color: #fff;
	width: 450px;
	box-shadow: 0 0 3px #ddd;
	padding: 20px 40px;
}
#form_forgot_password div {
	margin: 15px 0px;
}
#form_forgot_password label{
	font-size: 14px;
	color: #000;
	opacity: 1;
}
#form_forgot_password input {
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
#form_forgot_password a {
	text-decoration: none;
	color: #2957a7;
	font-weight: 530;
	font-size: 14px;
}
@media(max-width: 500px){
	#form_forgot_password {
		width: 100%;
	}
	#container {
		margin-left: 20px;
		margin-right: 20px;
	}
}
</style>

<script setup>
import { ref, watch } from 'vue';
import { useStore } from 'vuex';
import router from '@/router';
import Api from '@/helpers/Api';
import { empty, show_msgbox, validatedEmail } from '@/helpers/Helpers';

/* Ref or Reactive */
const store = useStore();
const username = ref('');
const email = ref('');

/* Events */
watch(() => store.state.auth.authenticated,
	(loggedIn) => {
		if (loggedIn) {
			router.push({name: 'home'})
		}
	}
);

/* Functions */
const  handleForgotPassword = async () => {
	if(empty(username.value))
	{
		return show_msgbox('O Campo USUÁRIO é obrigatório!', 'warning');
	}
	if(empty(email.value))
	{
		return show_msgbox('O Campo E-MAIL é obrigatório!', 'warning');
	}
	if (!validatedEmail(email.value))
	{
		return show_msgbox('Digite um E-MAIL valido!', 'warning');
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await Api.apiPost('/forgot-password', {
			username : username.value,
			email: email.value
		})
		
		username.value = '',
		email.value = '';
		
		return show_msgbox(response.data.message, 'success');
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const validateUsername = () => {
	let regExpUsername = /[^a-z0-9_]/g;
	if(username.value.match(regExpUsername)){
		username.value = username.value.replace(regExpUsername,'');
	}
}
</script>
