<template>
	<main>
		<div class="page-content">
			<div class="table">
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><router-link to="/"><i class="fas fa-home-lg"></i></router-link></li>
							<li class="active">Pedido</li>
						</ol>
					</div>
					<div>
						<a href="#" class="f_show_register" @click="showModalCreate" v-if="$can('edit_order')"><i class="fas fa-lg fa-plus"></i></a>
						<a href="#" class="f_show_register_disabled" v-else><i class="fas fa-lg fa-plus"></i></a>
						<a href="#" class="f_show_delete" @click="destroyOrder" v-if="$can('delete_order')"><i class="fas fa-lg fa-trash-alt"></i></a>
						<a href="#" class="f_show_delete_disabled" v-else><i class="fas fa-lg fa-trash-alt"></i></a>
					</div>
				</div>
				<Filters 
					v-model:srch_code="filters.srch_code"
					v-model:srch_destination="filters.srch_destination" 
					v-model:srch_object="filters.srch_object" 
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
								<th>Destinatário</th>
								<th>Transportadora</th>
								<th>Código Pedido</th>
								<th>Objeto</th>
								<th>Última Situação</th>
							</tr>
						</thead>
						<tbody>
							<tr v-if="!items.data">
								<td colspan="7" class="table_empty ">
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
										<a v-if="$can('edit_order')"><i class="fas fa-pen-square fa-lg fa-fw" @click.prevent="btnEditOrder(item)"></i></a>
										<a v-else><i class="fas fa-pen-square fa-lg fa-fw btn_color_disabled"></i></a>
										<a v-if="$can('view_order')"><i class="fas fa-file-alt fa-lg fa-fw" @click.prevent="btnRecordOrder(item)"></i></a>
										<a v-else><i class="fas fa-file-alt fa-lg fa-fw btn_color_disabled"></i></a>
									</div>
								</td>
								<td class="td_format">{{ item.destination }}</td>
								<td v-if="item.shipping_company == 0" class="td_format">Correios</td>
								<td v-else-if="item.shipping_company == 1" class="td_format">Jadlog</td>
								<td v-else-if="item.shipping_company == 2" class="td_format">J&T Express</td>
								<td v-else-if="item.shipping_company == 3" class="td_format">Latam Cargo</td>
								<td v-else class="td_format">Loggi</td>
								<td class="td_format">{{ item.code }}</td>
								<td class="td_format">{{ item.object }}</td>
								<td v-if="item.last_situation == 0" class="td_format"><b class="pending">Pendente</b></td>
								<td v-else-if="item.last_situation == 1" class="td_format"><b class="post_request">Pedido postado</b></td>
								<td v-else-if="item.last_situation == 2" class="td_format"><b class="in_transit">Em trânsito</b></td>
								<td v-else-if="item.last_situation == 3" class="td_format"><b class="in_process">Saiu entrega</b></td>
								<td v-else-if="item.last_situation == 4" class="td_format"><b class="out_for_delivery">Entregue</b></td>
								<td v-else class="td_format"><b class="issue">Com problemas</b></td>
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
			<Record :data="formRecord" @hideModalRecord="hideModalRecord" :titleModal="titleModal"/>
		</vue-final-modal>
		<!-- End Modal View -->
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
			<CreateUpdate :form="form" @hideModalCreateUpdate="hideModalCreateUpdate" :update="update" :titleModal="titleModal"/>
		</vue-final-modal>
		<!-- End Modal Create e Update -->
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
	width: 1%;
	margin: 0 auto;
}
.table_section thead tr th:nth-child(2) {
	width: 0.1%;
	margin: 0 auto;
	text-align: center;
}
.table_section thead tr th:nth-child(3) {
	width: 40%;
	margin: 0 auto;
	text-align: left;
}
.table_section thead tr th:nth-child(4) {
	width: 12%;
	margin: 0 auto;
	text-align: left;
}
.table_section thead tr th:nth-child(5) {
	width: 10%;
	margin: 0 auto;
	text-align: left;
}
.table_section thead tr th:nth-child(6) {
	width: 8%;
	margin: 0 auto;
	text-align: left;
}
.table_section thead tr th:nth-child(7) {
	width: 12%;
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
.fa-home-lg {
	color:#fff;
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
	font-size: 13px;
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
	width: 550px;
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
.pending {
	color: #ff0000;;
}
.post_request {
	color: #0000ff;
}
.in_transit {
	color: #008000;
}
.in_process {
	color: #ffa500;
}
.out_for_delivery {
	color: #800080;
}
.delivered {
	color: #000000;
}
.alert {
	color: #ffff00;
}
.issue {
	color: #a52a2a;
}
.td_format {
	font-size:10.1px !important;
}
.btn_color_disabled {
	color:#C8C8C8;
}
/* End Aux */

</style>
<script setup>
import { ref, watch } from 'vue';
import Filters from './partials/Filters.vue';
import Record from './partials/Record.vue';
import CreateUpdate from './partials/CreateUpdate.vue';
import { useStore } from 'vuex';
import Pagination from '@/components/Pagination.vue';
import { show_msgbox, confirm_alert } from '@/helpers/Helpers';

/* Ref or Reactive */
const statusModalRecord = ref(false);
const statusModalCreateUpdate = ref(false);
const store = useStore();
const checkboxIds = ref([]);
const checkbox = ref(false);
const checkboxAll = ref(false);
const filters = ref({
	srch_destination: '',
	srch_object: '',
	srch_situation: '',
	srch_code: '',
});
const form        = ref({});
const formRecord  = ref({});
const titleModal  = ref('');
const items       = ref([]);
const update      = ref(false);

/* Events */
watch(() => store.state.order.data,
			() => {
				items.value = store.state.order.data;
});

/* Functions */
const hideModalRecord = () => {
	statusModalRecord.value = false;
}

const btnSearch = async () => {
	store.commit('CHANGE_LOADING', true);
	
	try {
		await store.dispatch('getOrder', {
			srch_code : filters.value.srch_code,
			srch_destination : filters.value.srch_destination,
			srch_object : filters.value.srch_object,
			srch_situation: filters.value.srch_situation,
		});
		
		clearCheckboxs();
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const refreshTableOfDatas = async (value = '') => {
	store.commit('CHANGE_LOADING', true);
	
	try {
		await store.dispatch('getOrder', {
			srch_code : filters.value.srch_code,
			srch_destination : filters.value.srch_destination,
			srch_object : filters.value.srch_object,
			srch_situation: filters.value.srch_situation,
			page: value
		});
		
		clearCheckboxs();
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const changePage = async (value) => {
	refreshTableOfDatas(value);
};

const showModalCreate = () => {
	form.value = {};
	statusModalCreateUpdate.value = true;
	statusModalRecord.value = false;
	update.value  = false;
	titleModal.value = 'Adicionar Template';
}

const hideModalCreateUpdate = () => {
	statusModalCreateUpdate.value = false;
	statusModalRecord.value = false;
}

const btnEditOrder = async (item) => {
	form.value = item;
	update.value = true;
	statusModalCreateUpdate.value = true;
	titleModal.value = 'Editar Pedido';
}

const btnRecordOrder = async (item) => {
	formRecord.value = item;
	statusModalRecord.value = true;
	titleModal.value = 'Visualizar Pedido';
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

const destroyOrder = async () => {
	if(checkboxIds.value.length == 0)
	{
		return show_msgbox('Nenhum registro selecionado!', 'warning');
	}
	
	if(await confirm_alert('Tem certeza que deseja apagar esse registro. Confirma?') == true)
	{
		store.commit('CHANGE_LOADING', true);
		
		const delIds = { ...checkboxIds.value };
		
		let cap = '';
		let ids = '';
		Object.values(delIds).forEach(item => {
			if(ids){ cap=','; } else { cap=''; }
			ids += cap+item;
		});
		
		store.dispatch('destroyOrder', {
			ids : ids
		})
		.then((response) => {
			refreshTableOfDatas();
			
			store.commit('CHANGE_LOADING', false);
			return show_msgbox(response, 'success');
		})
		.catch((error) => {
			refreshTableOfDatas();
			return show_msgbox(error.data.message, 'warning');
		});
	}
}

const clearCheckboxs = () => {
	checkboxAll.value = false;
	checkbox.value = false;
	checkboxIds.value = [];
}
</script>