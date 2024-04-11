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
					<label><span class="input_required">*</span> Nome:</label>
					<input type="text" name="name" v-model="name">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Sobrenome:</label>
					<input type="text" name="surname" v-model="surname">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Email:</label>
					<input type="text" name="email" v-model="email">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Celular:</label>
					<input type="text" name="phone" v-model="phone" @keyup="PHONEOnlyNumbers()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> WhatsApp:</label>
					<input type="text" name="whatsapp" v-model="whatsapp" @keyup="WHATSAPPOnlyNumbers()">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Usuário</label>
					<input type="text" name="username" v-model="username" @keyup="validateUsername" :disabled="update == true">
				</div>
				<div class="form_group" v-if="update == false">
					<label><span class="input_required">*</span> Senha</label>
					<input type="password" name="password" v-model="password">
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Situação:</label>
					<select name="situation" v-model="situation">
						<option value="1">Ativo</option>
						<option value="0">Inativo</option>
					</select>
				</div>
			</div>
			<br/>
			<table class="acesso-table">
				<tbody>
					<tr>
						<th>Marcar Todos</th>
						<td>&nbsp;&nbsp;<i class="fas fa-arrow-right fa-lg" style="color:#000;"></i></td>
						<div class="list_permissions">
							<div>
								<td>
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" @change="checkboxAll(1)" class="checkboxes_all checkboxes_all_access">
											<span class="span_checkbox">Acessar</span>
										</label>
									</div>
								</td>
							</div>
							<div>
								<td>
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" @change="checkboxAll(2)" class="checkboxes_all checkboxes_all_view">
											<span class="span_checkbox">Visualizar</span>
										</label>
									</div>
								</td>
							</div>
							<div>
								<td>
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" @change="checkboxAll(3)" class="checkboxes_all checkboxes_all_edit">
											<span class="span_checkbox">Editar</span>
										</label>
									</div>
								</td>
							</div>
							<div>
								<td>
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" @change="checkboxAll(4)" class="checkboxes_all checkboxes_all_delete">
											<span class="span_checkbox">Excluir</span>
										</label>
									</div>
								</td>
							</div>
						</div>
					</tr>
					<tr v-for="(item, index) in resources_general" :key="index">
						<th>{{ item.name }}</th>
						<td>&nbsp;&nbsp;<i class="fas fa-arrow-right fa-lg" style="color:#000;"></i></td>
						<div class="list_permissions">
							<div v-for="(item_permission, index_permission) in item.permissions" :key="index_permission">
								<td class="checkbox_td" v-if="item_permission.name.includes('access')">
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" :value="item_permission.id" class="access_permission checkbox_permission" >
											<span class="span_checkbox">Acessar</span>
										</label>
									</div>
								</td>
								<td class="checkbox_td" v-if="item_permission.name.includes('view')">
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" :value="item_permission.id" class="view_permission checkbox_permission">
											<span class="span_checkbox">Visualizar</span>
										</label>
									</div>
								</td>
								<td class="checkbox_td" v-if="item_permission.name.includes('edit')">
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" :value="item_permission.id" class="edit_permission checkbox_permission">
											<span class="span_checkbox">Editar</span>
										</label>
									</div>
								</td>
								<td class="checkbox_td" v-if="item_permission.name.includes('delete')">
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" :value="item_permission.id" class="delete_permission checkbox_permission">
											<span class="span_checkbox">Excluir</span>
										</label>
									</div>
								</td>
							</div>
						</div>
					</tr>
					<tr  v-if="resources_config.length > 0">
						<td colspan="5" align="center">
							<br/>
							<p class="title_permission">Configuração</p>
							<br/>
						</td>
					</tr>
					<tr v-for="(item, index) in resources_config" :key="index">
						<th>{{ item.name }}</th>
						<td>&nbsp;&nbsp;<i class="fas fa-arrow-right fa-lg" style="color:#000;"></i></td>
						<div class="list_permissions">
							<div v-for="(item_permission, index_permission) in item.permissions" :key="index_permission">
								<td class="checkbox_td" v-if="item_permission.name.includes('access')">
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" :value="item_permission.id" class="access_permission checkbox_permission" >
											<span class="span_checkbox">Acessar</span>
										</label>
									</div>
								</td>
								<td class="checkbox_td" v-if="item_permission.name.includes('view')">
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" :value="item_permission.id" class="view_permission checkbox_permission">
											<span class="span_checkbox">Visualizar</span>
										</label>
									</div>
								</td>
								<td class="checkbox_td" v-if="item_permission.name.includes('edit')">
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" :value="item_permission.id" class="edit_permission checkbox_permission">
											<span class="span_checkbox">Editar</span>
										</label>
									</div>
								</td>
								<td class="checkbox_td" v-if="item_permission.name.includes('delete')">
									<div class="alinhar-cheks">
										<label class="checkbox_style">
											<input type="checkbox" :value="item_permission.id" class="delete_permission checkbox_permission">
											<span class="span_checkbox">Excluir</span>
										</label>
									</div>
								</td>
							</div>
						</div>
					</tr>
				</tbody>
			</table>
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
import { watch, ref } from 'vue';
import { useStore } from 'vuex';
import { empty, show_msgbox, validatedEmail, validatedPhone, keepNumbersOnly } from '@/helpers/Helpers';

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
	resources_general: {
		Type: Object,
		required: true
	},
	resources_config: {
		Type: Object,
		required: true
	},
});

