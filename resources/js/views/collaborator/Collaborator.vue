<template>
	<main>
		<div class="page-content">
			<div class="table">
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><a>Configuração</a></li>
							<li class="active">Colaborador </li>
						</ol>
					</div>
					<div>
						<a href="#" class="f_show_register" @click="showModalCreate" v-if="$can('edit_config_collaborator')"><i class="fas fa-lg fa-plus"></i></a>
						<a href="#" class="f_show_register_disabled" v-else><i class="fas fa-lg fa-plus"></i></a>
						<a href="#" class="f_show_delete" @click="destroyCollaborator" v-if="$can('delete_config_collaborator')"><i class="fas fa-lg fa-trash-alt"></i></a>
						<a href="#" class="f_show_delete_disabled" v-else><i class="fas fa-lg fa-trash-alt"></i></a>
					</div>
				</div>
				<Filters 
					v-model:srch_username="filters.srch_username" 
					v-model:srch_email="filters.srch_email" 
					v-model:srch_situation="filters.srch_situation" 
				/>
				<div class="container_btn_search">
					<button class="btn_search" @click.prevent="btnSearch"><i class="fas fa-search"></i> Buscar</button>
				</div>
				<div class="table_section">
					<table>
						<thead>
							<tr>
								<th>
									<div class="container_checkbox"><input type="checkbox" id="select_all" class="dt_checkbox" @click="handleCheckboxAll" :checked="checkboxAll"></div>
								</th>
								<th>
									<i class="fas fa-chevron-down"></i>
								</th>
								<th>Nome e Sobrenome</th>
								<th>Username</th>
								<th>Email</th>
								<th>Situação</th>
							</tr>
						</thead>
						<tbody>
							<tr v-if="!items.data">
								<td colspan="6" class="table_empty ">
									Nenhum registro encontrado
								</td>
							</tr>
							<tr v-else v-for="(item, index) in items.data" :key="index">
								<td>
									<div class="container_checkbox">
										<input type="checkbox" :value="item.id" v-model="checkboxIds" class="checkbox dt_checkbox" :checked="checkbox">
									</div>
								</td>
								<td>
									<div class="options">
										<a v-if="$can('edit_config_collaborator')"><i class="fas fa-pen-square fa-lg fa-fw" @click.prevent="btnEditCollaborator(item)"></i></a>
										<a v-else><i class="fas fa-pen-square fa-lg fa-fw btn_color_disabled"></i></a>
										<a v-if="$can('view_config_collaborator')"><i class="fas fa-file-alt fa-lg fa-fw" @click.prevent="btnRecordCollaborator(item)"></i></a>
										<a v-else><i class="fas fa-file-alt fa-lg fa-fw btn_color_disabled"></i></a>
									</div>
								</td>
								<td class="td_size">{{ `${item.user.name} ${item.user.surname}` }}</td>
								<td class="td_size">{{ item.user.username }}</td>
								<td class="td_size">{{ item.user.email }}</td>
								<td v-if="item.user.situation == 1" class="td_size"><b class="active">Ativo</b></td>
								<td v-else class="td_size"><b class="inactive">Inativo</b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="section_pagination" v-if="items != ''">
					<Pagination 
						:pagination="items"
						@changePage="changePage"
					/>
				</div>
			</div>
		</div>
		<!--Modal Create e Update -->
		<vue-final-modal 
			v-model="statusModalCreateUpdate" 
			classes="modal-container" 
			content-class="modal-content" 
			:lock-scroll="true"
			:hide-overlay="false"
			:click-to-close="false"
			:esc-to-close="true"
			:prevent-click="true"
			transition="vfm"
			overlay-transition="vfm"
		>
			<CreateUpdate :form="form" @hideModalCreateUpdate="hideModalCreateUpdate" :update="update" :resources_general="resources_general" :resources_config="resources_config" :titleModal="titleModal"/>
		</vue-final-modal>
		<!-- End Modal Create e Update -->
		<!--Modal View -->
		<vue-final-modal 
			v-model="statusModalRecord" 
			classes="modal-container" 
			content-class="modal-content" 
			:lock-scroll="true"
			:hide-overlay="false"
			:click-to-close="false"
			:esc-to-close="true"
			:prevent-click="true"
			transition="vfm"
			overlay-transition="vfm"
			>
			<Record :data="record" @hideModalRecord="hideModalRecord" :titleModal="titleModal" :resources_general="resources_general" :resources_config="resources_config"/>
		</vue-final-modal>
		<!-- End Modal View -->
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
.container_btn_search {
	margin: 10px 0px;
}
.btn_search {
	width: 100%;
	border: 0;
	outline: none;
	color: #000000;
	background-color: #d8d8d8;
	border: 1px solid #919191;
	padding: 10px 16px;
	font-size: 18px;
	line-height: 1.3333333;
	border-radius: 5px;
	cursor: pointer;
	margin-bottom: 20px;
}
.table {
	width: 100%;
}

