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
					<label><span class="input_required">*</span> Código do Pedido:</label>
					<input type="text" name="code" maxlength="40" v-model="code" @input="CODEOnlyNumbers()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Destinatário:</label>
					<input type="text" name="destination" maxlength="255" v-model="destination" @input="DESTINATIONConvertWordToUppercase()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> WhatsApp:</label>
					<input type="text" name="whatsapp"  maxlength="60" v-model="whatsapp" @keyup="WHATSAPPOnlyNumbers()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Objeto:</label>
					<input type="text" name="object" maxlength="60" v-model="object" @input="OBJECTConvertWordToUppercase()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Transportadora:</label>
					<select name="type" v-model="integration">
						<option value="0">Correios</option>
						<option value="1">Jadlog</option>
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
import { watch, ref, defineProps, defineEmits } from 'vue';
import { useStore } from 'vuex';
import { empty, show_msgbox, convertToUpperCase, keepNumbersOnly, validatedPhone } from '@/helpers/Helpers';

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
const store            = useStore();
const id               = ref('');
const code             = ref('');
const destination      = ref('');
const whatsapp         = ref('');
const object           = ref('');
const integration = ref('0');

/* Events */
watch(() => props.form, (value) => {
	if(props.update == false)
	{
		clearInputs();
	}
	else
	{
		let data  = { ...value };
		
		id.value               = data.id;
		code.value             = data.code;
		destination.value      = data.destination;
		whatsapp.value         = data.whatsapp;
		object.value           = data.object;
		integration.value = data.integration;
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
	if(empty(code.value))
	{
		return show_msgbox('O Campo CÓDIGO DO PEDIDO é obrigatório!', 'warning');
	}
	if(empty(destination.value))
	{
		return show_msgbox('O Campo DESTINATÁRIO é obrigatório!', 'warning');
	}
	if(empty(whatsapp.value))
	{
		return show_msgbox('O Campo WHATSAPP é obrigatório!', 'warning');
	}
	if(validatedPhone(whatsapp.value))
	{
		return show_msgbox('Entre com um WHATSAPP válido!<br/><br/>Formato:<br/><br/><b style="color:#0000ff;">[Código do País]</b><b style="color:#fd9109;">[Código de Área]</b><b style="color:#000000;">[Número do Celular]</b><br/><br/>Ex.: <b style="color:#0000ff;">55</b><b style="color:#fd9109;">31</b><b style="color:#000000;">911112222</b>.', 'warning');
	}
	if(empty(object.value))
	{
		return show_msgbox('O Campo OBJETO é obrigatório!', 'warning');
	}
	if(empty(integration.value))
	{
		return show_msgbox('O Campo INTEGRAÇÃO é obrigatório!', 'warning');
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		let response = '';
		let formData = new FormData();
		formData.append('id', id.value);
		formData.append('code', code.value);
		formData.append('destination', destination.value);
		formData.append('whatsapp', whatsapp.value);
		formData.append('object', object.value);
		formData.append('integration', integration.value);
		
		if(props.update == false)
		{
			response = await store.dispatch('insertOrder', formData);
		}
		else
		{
			response = await store.dispatch('updateOrder', formData);
		}
		
		try {
			await store.dispatch('getOrder', {
				srch_code : store.state.order.filters.srch_code,
				srch_type : store.state.order.filters.srch_type,
				srch_title : store.state.order.filters.srch_title,
				srch_situation: store.state.order.filters.srch_situation
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
	id.value               = '';
	code.value             = '';
	destination.value      = '';
	whatsapp.value         = '';
	object.value           = '';
	integration.value = '0';
}

const CODEOnlyNumbers = () => {
	code.value = convertToUpperCase(code.value);
}

const DESTINATIONConvertWordToUppercase = () => {
	destination.value = convertToUpperCase(destination.value);
}

const OBJECTConvertWordToUppercase = () => {
	object.value = convertToUpperCase(object.value);
}

const WHATSAPPOnlyNumbers = () => {
	whatsapp.value = keepNumbersOnly(whatsapp.value);
}
</script>