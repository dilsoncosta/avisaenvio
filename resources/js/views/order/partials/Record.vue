<template>
	<div>
		<button class="modal__close" @click.prevent="hideModal">
			<i class="fal fa-times"></i>
		</button>
		<span class="modal__title">{{ titleModal }}</span>
		<div class="modal__content">
			<div class="record_container">
				<table class="record-table">
					<tbody>
						<tr>
							<th><b>Código Pedido:</b></th>
							<td class="td_format">{{ data.code }}</td>
						</tr>
						<tr>
							<th><b>Destinatário:</b></th>
							<td class="td_format">{{ data.destination }}</td>
						</tr>
						<tr>
							<th><b>CPF/CNPJ:</b></th>
							<td class="td_format">{{ formatarCPFCNPJ(data.cpf_cnpj) }}</td>
						</tr>
						<tr>
							<th><b>WhatsApp:</b></th>
							<td class="td_format">{{ formatPhoneNumber(data.whatsapp) }}</td>
						</tr>
						<tr>
							<th><b>Objeto:</b></th>
							<td class="td_format">{{ data.object }}</td>
						</tr>
						<tr>
							<th><b>Última Situação:</b></th>
							<td v-if="data.last_situation == 0" class="td_format"><b class="pending">Pendente</b></td>
							<td v-else-if="data.last_situation == 1" class="td_format"><b class="post_request">Pedido postado</b></td>
							<td v-else-if="data.last_situation == 2" class="td_format"><b class="in_transit">Em trânsito</b></td>
							<td v-else-if="data.last_situation == 3" class="td_format"><b class="out_for_delivery">Saiu entrega</b></td>
							<td v-else-if="data.last_situation == 4" class="td_format"><b class="delivered">Entregue</b></td>
							<td v-else class="td_format"><b class="issue">Com problemas</b></td>
						</tr>
						<tr>
							<th><b>Integração:</b></th>
							<td v-if="data.integration == 0" class="td_format">Melhor Envio</td>
							<td v-else-if="data.integration == 1" class="td_format">Cadastro Manual</td>
							<td v-else class="td_format">Importação Planilha</td>
						</tr>
						
						<tr>
							<th><b>Transportadora:</b></th>
							<td v-if="data.shipping_company == 0" class="td_format">Correios</td>
							<td v-else-if="data.shipping_company == 1" class="td_format">Jadlog</td>
							<td v-else-if="data.shipping_company == 2" class="td_format">J&T Express</td>
							<td v-else-if="data.shipping_company == 3" class="td_format">Latam Cargo</td>
							<td v-else class="td_format">Loggi</td>
						</tr>
						<tr>
							<th><b>Criado em:</b></th>
							<td class="td_format">{{ formatDateTime(data.created_at) }}</td>
						</tr>
						<tr v-if="data.created_at != data.updated_at">
							<th><b>Atualizado em:</b></th>
							<td class="td_format">{{ formatDateTime(data.updated_at) }}</td>
						</tr>
						<tr>
							<th colspan="2" class="center-heading">
								<br/>
								<p class="event-header"><b><i class="fas fa-user-edit"></i> Eventos: {{ data.tracking_events && data.tracking_events.length }}</b></p>
							</th>
						</tr>
						<tr>
							<th colspan="2">
								<div>
									<table class="table_event">
										<tbody v-if="data.order_events && data.order_events.length > 0">
											<tr v-for="(item_event, index_event) in data.order_events" :key="index_annotation" class="table_event_tr">
												<th colspan="2" class="event-info">
													<br/>
													<table class="table_event_internal">
														<tbody>
															<tr>
																<th><b>Data</b>:</th>
																<td class="td_format">{{ formatDateTime(item_event.date_event) }}</td>
															</tr>
															<tr>
																<th><b>Status</b>:</th>
																<td class="td_format">
																	<div class="td_format_event_description" v-html="formatarDescription(item_event.msg_event)" ></div>
																</td>
															</tr>
															<tr>
																<th><b>Template</b>:</th>
																<td class="td_format">{{ item_event.template && item_event.template.title }}</td>
															</tr>
															<tr>
																<th><b>Situação</b>:</th>
																<td>
																	<p v-if="item_event.status_send == 1" class="status-send td_format">Enviado</p>
																	<p v-else-if="item_event.status_send == 0" class="status-scheduled td_format">Pendente</p>
																	<p v-else class="status-failed td_format"><i class="fas fa-exclamation-triangle"></i> {{ item_event.msg_send }}</p>
																</td>
															</tr>
														</tbody>
													</table>
												</th>
											</tr>
										</tbody>
										<tbody v-else>
											<tr>
												<th colspan="2" class="center-text">Nenhum evento encontrado.</th>
											</tr>
										</tbody>
									</table>
								</div>
							</th>
							<br/><br/>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<style scoped>
.modal__title {
	margin: 0 2rem 0.5rem 0;
	font-size: 17px;
}
.modal__content {
	flex-grow: 1;
	overflow-y: auto;
	overflow-x:hidden;
	flex-wrap: wrap;
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
.record_container {
	display: grid;
	grid-template-columns: repeat(1, 1fr);
	gap: 10px;
	margin-top: 13px;
}
.record_container .form_group {
	padding:5px 0px;
}
.record-table {
	font-size: 13px;
}
.record-table th {
	text-align: right;
	vertical-align: top;
	padding: 2px;
	color: black;
	white-space: nowrap;
	width:50%;
	font-size: 12px;
}
.record-table td {
	text-align: left;
	vertical-align: top;
	padding: 3px;
	color: #0000ff;
	width:50%;
	font-size: 12px;
}
.item_event {
	padding:8px 0px;
}
.event-header {
  font-size: 130%;
  color: #383838;
  text-align: center;
}
.event-info {
  text-align: left;
  white-space: normal;
  padding: 8px 0px;
}
.event-text {
  text-align: justify;
}
.event-description {
  padding-left: 0px !important;
}
.active {
	color:#008000;
}
.inactive {
	color:#ff0000;
}
.center-text {
	text-align: center !important;
}
.td_format {
	font-size: 10.5px !important;
}
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
.title_event {
	margin-top: 5px;
	text-align: center;
}
.table_event {
	width: 100%;
}
.table_event_internal {
	text-align: lef !important;
	vertical-align: top;
	padding: 2px;
	color: black;
	white-space: nowrap;
	width: 12%;
	font-size: 12px;
}
.td_format_event_description {
	width:420px;
	max-width: 420px;
	word-break: break-word;
	white-space: normal;
}
.table_event tbody .table_event_tr {
	background: #eee;
}
.status-failed {
	color: #ff0000;
}
</style>
<script setup>
import { formatDateTime, formatPhoneNumber, formatarCPFCNPJ } from '@/helpers/Helpers';
import { defineProps, defineEmits } from 'vue';

/* Props */
defineProps({
	titleModal: {
		Type: String,
		required: true
	},
	data: {
		Type: Object,
		required: true
	}
});

/* Emits */
const emit = defineEmits(['hideModalRecord']);

/* Functions */
const hideModal = () => {
	emit('hideModalRecord', false);
}

const formatarDescription = (string) => {
	return string.replace("\n", "<br>");
}
</script>