td button:nth-child(1) {
	background-color: #0298cf;
}
td button:nth-child(2) {
	background-color: #f80000;
}
.table_section thead tr th {
	font-size: 13px;
}
.table_section thead tr th:nth-child(1){
	width: 0.1%;
	margin: 0 auto;
}
.table_section thead tr th:nth-child(2) {
	width: 0.1%;
	margin: 0 auto;
	text-align: center;
}
.table_section thead tr th:nth-child(3) {
	width: 450px;
	margin: 0 auto;
	text-align: left;
}
.table_section thead tr th:nth-child(4) {
	width: 450px;
	margin: 0 auto;
	text-align: left;
}
.table_section thead tr th:nth-child(5) {
	width: 450px;
	margin: 0 auto;
	text-align: left;
}
.table_section thead tr th:nth-child(6) {
	width: 100px;
	margin: 0 auto;
	text-align: left;
}
tr td {
	display: table-cell;
}
.container_checkbox {
	display: flex;
	justify-content: center;
	align-items: center;
}
.dt_checkbox {
	height: 17px;
	width: 17px;
}
.options {
	display: flex;
	justify-content: center;
	align-items: center;
	color:#5a728e;
	font-size: 12px;
}
.options a:hover{
	opacity: 0.9;
}
.options a i{
	cursor: pointer;
}
.table_section {
	overflow: auto;
}
table {
	width: 100%;
	min-width: 900px;
	border-collapse: collapse;
}
thead th {
	color: #8493a5;
	font-size: 15px;
}
tr {
	font-size: 14px;
}
tbody tr:nth-child(even) {background: #f9f9f9}
th,td {
	border: 1px solid #dddddd;
	padding: 8px;
	word-break: break-all;
	text-align: left;
}
.table_empty {
	text-align: center;
}
::-webkit-scrollbar {
	height: 5px;
	width: 5px;
}
::-webkit-scrollbar-track {
	box-shadow: inset 0 0 6px rgba(0,0,0,0,3);
}
::-webkit-scrollbar-thumb {
	box-shadow: inset 0 0 6px rgba(0,0,0,0,3);
}
.section_pagination {
	margin-top: 10px;
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
.header .f_show_register_disabled {
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
	background-color: #C5C7CB;
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
.header .f_show_delete_disabled {
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
	background-color: #C8C8C8;
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

/* Modal */
:deep(.modal-content){
	position: relative;
	display: flex;
	flex-direction: column;
	margin: 0 1rem;
	padding: 1rem;
	border: 1px solid #e2e8f0;
	border-radius: 0.25rem;
	background: #fff;
	min-width: 550px;
}
:deep(.modal-container){
	display: flex;
	justify-content: center;
	align-items: flex-start;
	padding:30px;
	pointer-events: auto;
}
:deep(.vfm--absolute){
	overflow-y: auto;
}
/* End Modal */

/* Aux */
.active {
	color:#008000;
}
.inactive {
	color:#ff0000;
}
.td_size {
	font-size:11px;
}
.btn_color_disabled {
	color:#C8C8C8;
}
/* End Aux */

</style>
<script setup>
import { ref, watch, toRaw, onMounted, computed } from 'vue';
import Filters from './partials/Filters.vue';
import Record from './partials/Record.vue';
import CreateUpdate from './partials/CreateUpdate.vue';
import { useStore } from 'vuex';
import Pagination from '@/components/Pagination.vue';
import { show_msgbox } from '@/helpers/Helpers';
import Swal from 'sweetalert2';

/* Ref or Reactive */

const store = useStore();
const statusModalCreateUpdate = ref(false);
const statusModalRecord       = ref(false);
const checkboxIds = ref([]);
const checkbox    = ref(false);
const checkboxAll = ref(false);
const filters = ref({
	srch_username: '',
	srch_email: '',
	srch_situation: '',
});
const form       = ref({});
const record     = ref({});
const titleModal = ref('');
const update     = ref(false);
const items      = ref([]);
const resources_general = ref([]);
const resources_config = ref([]);
const ind_mod_order_tracking = computed(() => store.state.auth.me.ind_mod_order_tracking);
const ind_mod_hotel = computed(() => store.state.auth.me.ind_mod_hotel);

/* Events */
watch(() => store.state.collaborator.data,
			() => {
				items.value = store.state.collaborator.data;
});

onMounted( async () => {
	store.commit('CHANGE_LOADING', true);

	const response = await store.dispatch('getResourcesCollaborator');

	// Module Portal
	response.data.forEach(item => {
		switch (item.id)
		{
			case 1:
			resources_general.value.push(item);
			case 2:
				if(ind_mod_order_tracking.value == 0){ return; }
				resources_general.value.push(item);
			case 8:
				if(ind_mod_hotel.value == 0){ return; }
				resources_general.value.push(item);
				break;
			default:
				break;
		}
	});
	
	// Module Config
	response.data.forEach(item => {
		switch (item.id)
		{
			case 3:
				resources_config.value.push(item);
				break;
			case 4:
				resources_config.value.push(item);
				break;
			case 5:
				if(ind_mod_order_tracking.value == 0){ return; }
				resources_config.value.push(item);
				break;
			case 6:
				if(ind_mod_order_tracking.value == 0){ return; }
				resources_config.value.push(item);
				break;
			case 7:
				if(ind_mod_hotel.value == 0){ return; }
				resources_config.value.push(item);
				break;
			case 9:
				resources_config.value.push(item);
				break;
			case 10:
				if(ind_mod_order_tracking.value == 0){ return; }
				resources_config.value.push(item);
				break;
			default:
				break;
		}
	});
	
	store.commit('CHANGE_LOADING', false);
});

/* Functions */
const showModalCreate = () => {
	form.value = {};
	statusModalCreateUpdate.value = true;
	statusModalRecord.value = false;
	update.value  = false;
	titleModal.value = 'Adicionar Colaborador';
}

const hideModalCreateUpdate = () => {
	statusModalCreateUpdate.value = false;
	statusModalRecord.value = false;
}

const hideModalRecord = () => {
	statusModalRecord.value = false;
}

const btnSearch = async () => {
	store.commit('CHANGE_LOADING', true);
	
	try {
		await store.dispatch('getCollaborators', {
			srch_username : filters.value.srch_username,
			srch_email: filters.value.srch_email,
			srch_situation: filters.value.srch_situation,
		});
		
		clearCheckboxs();
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning', 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const refreshTableOfDatas = async (value = '') => {
	store.commit('CHANGE_LOADING', true);
	
	try {
		await store.dispatch('getCollaborators', {
			srch_username : filters.value.srch_username,
			srch_email: filters.value.srch_email,
			srch_situation: filters.value.srch_situation,
			page: value,
		});
		
		clearCheckboxs();
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning', 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const changePage = async (value) => {
	refreshTableOfDatas(value);
};

const btnEditCollaborator = async (item) => {
	form.value = item;
	update.value = true;
	statusModalCreateUpdate.value = true;
	titleModal.value = 'Editar Colaborador';
}

const btnRecordCollaborator = async (item) => {
	record.value = item;
	statusModalRecord.value = true;
	titleModal.value = 'Visualizar Colaborador';
}

const handleCheckboxAll = () => {
	checkboxIds.value = [];
	const checkboxs = document.querySelectorAll('.checkbox');
	
	checkboxAll.value = !checkboxAll.value;
	
	checkboxIds.value = [];
	checkboxs.forEach((e) => {
		checkbox.value = !e.checked;
		
		if(checkboxAll.value == true)
		{
			checkboxIds.value.push(e.value);
		}
	});
}

const destroyCollaborator = async () => {
	if(checkboxIds.value.length == 0)
	{
		return show_msgbox('Nenhum registro selecionado!', 'warning');
	}
	
	Swal.fire({
		text: "Tem certeza que deseja apagar esse registro. Confirma?",
		icon: 'warning',
		showCancelButton: true,
		cancelButtonText: 'Não',
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sim'
	}).then((result) => {
		if(result.value == true)
		{
			store.commit('CHANGE_LOADING', true);
			
			const delIds = { ...checkboxIds.value };
			
			let cap = '';
			let ids = '';
			Object.values(delIds).forEach(item => {
				if(ids){ cap=','; } else { cap=''; }
				ids += cap+item;
			});
			
			store.dispatch('destroyCollaborator', {
				ids : ids
			})
			.then((response) => {
				refreshTableOfDatas();
				store.commit('CHANGE_LOADING', false);
				return show_msgbox(response, 'success');
			})
			.catch((error) => {
				refreshTableOfDatas();
				store.commit('CHANGE_LOADING', false);
				return show_msgbox(error.data.message, 'warning');
			});
		}
	});
}

const clearCheckboxs = () => {
	checkboxAll.value = false;
	checkbox.value = false;
	checkboxIds.value = [];
}
</script>