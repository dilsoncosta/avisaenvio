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
					<label><span class="input_required">*</span> Cliente:</label>
					<Multiselect
						v-model="client.value"
						v-bind="client">
					</Multiselect>
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Título:</label>
					<input type="text" name="title" maxlength="225" v-model="title">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Url:</label>
					<input type="text" name="url" maxlength="225" v-model="url">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Porta:</label>
					<input type="text" name="port" maxlength="12" v-model="port">
				</div>
				<div class="form_group">
					<label>WhatsApp:</label>
					<input type="text" name="whatsapp" maxlength="60" v-model="whatsapp">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Situação:</label>
					<select name="situation" v-model="situation">
						<option value="1">Ativo</option>
						<option value="0">Inativo</option>
					</select>
				</div>
			</div>
		</div>
		<div class="modal__action">
			<button class="btn_modal__action" @click.prevent="submit">Salvar</button>
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
	padding:2px 0px;
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
import { empty, show_msgbox, validatedPhone } from '@/helpers/Helpers';

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
	optionsClients: Object
});

/* Ref or Reactive */
const store     = useStore();
const id        = ref('');
const url       = ref('');
const port      = ref('');
const situation = ref('');
const whatsapp  = ref('');
const title     = ref('');
const client = ref({
	mode: 'single',
	value: null,
	closeOnSelect: true,
	options: props.optionsClients,
	searchable: true,
	createOption: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado",
});

/* Events */
watch(() => props.form, (value) => {
	if(props.update == false)
	{
		client.value.value  = '';
		id.value            = '';
		url.value           = 'https://evolutionapi.avisa.app.br';
		port.value          = '9000';
		title.value         = '';
		whatsapp.value      = '';
		situation.value     = '1';
	}
	else
	{
		let data  = { ...value };
		client.value.value = data.client ? data.client.id : '';
		id.value        = data.id;
		title.value     = data.title;
		url.value       = data.url;
		port.value      = data.port;
		whatsapp.value  = data.whatsapp;
		situation.value = data.situation;
	}
});

/* Emits */
const emit = defineEmits(['hideModalCreateUpdate']);

/* Functions */
const hideModal = () => {
	emit('hideModalCreateUpdate', false);
}

const submit = async () => {
	if(empty(id.value) && props.update == true)
	{
		return show_msgbox('Incapaz de processar a solicitaçãõ!', 'error');
	}
	if(!client.value.value)
	{
		return show_msgbox('O Campo CLIENTE é obrigatório!', 'warning');
	}
	if(empty(title.value))
	{
		return show_msgbox('O Campo TÍTULO é obrigatório!', 'warning');
	}
	if(empty(url.value))
	{
		return show_msgbox('O Campo URL é obrigatório!', 'warning');
	}
	if(empty(port.value))
	{
		return show_msgbox('O Campo PORTA é obrigatório!', 'warning');
	}
	if(!empty(whatsapp.value) && validatedPhone(whatsapp.value) && props.update == false)
	{
		return show_msgbox('Entre com um WHATSAPP válido!<br/><br/>Formato:<br/><br/><b style="color:#0000ff;">[Código do País]</b><b style="color:#fd9109;">[Código de Área]</b><b style="color:#000000;">[Número do Celular]</b><br/><br/>Ex.: <b style="color:#0000ff;">55</b><b style="color:#fd9109;">31</b><b style="color:#000000;">911112222</b>.', 'warning');
	}
	if(empty(situation.value))
	{
		return show_msgbox('O Campo SITUAÇÃO é obrigatório!', 'warning');
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		
		let response = '';
		let data = {
			client_id : client.value.value,
			id : id.value,
			url : url.value,
			port: port.value,
			whatsapp: !empty(whatsapp.value) ? whatsapp.value : '',
			title: title.value,
			situation: situation.value
		};
		
		if(props.update == false)
		{
			response = await store.dispatch('insertAdminTokenWhatsAppWeb', data);
		}
		else
		{
			response = await store.dispatch('updateAdminTokenWhatsAppWeb', data);
		}
		
		try {
			await store.dispatch('getAdminTokenWhatsAppWeb', {
				srch_client : store.state.admin_token_whatsappweb.srch_client,
				srch_port : store.state.admin_token_whatsappweb.srch_port,
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
</script>