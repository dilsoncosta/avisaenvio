<template>
	<main>
		<div class="page-content">
			<div class="table">
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><a>Configuração</a></li>
							<li class="active">Hotel</li>
						</ol>
					</div>
					<div></div>
				</div>
				<div class="container_inputs">
					<p class="title_options">Mensagem de Boas-Vindas:</p>
					<div class="form_group">
						<label>Envio:</label>
						<select name="ind_msg_1" v-model="ind_msg_1">
							<option value="0">Desativado</option>
							<option value="1">1 Dia Antes do Check-in</option>
							<option value="2">2 Dias Antes do Check-in</option>
							<option value="3">3 Dias Antes do Check-in</option>
							<option value="4">4 Dias Antes do Check-in</option>
							<option value="5">5 Dias Antes do Check-in</option>
							<option value="6">6 Dias Antes do Check-in</option>
							<option value="7">7 Dias Antes do Check-in</option>
							<option value="8">15 Dias Antes do Check-in</option>
							<option value="9">1 Mês Antes do Check-in</option>
						</select>
					</div>
					<div class="form_group" v-if="ind_msg_1 != 0">
						<label>Escolha o Template da Mensagem de Boas-Vindas:</label>
						<Multiselect
							v-model="msg_1_template_id.value"
							v-bind="msg_1_template_id">
						</Multiselect>
					</div>
					<br/>
					<p class="title_options">Mensagem de Informações do Check-in:</p>
					<div class="form_group">
						<label>Envio:</label>
						<select name="ind_msg_2" v-model="ind_msg_2">
							<option value="0">Desativado</option>
							<option value="1">1 Dia Antes do Check-in</option>
							<option value="2">2 Dias Antes do Check-in</option>
							<option value="3">3 Dias Antes do Check-in</option>
							<option value="4">4 Dias Antes do Check-in</option>
							<option value="5">5 Dias Antes do Check-in</option>
							<option value="6">6 Dias Antes do Check-in</option>
							<option value="7">7 Dias Antes do Check-in</option>
							<option value="8">15 Dias Antes do Check-in</option>
							<option value="9">1 Mês Antes do Check-in</option>
						</select>
					</div>
					<div class="form_group" v-if="ind_msg_2 != 0">
						<label>Escolha o Template Informações do Check-in:</label>
						<Multiselect
							v-model="msg_2_template_id.value"
							v-bind="msg_2_template_id">
						</Multiselect>
					</div>
					<br/>
					<p class="title_options">Mensagem dia do Check-in:</p>
					<div class="form_group">
						<label>Envio:</label>
						<select name="ind_msg_3" v-model="ind_msg_3">
							<option value="0">Desativado</option>
							<option value="1">Dia do Check-in</option>
						</select>
					</div>
					<div class="form_group" v-if="ind_msg_3 != 0">
						<label>Escolha o Template Mensagem dia do Check-in:</label>
						<Multiselect
							v-model="msg_3_template_id.value"
							v-bind="msg_3_template_id">
						</Multiselect>
					</div>
					<br/>
					<p class="title_options">Mensagem de Agradecimento do Checkout:</p>
					<div class="form_group">
						<label>Envio:</label>
						<select name="ind_msg_4" v-model="ind_msg_4">
							<option value="0">Desativado</option>
							<option value="1">1 Dia Após o Checkout</option>
							<option value="2">2 Dias Após o Checkout</option>
							<option value="3">3 Dias Após o Checkout</option>
							<option value="4">4 Dias Após o Checkout</option>
							<option value="5">5 Dias Após o Checkout</option>
							<option value="6">6 Dias Após o Checkout</option>
							<option value="7">7 Dias Após o Checkout</option>
							<option value="8">15 Dias Após o Checkout</option>
							<option value="9">1 Mês Após o Checkout</option>
						</select>
					</div>
					<div class="form_group" v-if="ind_msg_4 != 0">
						<label>Escolha o Template Mensagem de Agradecimento do Checkout:</label>
						<Multiselect
							v-model="msg_4_template_id.value"
							v-bind="msg_4_template_id">
						</Multiselect>
					</div>
					<br/>
					<p class="title_options">Mensagem Pesquisa de Sastifação:</p>
					<div class="form_group">
						<label>Envio:</label>
						<select name="people" id="people" v-model="ind_msg_5">
							<option value="0">Desativado</option>
							<option value="1">1 Dia Após o Checkout</option>
							<option value="2">2 Dias Após o Checkout</option>
							<option value="3">3 Dias Após o Checkout</option>
							<option value="4">4 Dias Após o Checkout</option>
							<option value="5">5 Dias Após o Checkout</option>
							<option value="6">6 Dias Após o Checkout</option>
							<option value="7">7 Dias Após o Checkout</option>
							<option value="8">15 Dias Após o Checkout</option>
							<option value="9">1 Mês Após o Checkout</option>
						</select>
					</div>
					<div class="form_group" v-if="ind_msg_5 != 0">
						<label>Escolha o Template Mensagem Pesquisa de Sastifação:</label>
						<Multiselect
							v-model="msg_5_template_id.value"
							v-bind="msg_5_template_id">
						</Multiselect>
					</div>
					<br/>
					<p class="title_options">Mensagem de Oferta:</p>
					<div class="form_group">
						<label>Envio:</label>
						<select name="ind_msg_6" v-model="ind_msg_6">
							<option value="0">Desativado</option>
							<option value="1">1 Dia Após o Checkout</option>
							<option value="2">2 Dias Após o Checkout</option>
							<option value="3">3 Dias Após o Checkout</option>
							<option value="4">4 Dias Após o Checkout</option>
							<option value="5">5 Dias Após o Checkout</option>
							<option value="6">6 Dias Após o Checkout</option>
							<option value="7">7 Dias Após o Checkout</option>
							<option value="8">15 Dias Após o Checkout</option>
							<option value="9">1 Mês Após o Checkout</option>
						</select>
					</div>
					<div class="form_group" v-if="ind_msg_6 != 0">
						<label>Escolha o Template Mensagem Mensagem de Oferta:</label>
						<Multiselect
							v-model="msg_6_template_id.value"
							v-bind="msg_6_template_id">
						</Multiselect>
					</div>
				</div>
			</div>
			<br/>
			<button class="btn_save" @click.prevent="submit">Salvar</button>
		</div>
	</main>
