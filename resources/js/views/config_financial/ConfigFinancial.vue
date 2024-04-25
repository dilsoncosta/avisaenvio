<template>
	<main>
		<div class="page-content">
			<div class="table">
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><a>Configuração</a></li>
							<li class="active">Financeiro</li>
						</ol>
					</div>
					<div>
						<button class="btn_signature" role="button" @click.prevent="showModalCreateSignature()" v-if="signature_situation != 1"> &nbsp;CONTRATAR&nbsp; </button>
						<button class="btn_signature_canceled" role="button" @click.prevent="btnCanceled()" v-else> &nbsp;CANCELAR&nbsp; </button>
					</div>
				</div>
				<br/>
				<h4 class="title">Acesso</h4>
				<div class="totals">
					<div class="item_total">
						<p class="title"><b>Acesso até:</b></p>
						<div class="total">{{ formatDate(access_date_end, 1)}}</div>
					</div>
					<div class="item_total" v-if="access_ind_hotel == 1">
						<p class="title"><b>Módulo Hotelaria:</b></p>
						<div class="total">Ativo</div>
					</div>
					<div class="item_total" v-if="access_ind_mod_order_tracking == 1">
						<p class="title"><b>Módulo Rastreio de Encomenda:</b></p>
						<div class="total">Ativo</div>
					</div>
					<div class="item_total">
						<p class="title"><b>Situação:</b></p>
						<div class="total situation_green" v-if="access_situation == 'A'">Ativo</div>
						<div class="total situation_red" v-else-if="access_situation == 'I'">Inativo</div>
						<div class="total situation_red" v-else-if="access_situation == 'S'">Suspenso</div>
						<div class="total situation_red" v-else-if="access_situation == 'C'">Cancelado</div>
						<div class="total situation_red" v-else>Expirado</div>
					</div>
				</div>
				<br/>
				<h4 class="title">Assinatura</h4>
				<div class="totals">
					<div class="item_total" v-if="signature_frequency">
						<p class="title"><b>Periodicidade:</b></p>
						<div class="total" v-if="signature_frequency == 0">Semestral</div>
						<div class="total" v-else-if="signature_frequency == 1">Mensal</div>
						<div class="total" v-else>Anual</div>
					</div>
					<div class="item_total" v-else>
						<p class="title"><b>Periodicidade:</b></p>
						<div class="total">---</div>
					</div>
					<div class="item_total" v-if="signature_total">
						<p class="title"><b>Valor Mensalidade:</b></p>
						<div class="total">{{ formatMoneyBRL(signature_total) }}</div>
					</div>
					<div class="item_total" v-else>
						<p class="title"><b>Valor Mensalidade:</b></p>
						<div class="total">---</div>
					</div>
					<div class="item_total" v-if="signature_payment">
						<p class="title"><b>Forma Pagamento:</b></p>
						<div class="total" v-if="signature_payment == 0">Depósito</div>
						<div class="total" v-else-if="signature_payment == 1">Boleto Bancário</div>
						<div class="total" v-else-if="signature_payment == 2">Cartão de Crédito</div>
						<div class="total" v-else>Pix</div>
					</div>
					<div class="item_total" v-else>
						<p class="title"><b>Forma Pagamento:</b></p>
						<div class="total">---</div>
					</div>
					<div class="item_total" v-if="signature_ind_mod_hotel == 1">
						<p class="title"><b>Módulo Hotelaria:</b></p>
						<div class="total">Contratado</div>
					</div>
					<div class="item_total" v-if="signature_ind_mod_order_tracking == 1">
						<p class="title"><b>Módulo Rastreio de Encomenda:</b></p>
						<div class="total">Contratado</div>
					</div>
					<div class="item_total" v-if="signature_situation">
						<p class="title"><b>Situação:</b></p>
						<div class="total situation_green" v-if="signature_situation == 1">Ativo</div>
						<div class="total situation_red" v-else-if="signature_situation == 2">Cancelado</div>
						<div class="total situation_red" v-else>Inativo</div>
					</div>
					<div class="item_total" v-else-if="signature_situation == 2">
						<p class="title"><b>Situação:</b></p>
						<div class="total situation_red">Cancelado</div>
					</div>
					<div class="item_total" v-else>
						<p class="title"><b>Situação:</b></p>
						<div class="total">---</div>
					</div>
				</div>
				<br/>
				<h4 class="title title_charge">Cobrança</h4>
				<table>
					<thead>
						<tr>
							<th>Fatura</th>
							<th>Vencimento</th>
							<th>Valor</th>
							<th>Pagamento</th>
							<th>Situação</th>
							<th>Comprovante</th>
						</tr>
					</thead>
					<tbody v-if="charges.length > 0">
						<tr v-for="(item, index) in charges" :key="index">
							<td>{{ item.asaas_invoice_number }}</td>
							<td>{{  formatDate(item.venc ) }}</td>
							<td>{{ formatMoneyBRL(item.total) }}</td>
							<td v-if="item.type == 0">Depósito</td>
							<td v-else-if="item.type == 1">Boleto Bancário</td>
							<td v-else-if="item.type == 2">Cartão de Crédito</td>
							<td v-else>Pix</td>
							<td v-if="item.situation == 0">Pendente</td>
							<td v-else-if="item.situation == 1">Pago</td>
							<td v-else>Cancelado</td>
							<td v-if="item.asaas_transition_receipt_url"><a :href="item.asaas_transition_receipt_url" target="_black"><i class="fas fa-eye"></i></a></td>
							<td v-else><i class="fas fa-eye fa-eye-disabled"></i></td>
						</tr>
					</tbody>
					<tbody v-else>
						<td colspan="6">Nenhuma cobrança encontrada</td>
					</tbody>
				</table>
			</div>
		</div>
		<!--Modal Create e Update -->
		<vue-final-modal 
			v-model="statusModalCreateSignature" 
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
			<CreateSignature :optionsStates="optionsStates" :titleModal="titleModal" @getSignature="getSignature" @getCharge="getCharge" @hideModalCreateSignature="hideModalCreateSignature" />
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
.input_required {
	color:#ff0000;
}
.text_inputs_required {
	margin-top:17px;
	font-size:12px;
}
/* End Inputs */

