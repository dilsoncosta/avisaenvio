<template>
	<div id="container">
		<div id="header">
			<h2>Criação de Conta</h2>
			<p>Crie uma conta para acessar a plataforma AVISA APP.</p>
			<p>Campos com um <span style="color:#ff0000;">*</span> são obrigatórios.</p>
		</div>
		<div id="form_register">
			<div>
				<label for="name"><span class="input_required">*</span> Subdominio</label>
				<input type="text" name="subdominio" id="name" maxlength="255" v-model="subdomain" @keyup="validateSubdomain">
			</div>
			<div>
				<label for="people"><span class="input_required">*</span> Pessoa:</label>
				<select name="people" v-model="people">
					<option></option>
					<option value="F">Fisica</option>
					<option value="J">Jurídica</option>
				</select>
			</div>
			<div v-if="people == 'F'">
				<label for="name"><span class="input_required">*</span> Nome</label>
				<input type="text" name="name" id="name" maxlength="45" v-model="name">
			</div>
			<div v-if="people == 'F'">
				<label for="surname"><span class="input_required">*</span> Sobrenome</label>
				<input type="text" name="surname" id="surname" maxlength="45" v-model="surname">
			</div>
			<div v-if="people == 'J'">
				<label for="name"><span class="input_required">*</span> Razão Social</label>
				<input type="corporate_name" name="name" id="name" maxlength="120" v-model="corporate_name">
			</div>
			<div>
				<label for="email"><span class="input_required">*</span> E-mail</label>
				<input type="text" name="email" maxlength="60" id="email" v-model="email">
			</div>
			<div>
				<label for="phone"><span class="input_required">*</span> Celular</label>
				<input type="text" name="phone" id="phone" maxlength="60" v-model="phone">
			</div>
			<div>
				<label for="whatsapp"><span class="input_required">*</span> WhatsApp</label>
				<input type="text" name="whatsapp" id="whatsapp" maxlength="660" v-model="whatsapp">
			</div>
			<div>
				<label for="username"><span class="input_required">*</span> Usuário</label>
				<input type="text" name="username" id="username" maxlength="45" v-model="username" @keyup="validateUsername">
			</div>
			<div>
				<label for="password"><span class="input_required">*</span> Senha</label>
				<input type="password" name="password" id="password" maxlength="255" v-model="password">
			</div>
			<div>
				<label for="confirm_password"><span class="input_required">*</span> Confirmação de Senha</label>
				<input type="password" name="confirm_password" id="confirm_password"  maxlength="45" v-model="confirm_password">
			</div>
			<div>
				<button @click.prevent="handleRegister">Criar Conta</button>
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
#form_register {
	margin-top: 40px;
	background-color: #fff;
	width: 450px;
	box-shadow: 0 0 3px #ddd;
	padding: 20px 40px;
}
#form_register div {
	margin: 15px 0px;
}
#form_register label{
	font-size: 14px;
	color: #000;
	opacity: 1;
}
#form_register input, #form_register select{
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
input {
	font-size:12px;
}
select {
	font-size:12px;
}
#form_register a {
	text-decoration: none;
	color: #2957a7;
	font-weight: 530;
	font-size: 14px;
}
button:hover {
  opacity: .9;
}
.input_required {
	color:#ff0000;
}
@media(max-width: 500px){
	#form_register {
		width: 100%;
	}
	#container {
		margin-left: 20px;
		margin-right: 20px;
	}
}
.title_module {
	text-align:center;
}
</style>
<script setup>
import { ref, watch } from 'vue';
import { useStore } from 'vuex';
import router from '@/router';
import Api from '@/helpers/Api';
import { empty, show_msgbox, validatedEmail, validatedPhone } from '@/helpers/Helpers';

/* Ref or Reactive */
const store            = useStore();
const people           = ref('F');
const name             = ref('');
const surname          = ref('');
const corporate_name   = ref('');
const email            = ref('');
const phone            = ref('');
const subdomain        = ref('');
const whatsapp         = ref('');
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
const  handleRegister = async () => {
	if(empty(subdomain.value))
	{
		return show_msgbox('O Campo SUBDOMINIO é obrigatório!', 'warning');
	}
	if(empty(people.value))
	{
		return show_msgbox('O Campo PESSOA é obrigatório!', 'warning');
	}
	if(empty(name.value) && people.value == 'F')
	{
		return show_msgbox('O Campo NOME é obrigatório!', 'warning');
	}
	if(empty(surname.value) && people.value == 'F')
	{
		return show_msgbox('O Campo SOBRENOME é obrigatório!', 'warning');
	}
	if(empty(corporate_name.value) && people.value == 'J')
	{
		return show_msgbox('O Campo RAZÃO SOCIAL é obrigatório!', 'warning');
	}
	if(empty(email.value))
	{
		return show_msgbox('O Campo E-MAIL é obrigatório!', 'warning');
	}
	if(!validatedEmail(email.value))
	{
		return show_msgbox('Digite um E-MAIL valido!', 'warning');
	}
	if(empty(phone.value))
	{
		return show_msgbox('O Campo CELULAR é obrigatório!', 'warning');
	}
	if(validatedPhone(phone.value))
	{
		return show_msgbox('Entre com um NÚMERO DE CELULAR válido!<br/><br/>Formato:<br/><br/><b style="color:#0000ff;">[Código do País]</b><b style="color:#fd9109;">[Código de Área]</b><b style="color:#000000;">[Número do Celular]</b><br/><br/>Ex.: <b style="color:#0000ff;">55</b><b style="color:#fd9109;">31</b><b style="color:#000000;">911112222</b>.', 'warning');
	}
	if(empty(whatsapp.value))
	{
		return show_msgbox('O Campo WHATSAPP é obrigatório!', 'warning');
	}
	if(validatedPhone(whatsapp.value))
	{
		return show_msgbox('Entre com um WHATSAPP válido!<br/><br/>Formato:<br/><br/><b style="color:#0000ff;">[Código do País]</b><b style="color:#fd9109;">[Código de Área]</b><b style="color:#000000;">[Número do Celular]</b><br/><br/>Ex.: <b style="color:#0000ff;">55</b><b style="color:#fd9109;">31</b><b style="color:#000000;">911112222</b>.', 'warning');
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
		const response = await Api.apiPost('/register', {
			username : username.value,
			password : password.value,
			password_confirmation: confirm_password.value,
			people : people.value,
			name : name.value,
			subdomain : subdomain.value,
			surname : surname.value,
			corporate_name : corporate_name.value,
			email : email.value,
			phone: phone.value,
			whatsapp: whatsapp.value,
		});
		
		people.value = 'F',
		username.value = '',
		password.value = '';
		confirm_password.value = '';
		name.value     = '';
		surname.value  = '';
		corporate_name.value = '';
		email.value    = '';
		phone.value    = '';
		whatsapp.value = '';
		subdomain.value = '';
		
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

const validateSubdomain = () => {
	let regExpSubdomain = /[^a-z0-9-]/g;
	if(subdomain.value.match(regExpSubdomain)){
		subdomain.value = subdomain.value.replace(regExpSubdomain,'');
	}
}
</script>
