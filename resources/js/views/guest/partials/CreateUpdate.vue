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
					<label><span class="input_required">*</span> Nome e Sobrenome:</label>
					<input type="text" name="name_surname" maxlength="60" v-model="name_surname" @input="NAMESURNAMEConvertWordToUppercase()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> WhatsApp:</label>
					<input type="text" name="whatsapp"  maxlength="60" v-model="whatsapp" @keyup="WHATSAPPOnlyNumbers()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Data do Check-In:</label>
					<input type="date" name="date_checkin" maxlength="60" v-model="date_checkin" :min="getCurrentDate()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Data do Check-Out:</label>
					<input type="date" name="date_checkout" maxlength="60" v-model="date_checkout" :min="getCurrentDate()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Situação:</label>
					<select name="situation" v-model="situation">
						<option></option>
						<option value="1">Ativo</option>
						<option value="0">Inativo</option>
					</select>
				</div>
			</div>
		</div>
		<div class="modal__action">
			<button class="btn_modal__action" @click.prevent="submit" v-if="update">Salvar</button>
			<button class="btn_modal__action" @click.prevent="submit" v-else>Registrar</button>
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
	padding:4px 0px;
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
.text_inputs_required {
	font-size:12px;
}
.input_required {
	color:#ff0000;
}
.uploadFiles {
	border:1px solid #ccc;
	padding:10px;
	margin-top:5px;
}
.uploadFiles .previewFiles {
	display: flex;
	justify-content: space-between;
	align-content: center;
	cursor:pointer;
	margin-top: 20px;
	font-size: 13.5px;
	color: #0000ff;
}
.uploadFiles .previewFiles button {
	cursor: pointer;
	border: none;
	background-color: #ef9900;
	color: #fff;
}
.uploadFiles .init-upload {
	font-size: 13px;
	cursor: pointer;
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
/* End Button */
</style>
<script setup>
import { watch, ref } from 'vue';
import { useStore } from 'vuex';
import { empty, show_msgbox, convertToUpperCase, keepNumbersOnly, validatedPhone, dateStartAndDateEndInferiorCurrent } from '@/helpers/Helpers';

/* Props */
const props = defineProps({
	titleModal: {
		Type: String,
		required: true
	},
	update: {
		Type: Boolean,
		required: true,
		default: false
	},
	form: {
		Type: Object,
		required: true
	},
});

/* Emits */
const emit = defineEmits(['hideModalCreateUpdate']);

/* Ref or Reactive */
const store         = useStore();
const id            = ref('');
const name_surname  = ref('');
const whatsapp      = ref('');
const date_checkin  = ref('');
const date_checkout = ref('');
const situation     = ref('1');

/* Events */
watch(() => props.form, (value) => {
	if(props.update == false)
	{
		clearInputs();
	}
	else
	{
		let data  = { ...value };
		
		id.value            = data.id;
		name_surname.value  = data.name_surname;
		whatsapp.value      = data.whatsapp;
		date_checkin.value  = data.date_checkin;
		date_checkout.value = data.date_checkout;
		situation.value     = data.situation;
	}
});

/* Functions */
const hideModal = () => {
	emit('hideModalCreateUpdate', false);
}

const submit = async () => {
	if(empty(id.value) && props.update == true)
	{
		return show_msgbox('Incapaz de processar a solicitação!', 'error');
	}
	if(empty(name_surname.value))
	{
		return show_msgbox('O Campo NOME E SOBRENOME é obrigatório!', 'warning');
	}
	if(empty(whatsapp.value))
	{
		return show_msgbox('O Campo WHATSAPP é obrigatório!', 'warning');
	}
	if(validatedPhone(whatsapp.value))
	{
		return show_msgbox('Entre com um WHATSAPP válido!<br/><br/>Formato:<br/><br/><b style="color:#0000ff;">[Código do País]</b><b style="color:#fd9109;">[Código de Área]</b><b style="color:#000000;">[Número do Celular]</b><br/><br/>Ex.: <b style="color:#0000ff;">55</b><b style="color:#fd9109;">31</b><b style="color:#000000;">911112222</b>.', 'warning');
	}
	if(empty(date_checkin.value))
	{
		return show_msgbox('O Campo DATA DO CHECK-IN é obrigatório!', 'warning');
	}
	if(validateDate(date_checkin.value))
	{
		return show_msgbox('DATA DE CHECK-IN deve ser superior à DATA ATUAL!', 'warning');
	}
	if(empty(date_checkout.value))
	{
		return show_msgbox('O Campo DATA DO CHECKOUT é obrigatório!', 'warning');
	}
	if(validateDate(date_checkout.value))
	{
		return show_msgbox('DATA DE CHECK-OUT deve ser superior à DATA ATUAL!', 'warning');
	}
	if(dateStartAndDateEndInferiorCurrent(date_checkin.value, date_checkout.value))
	{
		return show_msgbox('DATA DE CHECK-OUT deve ser superior à DATA DE CHECK-IN!', 'warning');
	}
	if(empty(situation.value))
	{
		return show_msgbox('O Campo SITUAÇÃO é obrigatório!', 'warning');
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		let response = '';
		let formData = new FormData();
		formData.append('id', id.value);
		formData.append('name_surname', name_surname.value);
		formData.append('whatsapp', whatsapp.value);
		formData.append('date_checkin', date_checkin.value);
		formData.append('date_checkout', date_checkout.value);
		formData.append('situation', situation.value);
		
		if(props.update == false)
		{
			response = await store.dispatch('insertGuest', formData);
		}
		else
		{
			response = await store.dispatch('updateGuest', formData);
		}
	
		try {
			await store.dispatch('getGuest', {
				srch_date_checkin : store.state.guest.filters.srch_date_checkin,
				srch_date_checkout : store.state.guest.filters.srch_date_checkout,
				srch_name_surname : store.state.guest.filters.srch_name_surname,
				srch_whatsapp: store.state.guest.filters.srch_whatsapp,
				srch_situation: store.state.guest.filters.srch_situation
			});
		}
		catch(error) {
			return show_msgbox(error.data.message, 'warning');
		}
		
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

const clearInputs = () => {
	id.value            = '';
	name_surname.value  = '';
	whatsapp.value      = '';
	date_checkin.value  = getCurrentDate(); 
	date_checkout.value = getCurrentDate(); 
	situation.value     = '1';
}

const NAMESURNAMEConvertWordToUppercase = () => {
	name_surname.value = convertToUpperCase(name_surname.value);
}

const WHATSAPPOnlyNumbers = () => {
	whatsapp.value = keepNumbersOnly(whatsapp.value);
}

const getCurrentDate = () => {
	const now = new Date();
	const year = now.getFullYear();
	const month = (now.getMonth() + 1).toString().padStart(2, '0');
	const day = now.getDate().toString().padStart(2, '0');
	return `${year}-${month}-${day}`;
}

const validateDate = (date) => {
	const selectedDate = new Date(date);
	const currentDate = new Date();
	
	const selectedDateString = selectedDate.toISOString().slice(0, 10);
	const currentDateString = currentDate.toISOString().slice(0, 10);

	return selectedDateString < currentDateString;
}
</script>