/* Table */
table {
	width: 100%;
	min-width: 900px;
	border-collapse: collapse;
}
td button:nth-child(1) {
	background-color: #0298cf;
}
td button:nth-child(2) {
	background-color: #f80000;
}
thead tr th {
	font-size: 13px;
}
thead tr th:nth-child(1){
	width: 10%;
	margin: 0 auto;
}
thead tr th:nth-child(2) {
	width: 10%;
	margin: 0 auto;
	text-align: center;
}
thead tr th:nth-child(3) {
	width: 10%;
	margin: 0 auto;
	text-align: center;
}
thead tr th:nth-child(4) {
	width: 10%;
	margin: 0 auto;
	text-align: center;
}
thead tr th:nth-child(5) {
	width: 10%;
	margin: 0 auto;
	text-align: center;
}
thead tr th:nth-child(6) {
	width: 10%;
	margin: 0 auto;
	text-align: center;
}
tr td {
	display: table-cell;
}
th,td {
	border: 1px solid #dddddd;
	padding: 8px;
	word-break: break-all;
	text-align: center;
	font-size: 13px;
}
thead th {
	color: #8493a5;
	font-size: 15px;
}
tr {
	font-size: 14px;
}
tbody tr:nth-child(even) {background: #f9f9f9}
/* End Table */

/* Totals */
.title {
	margin-left: 3px;
}
.title_charge {
	margin-bottom: 8px;
}
.totals {
	display: grid;
	grid-template-columns: repeat(3,1fr);
} 
.totals .item_total {
	background: #FFF;
	border: 1px solid #E4E4E4;
	border-radius: 5px;
	margin: 8px 3px;
}
.totals .item_total .total {
	text-align: center;
	border: none;
	font-size: 14px !important;
	font-weight: bold;
	line-height: 1.65857;
	color: #3a3a3aee;
}
.totals .item_total .title{
	text-align:center;
	margin-top: 5px;
	font-size: 13px;
}
.totals .item_total .total{
	text-align:center;
	margin-top: 5px;
	font-size: 18px;
}
.totals .item_total .see_details  {
	background-color: #e6e6e6;
	color: #3a3a3aee;
	padding:4px 0px;
	cursor: pointer;
	text-align:center;
	font-size: 13px;
	border:none;
}
.situation_green {
	color: #008000 !important;
}
.situation_red {
	color: #ff0000 !important;
}
.fa-eye {
	color: #0000ff !important;
}
.fa-eye-disabled {
	color: #ff0000 !important;
}
/* End Totals */

/* Button */
.btn_signature {
	height: 30px;
	border: 1px solid #008000;
	background-color: #d8ffd3;
	color: #008000;
	padding: 3px 7px;
	margin-top:6px;
	margin-left:6px;
	text-align: center;
	text-decoration: none;
	text-transform: uppercase;
	display: inline-block;
	font-size: 14px;
	margin-top:14px;
	cursor: pointer;
}
.btn_signature_canceled {
	height: 30px;
	border: 1px solid #ff0000;
	background-color: #ffdbdb;
	color: #ff0000;
	padding: 3px 7px;
	margin-top:6px;
	margin-left:6px;
	text-align: center;
	text-decoration: none;
	text-transform: uppercase;
	display: inline-block;
	font-size: 14px;
	margin-top:14px;
	cursor: pointer;
}

/* End Button */

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
</style>
<script setup>
import { ref, onMounted } from 'vue';
import CreateSignature from './partials/CreateSignature.vue';
import { useStore } from 'vuex';
import { show_msgbox, empty, formatDate, formatMoneyBRL, confirm_alert } from '@/helpers/Helpers';

/* Ref or Reactive */
const store = useStore();
const titleModal = ref('');

/* Ref or Reactive */
const statusModalCreateSignature    = ref(false);
const optionsStates                 = ref([]);

const access_date_end               = ref(store.state.auth.me.date_end);
const access_ind_mod_order_tracking = ref(store.state.auth.me.ind_mod_order_tracking);
const access_ind_mod_hotel          = ref(store.state.auth.me.ind_mod_hotel);
const access_situation              = ref(store.state.auth.me.access);

const signature_frequency                   = ref("");
const signature_ind_mod_hotel               = ref("");
const signature_ind_mod_order_tracking      = ref("");
const signature_next_due_date               = ref("");
const signature_payment                     = ref("");
const signature_situation                   = ref("");
const signature_total                       = ref("");
const charges                               = ref([]);

/* Events */
onMounted(async () => {
	store.commit('CHANGE_LOADING', true);
	
	// States
	try {
		const response = await store.dispatch('generateOptionsStates');
		
		response.forEach(item => {
			optionsStates.value.push(item);
		});
	}
	catch(error)
	{
		if(error.status != 404)
		{
			return show_msgbox(error.data.message, 'warning', 'warning');
		}
	}

	// Signature
	getSignature();

	// Charge
	getCharge();

	store.commit('CHANGE_LOADING', false);
});

/* Functions */
const showModalCreateSignature = () => {
	statusModalCreateSignature.value = true;
	titleModal.value = 'Adicionar Assinatura';
}

const getSignature = async () => {
	try {
		const response = await store.dispatch('getFinancial');
		
		signature_frequency.value              = response.frequency;
		signature_ind_mod_hotel.value          = response.ind_mod_hotel;
		signature_ind_mod_order_tracking.value = response.frequency;
		signature_next_due_date.value          = response.frequency;
		signature_payment.value   = response.payment;
		signature_situation.value = response.situation;
		signature_total.value     =  response.total;
		access_date_end.value               =  response.access_date_end;
		access_ind_mod_order_tracking.value =  response.access_ind_mod_order_tracking;
		access_ind_mod_hotel.value          =  response.access_ind_mod_hotel;
		access_situation.value              =  response.access_situation;
		
	}
	catch(error)
	{
		if(error.status != 404)
		{
			return show_msgbox(error.data.message, 'warning');
		}
	}
}

const getCharge = async () => {
	try {
		const response = await store.dispatch('getChargeFinancial');
		charges.value = response;
	}
	catch(error)
	{
		if(error.status != 404)
		{
			return show_msgbox(error.data.message, 'warning');
		}
	}
}

const hideModalCreateSignature = () => {
	statusModalCreateSignature.value = false;
}

const btnCanceled = async () => {
	if(await confirm_alert('Tem certeza que deseja cancelar a assinatura. Confirma?') == true)
	{
		store.commit('CHANGE_LOADING', true);
		
		try {
			const response = await store.dispatch('canceledSignatureFinancial');
			getSignature();
			hideModalCreateSignature();
			return show_msgbox(response, 'success');
		}
		catch(error)
		{
			if(error.status != 404)
			{
				return show_msgbox(error.message, 'warning');
			}
		}
		finally {
			store.commit('CHANGE_LOADING', false);
		}
	}
}
</script>