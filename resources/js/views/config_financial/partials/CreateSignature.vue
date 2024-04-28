<template>
	<div>
		<button class="modal__close" @click.prevent="hideModal">
			<i class="fal fa-times"></i>
		</button>
		<span class="modal__title">{{ titleModal }}</span>
		<div class="modal__content">
			<span class="text_inputs_required">Campos com <span class="input_required">*</span> são obrigatórios</span>
			<div class="form_container">
				<div class="form_group">
					<label><span class="input_required">*</span> Módulo:</label>
					<select v-model="ind_mod" @change="handleChangePrice($event)">
						<option data-total="0"></option>
						<option value="0" data-total="139">Hotelaria - R$139,00</option>
						<option value="1" data-total="139">Rastreio de Encomenda - R$139,00</option>
					</select>
				</div>
				<br/>
				<h5>Dados do Cliente</h5>
				<div class="form_group">
					<label><span class="input_required">*</span> Tipo:</label>
					<select v-model="type">
						<option value="1">Fisica</option>
						<option value="0">Juridica</option>
					</select>
				</div>
				<div class="form_group" v-if="type == 0">
					<label><span class="input_required">*</span> CNPJ:</label>
					<input type="text" name="cnpj" v-model="cnpj" maxlength="15" @keyup="CNPJOnlyNumbers()">
				</div>
				<div class="form_group" v-if="type == 0">
					<label><span class="input_required">*</span> Razão Social:</label>
					<input type="text" name="razap_social" v-model="razap_social" maxlength="60">
				</div>
				<div class="form_group" v-if="type == 1">
					<label><span class="input_required">*</span> CPF:</label>
					<input type="text" name="cpf" v-model="cpf" maxlength="12" @keyup="CPFOnlyNumbers()">
				</div>
				<div class="form_group" v-if="type == 1">
					<label><span class="input_required">*</span> Nome:</label>
					<input type="text" name="name" v-model="name" maxlength="60">
				</div>
				<div class="form_group" v-if="type == 1">
					<label><span class="input_required">*</span> Sobrenome:</label>
					<input type="text" name="surname" v-model="surname" maxlength="60">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> E-mail:</label>
					<input type="text" name="email" v-model="email">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> WhatsApp:</label>
					<input type="text" name="whatsapp" v-model="whatsapp" @keyup="WHATSAPPOnlyNumbers()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Celular:</label>
					<input type="text" name="phone" v-model="phone" @keyup="PHONEOnlyNumbers()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> CEP:</label>
					<input type="text" name="cep" v-model="cep" @keyup="SearchCep()" maxlength="8">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Estado:</label>
					<select v-model="state" @change="handleSearchCities()">
						<option></option>
						<option :value="item.letter" v-for="(item, index) in props.optionsStates" :key="index">
							{{ item.title }}
						</option>
					</select>
				</div> 
				<div class="form_group">
					<label><span class="input_required">*</span> Cidade:</label>
					<Multiselect
						v-model="cities.value"
						v-bind="cities">
					</Multiselect>
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Bairro:</label>
					<input type="text" name="neighborhood" v-model="neighborhood" maxlength="120" @input="letterToUppercase()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Endereço:</label>
					<input type="text" name="address" v-model="address" maxlength="255" @input="letterToUppercase()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Número:</label>
					<input type="text" name="number" v-model="number" maxlength="6" @input="letterToUppercase()">
				</div>
				<div class="form_group">
					<label> Complemento:</label>
					<input type="text" name="complement" v-model="complement" maxlength="25" @input="letterToUppercase()">
				</div>
				<br/>
				<h5>Dados do Cartão</h5>
				<div class="form_group">
					<label><span class="input_required">*</span> Nome impresso no cartão:</label>
					<input type="text" name="card_number" v-model="card_name" @input="letterToUppercase()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Número do cartão:</label>
					<input type="text" name="surname" v-model="card_number" maxlength="16" @input="CARDNUMBEROnlyNumbers()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Mês de expiração (ex: 06):</label>
					<input type="text" name="card_month_exp" v-model="card_month_exp" maxlength="2" @input="CARDMONTH_EXPOnlyNumbers()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Ano de expiração com 4 dígitos (ex: 2019):</label>
					<input type="text" name="card_year_exp" v-model="card_year_exp" maxlength="4" @input="CARDYEAR_EXPOnlyNumbers()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Código de segurança:</label>
					<input type="text" name="card_cvv" v-model="card_cvv" maxlength="4" @input="CARDCVV_EXPOnlyNumbers()">
				</div>
				<div v-if="total_signature != 0">
					<br/>
					<p>Valor Total da Assinatura: {{ total_signature_html }}</p>
					<br/>
				</div>
			</div>
		</div>
		<div class="modal__action">
			<button class="btn_modal__action" @click.prevent="submit">Assinar</button>
		</div>
	</div>