/* Ref or Reactive */
const store     = useStore();
const id        = ref('');
const user_id   = ref('');
const name      = ref('');
const surname   = ref('');
const email     = ref('');
const phone     = ref('');
const whatsapp  = ref('');
const username  = ref('');
const password  = ref('');
const situation = ref('');
const permissionIds = ref([]);

/* Events */
watch(() => props.form, (value) => {
	const checkboxes     = document.querySelectorAll('.checkbox_permission');
	const checkboxes_all = document.querySelectorAll('.checkboxes_all');
	
	checkboxes.forEach(checkbox => {
		checkbox.checked = false;
	});
	checkboxes_all.forEach(checkbox => {
		checkbox.checked = false;
	});
	
	if(props.update == true)
	{
		let data  = { ...value };
		
		id.value        = data.user.id;
		user_id.value   = data.user.id;
		name.value      = data.user.name;
		surname.value   = data.user.surname;
		email.value     = data.user.email;
		phone.value     = keepNumbersOnly(data.user.phone);
		whatsapp.value  = keepNumbersOnly(data.user.whatsapp);
		username.value  = data.user.username;
		situation.value = data.user.situation;
		data.permissions.forEach(item => {
			checkboxes.forEach(checkbox => {
				if(checkbox.value == item.id)
				{
					checkbox.checked = true;
					return;
				}
			});
		});
	}
	else
	{
		id.value        = '';
		user_id.value   = '';
		name.value      = '';
		surname.value   = '';
		email.value     = '';
		phone.value     = '';
		whatsapp.value  = '';
		username.value  = '';
		password.value  = '';
		situation.value = '1';
		permissionIds.value = [];
	}
});

/* Emits */
const emit = defineEmits(['hideModalCreateUpdate']);

/* Functions */
const hideModal = () => {
	emit('hideModalCreateUpdate', false);
}

const checkboxAll = (value) => {
	const checkboxes_all_access = document.querySelectorAll('.checkboxes_all_access');
	const checkboxes_all_view   = document.querySelectorAll('.checkboxes_all_view');
	const checkboxes_all_edit   = document.querySelectorAll('.checkboxes_all_edit');
	const checkboxes_all_delete = document.querySelectorAll('.checkboxes_all_delete');
	
	const selector = {
		1: '.access_permission',
		2: '.view_permission',
		3: '.edit_permission',
	}[value] || '.delete_permission';
	
	const checkboxes = document.querySelectorAll(selector);
	
	if (checkboxes.length > 0)
	{
		checkboxes.forEach(checkbox => {
			if(value == 1)
			{
				if(checkboxes_all_access[0].checked != checkbox.checked)
				{
					checkbox.checked = !checkbox.checked;
				}
			}
			if(value == 2)
			{
				if(checkboxes_all_view[0].checked != checkbox.checked)
				{
					checkbox.checked = !checkbox.checked;
				}
			}
			if(value == 3)
			{
				if(checkboxes_all_edit[0].checked != checkbox.checked)
				{
					checkbox.checked = !checkbox.checked;
				}
			}
			if(value == 4)
			{
				if(checkboxes_all_delete[0].checked != checkbox.checked)
				{
					checkbox.checked = !checkbox.checked;
				}
			}
		});
	}
}

const submit = async () => {
	
	if(empty(user_id.value) && props.update == true)
	{
		return show_msgbox('Incapaz de processar a solicitação!', 'error');
	}
	if(empty(name.value))
	{
		return show_msgbox('O Campo NOME é obrigatório!', 'warning');
	}
	if(empty(surname.value))
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
		return show_msgbox('O Campo USERNAME é obrigatório!', 'warning');
	}
	if(empty(password.value) && props.update == false)
	{
		return show_msgbox('O Campo SENHA é obrigatório!', 'warning');
	}
	if(empty(situation.value))
	{
		return show_msgbox('O Campo SITUAÇÃO é obrigatório!', 'warning');
	}
	
	const checkboxes = document.querySelectorAll('.checkbox_permission');
	permissionIds.value = [];
	checkboxes.forEach(checkbox => {
		if(checkbox.checked == true)
		{
			permissionIds.value.push(checkbox.value);
		}
	});
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		let response = '';
		let data = {
			people : 'F',
			id : id.value,
			user_id : user_id.value,
			username : username.value,
			password : password.value,
			name : name.value,
			surname : surname.value,
			email : email.value,
			phone: phone.value,
			whatsapp: whatsapp.value,
			situation: situation.value,
			permissionIds: permissionIds.value
		};
		
		if(props.update == false)
		{
			response = await store.dispatch('insertCollaborator', data);
		}
		else
		{
			response = await store.dispatch('updateCollaborator', data);
		}
		
		try
		{
			await store.dispatch('getCollaborators', {
				srch_username :store.state.collaborator.filters.srch_username,
				srch_email : store.state.collaborator.filters.srch_username,
				srch_situation : store.state.collaborator.filters.srch_username
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

const validateUsername = () => {
	let regExpUsername = /[^a-z0-9_]/g;
	if(username.value.match(regExpUsername)){
		username.value = username.value.replace(regExpUsername,'');
	}
}

const PHONEOnlyNumbers = () => {
	phone.value = keepNumbersOnly(phone.value);
}

const WHATSAPPOnlyNumbers = () => {
	whatsapp.value = keepNumbersOnly(whatsapp.value);
}
</script>