</template>
<style scoped>
main {
	width: 100%;
}
.page-title-box {
	display: flex;
	justify-content: space-between;
	background-color: #fff;
	box-shadow: 0 0 35px 0 rgb(73 80 87 / 15%);
	color: #454550;
}
.page-title {
	display: flex;
	justify-content: space-between;
	height: 55px;
	padding: 19px;
	font-weight: 500;
}
.page-title ul {
	display: flex;
	list-style: none;
}
.page-title ul li{
	padding:0px 3px;
	font-size: 15px;
}
.page-content {
	margin: 30px;
	background-color: #fff;
	border-radius: 0.25rem;
	padding: 25px;
}

/* Table Header */
.table .header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	flex-wrap: wrap;
}
.header .f_show_register {
	outline: none;
	border: none;
	border-radius: 6px;
	cursor: pointer;
	padding: 10px;
	margin-right: 5px;
	margin-top: 5px;
	padding: 8px;
	line-height: 14px;
	color: #fff;
	background-color: #3bafda;
}
.header .f_show_delete {
	outline: none;
	border: none;
	border-radius: 6px;
	cursor: pointer;
	padding: 10px;
	margin-right: 5px;
	margin-top: 5px;
	padding: 8px;
	line-height: 14px;
	color: #fff;
	background-color: #3bafda;
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
/* End Table Header */

/* Inputs */
.container_inputs {
	display: grid;
	grid-template-columns: repeat(1, 1fr);
	gap: 10px;
	margin-top: 18px;
	margin: 10px 0px;
}
.container_inputs .form_group {
	padding:5px 0px;
	margin-top:5px;
}
label {
	margin-bottom: 0.5rem !important;
	font-size: 13px;
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
textarea {
	font-family: inherit;
}
input:disabled {
	opacity: 1;
}
.textarea-container {
	position: relative;
}
.custom-textarea {
	width: 100%;
	padding-right: 30px;
}
.textarea-container img {
	position: absolute;
	top: 0px;
	right: 5px;
	color: gray;
	height:20px;
	width:20px;
	cursor:pointer;
}
.input_required {
	color:#ff0000;
}
.text_inputs_required {
	margin-top:17px;
	font-size:12px;
}
.title_options {
	font-size: 15px;
	text-align: center;
}
/* End Inputs */

/* Buttons */
.btn_save {
	display: flex;
	justify-content: center;
	border-radius: 0px;
	color: #000000;
	background-color: #f8d039;
	border: 1px solid #ef9900;
	box-shadow: none !important;
	cursor: pointer;
	padding: 10px;
	font-size: 17px;
	width: 100%;
}
/* End Buttons */

/* Emojis */
.emoji_picker
{
	position: relative;
	display: flex;
	flex-direction: column;
	width: 20rem;
	height: 20.5rem;
	max-width: 100%;
	top:23px;
}
.emoji_picker,
.bottom_arrow
{
	box-shadow: 0 0 5px 1px rgba(0, 0, 0, .0975);
}
.emoji_picker,
.picker_container
{
	border-radius: 0.5rem;
	background: white;
	border-radius: 0.5rem;
	background: white;
	position: absolute;
	right: 0;
}
.picker_container
{
	position: relative;
	padding: 12px;
	overflow-x: hidden;
	z-index: 1;
	border: 1px solid #ccc;
}
.category
{
	display: flex;
	flex-direction: column;
	margin-bottom: 1rem;
	color: rgb(169, 169, 169);
}
.emojis_container
{
	display: flex;
	flex-wrap: wrap;
	width:18rem;
}
.category button
{
	margin: 0.5rem;
	margin-left: 0;
	background: inherit;
	border: none;
	font-size: 1.75rem;
	padding: 0;
	cursor:pointer;
}
.category button:hover
{
 background-color: #ddd;
	border-radius: 10px;
}
.textarea-container {
	position: relative;
}
.custom-textarea {
	width: 100%;
	padding-right: 30px;
}
.textarea-container img {
	position: absolute;
	top: 0px;
	right: 5px;
	color: gray;
	height:20px;
	width:20px;
	cursor:pointer;
}
/* End Emojis */
</style>
<script setup>
import { ref, onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import { show_msgbox, empty } from '@/helpers/Helpers';

/* Ref or Reactive */
const store = useStore();

/* Ref or Reactive */
const path_storage = import.meta.env.VITE_APP_PATH_STORAGE;
const ind_msg_1 = ref('');
const ind_msg_2 = ref('');
const ind_msg_3 = ref('');
const ind_msg_4 = ref('');
const ind_msg_5 = ref('');
const ind_msg_6 = ref('');

const msg_1_template_id = ref({
	mode: 'single',
	value: [],
	closeOnSelect: true,
	options: [],
	searchable: true,
	createOption: true,
	groupHideEmpty: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado"
});
const msg_2_template_id = ref({
	mode: 'single',
	value: [],
	closeOnSelect: true,
	options: [],
	searchable: true,
	createOption: true,
	groupHideEmpty: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado"
});
const msg_3_template_id = ref({
	mode: 'single',
	value: [],
	closeOnSelect: true,
	options: [],
	searchable: true,
	createOption: true,
	groupHideEmpty: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado"
});
const msg_4_template_id = ref({
	mode: 'single',
	value: [],
	closeOnSelect: true,
	options: [],
	searchable: true,
	createOption: true,
	groupHideEmpty: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado"
});
const msg_5_template_id = ref({
	mode: 'single',
	value: [],
	closeOnSelect: true,
	options: [],
	searchable: true,
	createOption: true,
	groupHideEmpty: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado"
});
const msg_6_template_id = ref({
	mode: 'single',
	value: [],
	closeOnSelect: true,
	options: [],
	searchable: true,
	createOption: true,
	groupHideEmpty: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado"
});

/* Events */
onMounted(async () => {
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await store.dispatch('generateOptionsTemplates');
		
		response.forEach(item => {
			msg_1_template_id.value.options.push({ value: item.id, label: item.title });
			msg_2_template_id.value.options.push({ value: item.id, label: item.title });
			msg_3_template_id.value.options.push({ value: item.id, label: item.title });
			msg_4_template_id.value.options.push({ value: item.id, label: item.title });
			msg_5_template_id.value.options.push({ value: item.id, label: item.title });
			msg_6_template_id.value.options.push({ value: item.id, label: item.title });
		});
	}
	catch(error)
	{
		if(error.status != 404)
		{
			return show_msgbox(error.data.message, 'warning');
		}
	}

	try {
		const response = await store.dispatch('getConfigHospitality');
		
		ind_msg_1.value = response.ind_msg_1;
		ind_msg_2.value = response.ind_msg_2;
		ind_msg_3.value = response.ind_msg_3;
		ind_msg_4.value = response.ind_msg_4;
		ind_msg_5.value = response.ind_msg_5;
		ind_msg_6.value = response.ind_msg_6;
		
		msg_1_template_id.value.value = response.msg_1_template_id;
		msg_2_template_id.value.value = response.msg_2_template_id;;
		msg_3_template_id.value.value = response.msg_3_template_id;;
		msg_4_template_id.value.value = response.msg_4_template_id;;
		msg_5_template_id.value.value = response.msg_5_template_id;;
		msg_6_template_id.value.value = response.msg_6_template_id;;
	}
	catch(error)
	{
		ind_msg_1.value = '0';
    ind_msg_2.value = '0';
    ind_msg_3.value = '0';
    ind_msg_4.value = '0';
    ind_msg_5.value = '0';
    ind_msg_6.value = '0';
		msg_1_template_id.value.value = '';
		msg_2_template_id.value.value = '';
		msg_3_template_id.value.value = '';
		msg_4_template_id.value.value = '';
		msg_5_template_id.value.value = '';
		msg_6_template_id.value.value = '';

		if(error.status != 404)
		{
			return show_msgbox(error.data.message, 'warning');
		}
	}
	
	store.commit('CHANGE_LOADING', false);
});

/* Functions */

const submit = async () => {
	
	if(empty(ind_msg_1.value))
	{
		return show_msgbox('O Campo ENVIO da Mensagem de Boas-Vindas!', 'warning');
	}
	if(ind_msg_1.value > 0 && empty(msg_1_template_id.value.value))
	{
		return show_msgbox('O Campo Escolha o Template da Mensagem de Boas-Vindas é obrigatório!', 'warning');
	}
	if(empty(ind_msg_2.value))
	{
		return show_msgbox('O Campo ENVIO da Mensagem de Informações do Check-in!', 'warning');
	}
	if(ind_msg_2.value > 0 && empty(msg_2_template_id.value.value))
	{
		return show_msgbox('O Campo Escolha o Template Informações do Check-in é obrigatório!', 'warning');
	}
	if(empty(ind_msg_3.value))
	{
		return show_msgbox('O Campo ENVIO da Mensagem dia do Check-in!', 'warning');
	}
	if(ind_msg_3.value > 0 && empty(msg_3_template_id.value.value))
	{
		return show_msgbox('O Campo Escolha o Template Mensagem dia do Check-in é obrigatório!', 'warning');
	}
	if(empty(ind_msg_4.value))
	{
		return show_msgbox('O Campo ENVIO da Mensagem de Agradecimento do Checkout!', 'warning');
	}
	if(ind_msg_4.value > 0 && empty(msg_4_template_id.value.value))
	{
		return show_msgbox('O Campo Escolha o Template Mensagem de Agradecimento do Checkout!', 'warning');
	}
	if(empty(ind_msg_5.value))
	{
		return show_msgbox('O Campo ENVIO da Mensagem Pesquisa de Sastifação!', 'warning');
	}
	if(ind_msg_5.value > 0 && empty(msg_5_template_id.value.value))
	{
		return show_msgbox('O Campo Escolha o Template Mensagem Pesquisa de Sastifação!', 'warning');
	}
	if(empty(ind_msg_6.value))
	{
		return show_msgbox('O Campo ENVIO da Mensagem de Oferta!', 'warning');
	}
	if(ind_msg_6.value > 0 && empty(msg_6_template_id.value.value))
	{
		return show_msgbox('O Campo Escolha o Template Mensagem Mensagem de Oferta!', 'warning');
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try
	{
		let response = '';
		
		let formData = new FormData();
		formData.append('ind_msg_1', ind_msg_1.value);
		formData.append('ind_msg_2', ind_msg_2.value);
		formData.append('ind_msg_3', ind_msg_3.value);
		formData.append('ind_msg_4', ind_msg_4.value);
		formData.append('ind_msg_5', ind_msg_5.value);
		formData.append('ind_msg_6', ind_msg_6.value);
		
		if(ind_msg_1.value > 0){ formData.append('msg_1_template_id', msg_1_template_id.value.value); }
		if(ind_msg_2.value > 0){ formData.append('msg_2_template_id', msg_2_template_id.value.value); }
		if(ind_msg_3.value > 0){ formData.append('msg_3_template_id', msg_3_template_id.value.value); }
		if(ind_msg_4.value > 0){ formData.append('msg_4_template_id', msg_4_template_id.value.value); }
		if(ind_msg_5.value > 0){ formData.append('msg_5_template_id', msg_5_template_id.value.value); }
		if(ind_msg_6.value > 0){ formData.append('msg_6_template_id', msg_6_template_id.value.value); }
		
		response = await store.dispatch('updateConfigHospitality', formData);
		
		return show_msgbox(response, 'success');
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}
</script>