</template>

<style scoped>
/* Modal */
.modal__title {
	margin: 0 2rem 0.5rem 0;
	font-size: 17px;
}
.modal__content {
	flex-grow: 1;
	overflow-y: auto;
}
.modal__close {
	position: absolute;
	top: 0.5rem;
	right: 0.5rem;
	border: none;
	background-color: #fff;
	font-size: 25px;
	cursor: pointer;
}
.modal__action {
	display: flex;
	justify-content: center;
	align-items: center;
	flex-shrink: 0;
	padding: 1rem 0 0;
}
/* End Modal */

/* Inputs */
.form_container {
	display: grid;
	grid-template-columns: repeat(1, 1fr);
	gap: 10px;
	margin-top: 13px;
}
.form_container .form_group {
	padding:5px 0px;
}
label {
	margin-bottom: 0.5rem !important;
	font-size: 14px;
	color: #000;
	opacity: 1;
}
.form_container input, select, textarea {
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
.form_container input:disabled {
	opacity: 1;
}
.form_container h5 {
	text-align: center;
	margin: 0 auto;
	font-size: 15px;
}
.text_inputs_required {
	font-size:12px;
}
.input_required {
	color:#ff0000;
}
/* End Input */

/* Button */
.modal__action .btn_modal__action {
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
.modal__action .btn_modal__action:hover {
	background-color: #f8d039 !important;
	border-color: #ef9900 !important;
	color:#000000 !important;
	opacity: 0.9;
}
input[name=name], input[name=surname] {
	text-transform: uppercase;
}
/* End Button */

.title_permission {
	text-align:center;
	font-size:16px;
	margin:0 auto;
	display:flex;
	justify-content:center;
	align-items:center;
}
.alinhar-cheks {
	margin:6px;
}
.acesso-table {
	font-size:13px;
	margin: 0 auto;
}
.checkbox_style input {
	margin-right:8px;
}
.acesso-table th {
	text-align:right;
}
.list_permissions {
	display:flex;
}
</style>
<script setup>
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import { show_msgbox, keepNumbersOnly, validatedEmail,validatedPhone, empty, convertToUpperCase, validateCNPJ, validateCPF } from '@/helpers/Helpers';

/* Props */
const props = defineProps({
	titleModal: {
		Type: String,
		required: true
	},
	optionsStates: Object
});

/* Ref or Reactive */
const store        = useStore();
const ind_mod      = ref('');
const type         = ref('1');
const cnpj         = ref('');
const razap_social = ref('');
const name         = ref('');
const surname      = ref('');
const cpf          = ref('');
const email        = ref('');
const phone        = ref('');
const whatsapp     = ref('');
const cep          = ref('');
const state        = ref('');
const cities = ref({
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
const number       = ref('');
const neighborhood = ref('');
const address      = ref('');
const complement    = ref('');

const card_name      = ref('');
const card_number    = ref('');
const card_month_exp = ref('');
const card_year_exp  = ref('');
const card_cvv       = ref('');

const total_signature_html = ref("");
const total_signature = ref(0);

/* Emits */
const emit = defineEmits(['hideModalCreateSignature', 'getSignature', 'getCharge']);

/* Functions */
const hideModal = () => {
	clearInputs();
	emit('hideModalCreateSignature', false);
}

const submit = async () => {
	if(empty(ind_mod.value))
	{
		return show_msgbox('O Campo MÓDULO é obrigatório!', 'warning');
	}
	if(empty(type.value))
	{
		return show_msgbox('O Campo TIPO é obrigatório!', 'warning');
	}
	if(empty(cnpj.value) && type.value == 0)
	{
		return show_msgbox('O Campo CNPJ é obrigatório!', 'warning');
	}
	if(cnpj.value.length > 11 && !validateCNPJ(cnpj.value))
	{
		return show_msgbox('CNPJ inváldo!', 'warning');
	}
	if(empty(razap_social.value) && type.value == 0)
	{
		return show_msgbox('O Campo RAZÃO SOCIAL é obrigatório!', 'warning');
	}
	if(empty(cpf.value) && type.value == 1)
	{
		return show_msgbox('O Campo CPF é obrigatório!', 'warning');
	}
	if(cpf.value.length <= 11 && !validateCPF(cpf.value))
	{
		return show_msgbox('CPF inváldo!', 'warning');
	}
	if(empty(name.value) && type.value == 1)
	{
		return show_msgbox('O Campo NOME é obrigatório!', 'warning');
	}
	if(empty(surname.value) && type.value == 1)
	{
		return show_msgbox('O Campo SOBRENOME é obrigatório!', 'warning');
	}
	if(empty(email.value))
	{
		return show_msgbox('O Campo E-MAIL é obrigatório!', 'warning');
	}
	if(!validatedEmail(email.value))
	{
		return show_msgbox('Digite um E-MAIL valido!', 'warning');
	}
	if(empty(whatsapp.value))
	{
		return show_msgbox('O Campo WHATSAPP é obrigatório!', 'warning');
	}
	if(validatedPhone(whatsapp.value))
	{
		return show_msgbox('Entre com um WHATSAPP válido!<br/><br/>Formato:<br/><br/><b style="color:#0000ff;">[Código do País]</b><b style="color:#fd9109;">[Código de Área]</b><b style="color:#000000;">[Número do Celular]</b><br/><br/>Ex.: <b style="color:#0000ff;">55</b><b style="color:#fd9109;">31</b><b style="color:#000000;">911112222</b>.', 'warning');
	}
	if(empty(phone.value))
	{
		return show_msgbox('O Campo CELULAR é obrigatório!', 'warning');
	}
	if(validatedPhone(phone.value))
	{
		return show_msgbox('Entre com um NÚMERO DE CELULAR válido!<br/><br/>Formato:<br/><br/><b style="color:#0000ff;">[Código do País]</b><b style="color:#fd9109;">[Código de Área]</b><b style="color:#000000;">[Número do Celular]</b><br/><br/>Ex.: <b style="color:#0000ff;">55</b><b style="color:#fd9109;">31</b><b style="color:#000000;">911112222</b>.', 'warning');
	}
	if(empty(cep.value))
	{
		return show_msgbox('O Campo CEP é obrigatório!', 'warning');
	}
	if(empty(state.value))
	{
		return show_msgbox('O Campo ESTADO é obrigatório!', 'warning');
	}
	if(empty(cities.value.value))
	{
		return show_msgbox('O Campo CIDADE é obrigatório!', 'warning');
	}
	if(empty(neighborhood.value))
	{
		return show_msgbox('O Campo BAIRRO é obrigatório!', 'warning');
	}
	if(empty(address.value))
	{
		return show_msgbox('O Campo ENDEREÇO é obrigatório!', 'warning');
	}
	if(empty(number.value))
	{
		return show_msgbox('O Campo NÚMERO é obrigatório!', 'warning');
	}

	if(empty(card_name.value))
	{
		return show_msgbox('O Campo NOME IMPRESSO NO CARTÃO é obrigatório!', 'warning');
	}
	if(empty(card_number.value))
	{
		return show_msgbox('O Campo NÚMERO DO CARTÃO é obrigatório!', 'warning');
	}
	if(empty(card_month_exp.value))
	{
		return show_msgbox('O Campo MÊS DE EXPIRAÇÃO é obrigatório!', 'warning');
	}
	if(empty(card_year_exp.value))
	{
		return show_msgbox('O Campo ANO DE EXPIRAÇÃO COM 4 DIGITOS é obrigatório!', 'warning');
	}
	if(empty(card_cvv.value))
	{
		return show_msgbox('O Campo CÓDIGO DE SEGURANÇA é obrigatório!', 'warning');
	}
	if(empty(total_signature.value))
	{
		return show_msgbox('Valor total da assinatura não encontrado!', 'error');
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try {

		let response = '';
		let formData = new FormData();
		
		formData.append('ind_mod', ind_mod.value);
		formData.append('type', type.value);
		if(type.value == 0)
		{
			formData.append('cnpj', cnpj.value);
			formData.append('razap_social', razap_social.value);
		}
		if(type.value == 1)
		{
			formData.append('name' , name.value);
			formData.append('surname', surname.value);
			formData.append('cpf', cpf.value);
			formData.append('email', email.value);
		}
		formData.append('phone', phone.value);
		formData.append('whatsapp', whatsapp.value);
		formData.append('cep', cep.value);
		formData.append('city', cities.value.value);
		formData.append('number', number.value);
		formData.append('state', state.value);
		formData.append('neighborhood', neighborhood.value);
		formData.append('address', address.value);
		formData.append('complement', complement.value);
		formData.append('card_name', card_name.value);
		formData.append('card_number', card_number.value);
		formData.append('card_month_exp', card_month_exp.value);
		formData.append('card_year_exp', card_year_exp.value);
		formData.append('card_cvv', card_cvv.value);
		formData.append('total', total_signature.value);
		
		response = await store.dispatch('insertSignatureFinancial', formData);
		
		emit('getSignature', true);
		emit('getCharge', true);
		
		hideModal();
		return show_msgbox(response, 'success');
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const PHONEOnlyNumbers = () => {
	phone.value = keepNumbersOnly(phone.value);
}

const WHATSAPPOnlyNumbers = () => {
	whatsapp.value = keepNumbersOnly(whatsapp.value);
}

const CPFOnlyNumbers = () => {
	cpf.value = keepNumbersOnly(cpf.value);
}

const CNPJOnlyNumbers = () => {
	cnpj.value = keepNumbersOnly(cnpj.value);
}

const letterToUppercase = () => {
	number.value = convertToUpperCase(number.value);
	name.value = convertToUpperCase(name.value);;
	surname.value = convertToUpperCase(surname.value);
	complement.value = convertToUpperCase(complement.value);
	address.value = convertToUpperCase(address.value);
	neighborhood.value = convertToUpperCase(neighborhood.value);
	card_name.value = convertToUpperCase(card_name.value);
	razap_social.value = convertToUpperCase(card_name.value);
}

const CARDNUMBEROnlyNumbers = () => {
	card_number.value = keepNumbersOnly(card_number.value);
}

const CARDMONTH_EXPOnlyNumbers = () => {
	card_month_exp.value = keepNumbersOnly(card_month_exp.value);
}

const CARDYEAR_EXPOnlyNumbers = () => {
	card_year_exp.value = keepNumbersOnly(card_year_exp.value);
}

const CARDCVV_EXPOnlyNumbers = () => {
	card_cvv.value = keepNumbersOnly(card_cvv.value);
}

const SearchCep = async () => {
	cep.value = keepNumbersOnly(cep.value);
	
	if(cep.value.length == 8)
	{
		store.commit('CHANGE_LOADING', true);
		let ibge = '';
		
		try {
			const response = await store.dispatch('generateOptionsCep', {
				cep : cep.value
			});
			
			state.value = response.uf;
			ibge        = response.ibge;
			if(!empty(response.neighborhood))
			{
				neighborhood.value = response.neighborhood;
			}
			if(!empty(response.addres))
			{
				address.value = response.address;
			}
			if(!empty(response.complemen))
			{
				complement.value = response.complement;
			}
		}
		catch(error)
		{
			return show_msgbox(error.data.message, 'warning', 'warning');
		}
		finally {
			store.commit('CHANGE_LOADING', false);
		}
		
		try {
			const response_cities = await store.dispatch('generateOptionsCities', {
				state : state.value
			});
			response_cities.forEach(item => {
				cities.value.options.push({ value: item.iso, label: item.title });
			});
			cities.value.value = ibge;
		}
		catch(error)
		{
			return show_msgbox(error.data.message, 'warning', 'warning');
		}
		finally {
			store.commit('CHANGE_LOADING', false);
		}
	}
}

const handleSearchCities = async () => {
	store.commit('CHANGE_LOADING', true);
	try {
		const response_cities = await store.dispatch('generateOptionsCities', {
			state : state.value
		});
		
		response_cities.forEach(item => {
			cities.value.options.push({ value: item.iso, label: item.title });
		});
	}
	catch(error)
	{
		return show_msgbox(error.data.message, 'warning', 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const handleChangePrice = (event) => {

	const selectedOption = event.target.options[event.target.selectedIndex];
  total_signature.value = selectedOption.getAttribute('data-total');
	
	total_signature_html.value = parseInt(total_signature.value).toLocaleString('pt-BR', {
						style: 'currency',
						currency: 'BRL'
					});
}

const clearInputs = () => {
	total_signature.value = 0;
	ind_mod.value      = '';
	type.value         = '1';
	cnpj.value         = '';
	razap_social.value = '';
	name.value         = '';
	surname.value      = '';
	cpf.value          = '';
	email.value        = '';
	phone.value        = '';
	whatsapp.value     = '';
	cep.value          = '';
	state.value        = '';
	cities.value.value = '';
	number.value         = '';
	neighborhood.value   = '';
	address.value        = '';
	complement.value     = '';
	card_name.value      = '';
	card_number.value    = '';
	card_month_exp.value = '';
	card_year_exp.value  = '';
	card_cvv.value       = '';
}
</script>