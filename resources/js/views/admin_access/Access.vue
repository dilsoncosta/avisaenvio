<template>
	<main>
		<div class="page-content">
			<div>
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><router-link to="/"><i class="fas fa-home-lg"></i></router-link></li>
							<li class="active">Acesso</li>
						</ol>
					</div>
					<div></div>
				</div>
				<br/>
				<div class="content">
					<div class="form_area">
						<div class="form_group">
							<label>Cliente:</label>
							<Multiselect
								v-model="clients.value"
								v-bind="clients"
								@select='handleClient($event)'>>
							</Multiselect>
						</div>
						<div class="form_group" v-if="showInput">
							<label>Periodo:</label>
							<select name="situation" v-model="period">
								<option></option>
								<option value="0">Semestral</option>
								<option value="1">Mensal</option>
								<option value="2">Anual</option>
							</select>
						</div>
						<div class="form_group" v-if="showInput">
							<label>Tipo:</label>
							<select name="situation" v-model="type">
								<option></option>
								<option value="T">Teste</option>
								<option value="P">Produção</option>
							</select>
						</div>
						<div class="form_group" v-if="showInput">
							<label>Data Inicio:</label>
							<input type="date" name="date_start" v-model="date_start">
						</div>
						<div class="form_group" v-if="showInput">
							<label>Data Fim:</label>
							<input type="date" name="date_end" v-model="date_end">
						</div>
						<div class="form_group" v-if="showInput">
							<label>Módulo Portal:</label>
							<select name="ind_mod_portal" v-model="ind_mod_portal">
								<option></option>
								<option value="1">Sim</option>
								<option value="0">Não</option>
							</select>
						</div>
						<div class="form_group" v-if="showInput">
							<label>Módulo CRM:</label>
							<select name="ind_mod_crm" v-model="ind_mod_crm">
								<option></option>
								<option value="1">Sim</option>
								<option value="0">Não</option>
							</select>
						</div>
						<div class="form_group" v-if="showInput">
							<label>Módulo Loja:</label>
							<select name="ind_mod_store" v-model="ind_mod_store">
								<option></option>
								<option value="1">Sim</option>
								<option value="0">Não</option>
							</select>
						</div>
						<div class="form_group" v-if="showInput">
							<label>Quantidade de Contatos:</label>
							<input type="text" name="qtd_contact" v-model="qtd_contact">
						</div>
						<div class="form_group" v-if="showInput">
							<label>Quantidade de Franqueados:</label>
							<input type="text" name="qtd_franchise" v-model="qtd_franchise">
						</div>
						<div class="form_group" v-if="showInput">
							<label>Quantidade de Colaboradores do Franqueado:</label>
							<input type="text" name="qtd_franchise_collaborator" v-model="qtd_franchise_collaborator">
						</div>
						<div class="form_group" v-if="showInput">
							<label>Situação:</label>
							<select name="situation" v-model="situation">
								<option></option>
								<option value="I">Inativo</option>
								<option value="A">Ativo</option>
								<option value="S">Suspenso</option>
								<option value="E">Expirado</option>
							</select>
						</div>
					</div>
					<div class="button_area">
						<button @click.prevent="handleSave">Salvar</button>
					</div>
				</div>
			</div>
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
	padding:20px;
}
.container .header {
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
.page-content {
	margin: 30px;
	background-color: #fff;
	border-radius: 0.25rem;
	padding: 20px;
}
.form_area {
	display: grid;
	grid-template-columns: repeat(1, 1fr);
	gap: 10px;
}
.form_area .form_group {
	padding:5px 0px;
}
.fa-home-lg {
	color:#fff;
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
.button_area {
	display: flex;
	justify-content: center;
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
	width: 100%;
}
button:hover {
	background-color: #f8d039 !important;
	border-color: #ef9900 !important;
	color:#000000 !important;
	opacity: 0.9;
}
input[name=name], input[name=surname] {
  text-transform: uppercase;
}
@media(max-width: 800px) {
	.form_area {
		display: grid;
		grid-template-columns: repeat(1, 1fr);
		gap: 10px;
	}
}
.multiselect {
	margin-top:5px;
}
</style>
<script setup>
import { ref, onMounted } from 'vue';
import { show_msgbox, empty } from '@/helpers/Helpers';
import { useStore } from 'vuex';

/* Ref or Reactive */
const store    = useStore();
const clients = ref({
	mode: 'single',
	value: null,
	closeOnSelect: true,
	options: [],
	searchable: true,
	createOption: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado",
});
const period      = ref('');
const type        = ref('');
const date_end    = ref('');
const date_start  = ref('');
const ind_mod_portal = ref('0');
const ind_mod_crm    = ref('0');
const ind_mod_store  = ref('0');
const qtd_franchise              = ref('0');
const qtd_franchise_collaborator = ref('0');
const qtd_contact                = ref('0');
const situation   = ref('');
const showInput   = ref(false);

/* Events */
onMounted( async () => {
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await store.dispatch('genereateOptionsTenants');
		
		response.forEach(item => {
			if(item.user.people == 'F')
			{
				clients.value.options.push({ value: item.id, label: `${item.user.name.toLowerCase()} 
			| ${item.user.email} | Fisica | ${item.user.subdomain}`});
			}
			else
			{
				clients.value.options.push({ value: item.id, label: `${item.user.corporate_name.toLowerCase()} 
			| ${item.user.email} | Juridica | ${item.user.subdomain}`});
			}
		});
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning', 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
});

/* Functions */
const handleClient = async (value) => {
	store.commit('CHANGE_LOADING', true);

	if(empty(value))
	{
		return show_msgbox('Incapaz de processar a solicitação!', 'error');
	}
	
	try {
		const access = await store.dispatch('getAccess',{
			tenant_id: value
		});
		
		period.value      = access.data.period;
		type.value        = access.data.type;
		date_start.value  = access.data.date_start;
		date_end.value    = access.data.date_end;
		situation.value   = access.data.situation;
		ind_mod_portal.value             = access.data.ind_mod_portal;
		ind_mod_crm.value                = access.data.ind_mod_crm;
		ind_mod_store.value              = access.data.ind_mod_store;
		qtd_contact.value                = access.data.qtd_contact;
		qtd_franchise.value              = access.data.qtd_franchise;
		qtd_franchise_collaborator.value = access.data.qtd_franchise_collaborator;

		showInput.value   = true;
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}
const handleSave = async () => {
	
	if(empty(clients.value.value))
	{
		return show_msgbox('O Campo CLIENTE é obrigatório!', 'warning');
	}
	if(empty(period.value))
	{
		return show_msgbox('O Campo PERIODO é obrigatório!', 'warning');
	}
	if(empty(type.value))
	{
		return show_msgbox('O Campo TIPO é obrigatório!', 'warning');
	}
	if(empty(date_start.value))
	{
		return show_msgbox('O Campo DATA INICIO é obrigatório!', 'warning');
	}
	if(empty(date_end.value))
	{
		return show_msgbox('O Campo DATA FIM é obrigatório!', 'warning');
	}
	if(empty(ind_mod_portal.value))
	{
		return show_msgbox('O Campo MÓDULO PORTAL é obrigatório!', 'warning');
	}
	if(empty(ind_mod_crm.value))
	{
		return show_msgbox('O Campo MÓDULO CRM é obrigatório!', 'warning');
	}
	if(empty(ind_mod_store.value))
	{
		return show_msgbox('O Campo MÓDULO LOJA é obrigatório!', 'warning');
	}
	if(empty(qtd_contact.value))
	{
		return show_msgbox('O Campo QUANTIDADE DE CONTATOS é obrigatório!', 'warning');
	}
	if(empty(qtd_franchise.value))
	{
		return show_msgbox('O Campo QUANTIDADE DE FRANQUEADOS é obrigatório!', 'warning');
	}
	if(empty(qtd_franchise_collaborator.value))
	{
		return show_msgbox('O Campo QUANTIDADE DE COLABORADORES DO FRANQUEADO é obrigatório!', 'warning');
	}
	if(empty(situation.value))
	{
		return show_msgbox('O Campo SITUAÇÃO é obrigatório!', 'warning');
	}

	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await store.dispatch('updateAccess', {
			tenant_id : clients.value.value,
			period : period.value,
			type : type.value,
			date_start : date_start.value,
			date_end: date_end.value,
			ind_mod_portal : ind_mod_portal.value,
			ind_mod_crm : ind_mod_crm.value,
			ind_mod_store : ind_mod_store.value,
			qtd_contact : qtd_contact.value,
			qtd_franchise : qtd_franchise.value,
			qtd_franchise_collaborator : qtd_franchise_collaborator.value,
			situation: situation.value
		});
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