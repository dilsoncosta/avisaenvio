<template>
	<div id="container">
		<div id="header">
			<h2>Seja bem vindo(a)</h2>
			<p>Insira seus dados para acessar sua conta.</p>
		</div>
		<div id="form_login">
			<div>
				<label for="username">Usuário</label>
				<input type="text" name="username" id="username" v-model="username" maxlength="45" @keyup="validateUsername">
			</div>
			<div>
				<label for="password">Senha</label>
				<input type="password" name="password" id="password" maxlength="45" v-model="password">
			</div>
			<div class="btn_form">
				<a href="#" @click.prevent="handleLogin">Acessar</a>
				<router-link :to="{name: 'forgot-password'}" class="forgot_password">Recuperar Senha</router-link>
			</div>
		</div>
		<Preloader/>
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
input {
	font-size:12px;
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
#form_login {
	margin-top: 40px;
	background-color: #fff;
	width: 450px;
	box-shadow: 0 0 3px #ddd;
	padding: 20px 40px;
}
#form_login div {
	margin: 15px 0px;
}
#form_login label{
	font-size: 14px;
	color: #000;
	opacity: 1;
}
#form_login input {
	margin-top: 5px;
	width: 100%;
	border: 1px solid #ccc;
	padding: 10px;
	outline: 0;
	color: #6b7280;
	font-size:13px;
}
.btn_form {
	display: flex;
	flex-direction: column;
}
.btn_form a {
	width: 100%;
	padding: 10px;
	color: #fff;
	background-color: #2957a7;
	border: none;
	font-size: 14px;
	margin-top: 10px;
	cursor: pointer;
	transition: all ease .0.3s;
	text-decoration: none;
	text-align: center;
}
.btn_form a:hover {
	opacity: .9;
}
.btn_form .forgot_password {
	background-color: #fff;
	color: #2957a7;
	border: 1px solid #ccc;
	padding: 7px;
}
@media(max-width: 500px){
	#form_login {
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
import { empty, show_msgbox } from '@/helpers/Helpers';

/* Ref ou Reactive */
const store = useStore();
const username = ref('');
const password = ref('');

/* Events */
watch(() => store.state.auth.authenticated,
	(loggedIn) => {
		if (loggedIn) {
			router.push({name: 'home'})
		}
	}
);

/* Functions */
const  handleLogin = async () => {
	if(empty(username.value))
	{
		return show_msgbox('O Campo USUÁRIO é obrigatório!', 'warning');
	}
	if(empty(password.value))
	{
		return show_msgbox('O Campo SENHA é obrigatório!', 'warning');
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		await store.dispatch('login', {
			username : username.value,
			password: password.value,
			device_name: 'application'
		});
		localStorage.setItem('menu_id', 0);
		router.push({name: 'home'});
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
