<template>
	<main>
		<div class="page-content" v-on:scroll.prevent>
			<div class="table">
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><router-link to="/"><i class="fas fa-home-lg"></i></router-link></li>
							<li class="active">Perfil</li>
						</ol>
					</div>
					<div></div>
				</div>
			</div>
			<br/>
			<div class="container">
				<div class="form_area">
					<div class="form_group">
						<label>Username</label>
						<input type="text" name="username" v-model="username" disabled>
					</div>
					<div class="form_group" v-show="category != 'CLB' && category != 'FRCLB'">
						<label>Pessoa:</label>
						<select name="people" id="people" v-model="people">
							<option></option>
							<option value="F">Fisica</option>
							<option value="J">Jurídica</option>
						</select>
					</div>
					<div class="form_group" v-if="people == 'F'">
						<label>Nome</label>
						<input type="text" name="name" v-model="name">
					</div>
					<div class="form_group" v-if="people == 'F'">
						<label>Sobrenome</label>
						<input type="text" name="surname" v-model="surname">
					</div>
					<div class="form_group" v-if="people == 'J'">
						<label>Razão Social</label>
						<input type="corporate_name" name="name" id="corporate_name" maxlength="120" v-model="corporate_name">
					</div>
					<div class="form_group">
						<label>Email</label>
						<input type="text" name="email" v-model="email">
					</div>
					<div class="form_group">
						<label>Celular</label>
						<input type="text" name="phone" v-model="phone">
					</div>
					<div class="form_group">
						<label>WhatsApp</label>
						<input type="text" name="whatsapp" v-model="whatsapp">
					</div>
				</div>
				<div class="button_area">
					<button @click.prevent="handleSave">Salvar</button>
				</div>
			</div>
		</div>
	</main>
</template>
<style scoped>
main {
	width: 100%;
}
a {
	text-decoration:none;
}
ul li {
	list-style:none;
	font-size:14px;
}
a {
	text-decoration:none;
}
.page-content {
	margin: 30px;
	background-color: #fff;
	border-radius: 0.25rem;
	padding:20px;
}
/* Table Header */
.table {
	width: 100%;
}
.table .header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	flex-wrap: wrap;
}
.header .page-content-title {
	display: flex;
	color: #ffffff;
	font-size: 15px;
	list-style: none;
}
.header .page-content-title li:nth-child(1){
	text-decoration: none;
	background-color: #3bafda;
	border: 1px solid #3bafda;
	padding: 10px;
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
}
.header .page-content-title .active{
	background-color: #e6e9ed;
	padding: 10px;
	border-top-right-radius: 5px;
	border-bottom-right-radius: 5px;
	color: #000;
}
.fa-home-lg {
	color:#fff;
}
/* Fim Table Header */
 
/* Inputs */
.form_area {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
}
.form_area .form_group {
	padding:5px 0px;
}
label {
	margin-bottom: 0.5rem !important;
	font-size: 14px;
	color: #000;
	opacity: 1;
}
input, select, textarea {
	margin-top: 5px;
	width: 100%;
	padding: 8px;
	color: #000;
	border-radius: 0px;
	font-size: 12px;
	box-shadow: none !important;
	outline: 0;
	border: 1px solid #ccc !important;
}
input:disabled {
	opacity: 1;
}
input[name=name], input[name=surname] {
  text-transform: uppercase;
}
.input_required {
	color:#ff0000;
}
.multiselect {
	margin-top:5px;
}
.serach_training {
	width:450px;
}
/* End Inputs */

/* Buttons */
.button_area {
	display: flex;
	justify-content: flex-end;
	margin-top: 12px;
}
button {
	display: flex;
	justify-content: center;
	border-radius: 0px;
	color: #000000;
	background-color: #f8d039;
	border: 1px solid #ef9900;
	box-shadow: none !important;
	cursor: pointer;
	padding: 10px;
	width: 100px;
	font-size:12px;
}
button:hover {
	background-color: #f8d039 !important;
	border-color: #ef9900 !important;
	color:#000000 !important;
	opacity: 0.9;
}
/* End Buttons */

/* Media Query */
@media(max-width: 800px) {
	.form_area {
		display: grid;
		grid-template-columns: repeat(1, 1fr);
		gap: 10px;
	}
}
/* End Media Query */
</style>
<script setup>
import { onMounted, ref } from 'vue';
import { empty, show_msgbox, validatedPhone, validatedEmail } from '@/helpers/Helpers';
import { useStore } from 'vuex';
import Api from '@/helpers/Api';

/* Ref or Reactive */
const store    = useStore();
const category = ref('');
const people   = ref('');
const username = ref('');
const name     = ref('');
const surname  = ref('');
const corporate_name = ref('');
const email    = ref('');
const phone    = ref('');
const whatsapp = ref('');

/* Events */
onMounted( async () => {
	store.commit('CHANGE_LOADING', true);
	
	try {
		const me = await Api.apiGet('/me');
		people.value   = me.data.data.people;
		username.value = me.data.data.username;
		name.value     = me.data.data.name;
		surname.value  = me.data.data.surname;
		corporate_name.value  = me.data.data.corporate_name;
		email.value    = me.data.data.email;
		phone.value    = me.data.data.phone;
		whatsapp.value = me.data.data.whatsapp;
		category.value = me.data.data.category;
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
});

/* Functions */
const handleSave = async () => {
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
		return show_msgbox('O Campo SOBRENOME é obrigatório!', 'warning');
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

	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await Api.apiPost('/profile', {
			people : people.value,
			username : username.value,
			name : name.value,
			surname : surname.value,
			corporate_name : corporate_name.value,
			email : email.value,
			phone: phone.value,
			whatsapp: whatsapp.value
		});
		store.dispatch('alter_name_surname');
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