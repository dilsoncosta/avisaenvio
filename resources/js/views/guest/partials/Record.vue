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
							<th><b>Nome e Sobrenome:</b></th>
							<td class="td_format">{{ data.name_surname }}</td>
						</tr>
						<tr>
							<th><b>WhatsApp:</b></th>
							<td class="td_format">{{ formatPhoneNumber(data.whatsapp) }}</td>
						</tr>
						<tr>
							<th><b>Data do Check-In:</b></th>
							<td class="td_format">{{ formatDate(data.date_checkin) }}</td>
						</tr>
						<tr>
							<th><b>Data do Check-Out:</b></th>
							<td class="td_format">{{ formatDate(data.date_checkout) }}</td>
						</tr>
						<tr>
							<th><b>Situação:</b></th>
							<td class="td_format" v-if="data.situation == 1"><b class="active">Ativo</b></td>
							<td class="td_format" v-else><b class="inactive">Inativo</b></td>
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
								<p class="event-header"><b><i class="fas fa-user-edit"></i> Envios</b></p>
							</th>
						</tr>
						<tr>
							<th colspan="2">
								<div>
									<table class="table_event">
										<tbody>
											<tr class="table_event_tr">
												<th colspan="2" class="event-info">
													<br/>
													<h4 class="title_send">Mensagem de Boas-Vindas</h4>
													<table class="table_event_internal">
														<tbody>
															<tr>
																<th><b>Envio</b>:</th>
																<td class="td_format" v-if=" data.ind_msg_1 == 1">{{ data.ind_msg_1+' Dia Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_1 == 2">{{ data.ind_msg_1+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_1 == 3">{{ data.ind_msg_1+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_1 == 4">{{ data.ind_msg_1+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_1 == 5">{{ data.ind_msg_1+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_1 == 6">{{ data.ind_msg_1+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_1 == 7">{{ data.ind_msg_1+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_1 == 8">{{ data.ind_msg_1+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_1 == 9">{{ data.ind_msg_1+' Mês Antes do Check-in' }}</td>
																<td class="td_format" v-else>Desativado</td>
															</tr>
															<tr>
																<th><b>Template</b>:</th>
																<td class="td_format" v-if="data.msg_1_template_id">{{ data.msg_1_template_id && data.msg_1_template_id.title }}</td>
																<td class="td_format" v-else>---</td>
															</tr>
															<tr>
																<th><b>Situação</b>:</th>
																<td>
																	<p v-if="data.msg_1_status_send == 1" class="status-send td_format">Enviado</p>
																	<p v-else-if="data.msg_1_status_send == 0" class="status-scheduled td_format">Pendente</p>
																	<p v-else class="status-failed td_format"><i class="fas fa-exclamation-triangle"></i> {{ data.msg_1_msg_send }}</p>
																</td>
															</tr>
														</tbody>
													</table>
												</th>
											</tr>
											<tr class="table_event_tr">
												<th colspan="2" class="event-info">
													<br/>
													<h4 class="title_send">Mensagem de Informações do Check-in</h4>
													<table class="table_event_internal">
														<tbody>
															<tr>
																<th><b>Envio</b>:</th>
																<td class="td_format" v-if=" data.ind_msg_2 == 1">{{ data.ind_msg_2+' Dia Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_2 == 2">{{ data.ind_msg_2+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_2 == 3">{{ data.ind_msg_2+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_2 == 4">{{ data.ind_msg_2+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_2 == 5">{{ data.ind_msg_2+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_2 == 6">{{ data.ind_msg_2+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_2 == 7">{{ data.ind_msg_2+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_2 == 8">{{ data.ind_msg_2+' Dias Antes do Check-in' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_2 == 9">{{ data.ind_msg_2+' Mês Antes do Check-in' }}</td>
																<td class="td_format" v-else>Desativado</td>
															</tr>
															<tr>
																<th><b>Template</b>:</th>
																<td class="td_format" v-if="data.msg_2_template_id">{{ data.msg_2_template_id && data.msg_2_template_id.title }}</td>
																<td class="td_format" v-else>---</td>
															</tr>
															<tr>
																<th><b>Situação</b>:</th>
																<td>
																	<p v-if="data.msg_2_status_send == 1" class="status-send td_format">Enviado</p>
																	<p v-else-if="data.msg_2_status_send == 0" class="status-scheduled td_format">Pendente</p>
																	<p v-else class="status-failed td_format"><i class="fas fa-exclamation-triangle"></i> {{ data.msg_2_msg_send }}</p>
																</td>
															</tr>
														</tbody>
													</table>
												</th>
											</tr>
											<tr class="table_event_tr">
												<th colspan="2" class="event-info">
													<br/>
													<h4 class="title_send">Mensagem dia do Check-in</h4>
													<table class="table_event_internal">
														<tbody>
															<tr>
																<th><b>Envio</b>:</th>
																<td class="td_format" v-if=" data.ind_msg_3 == 1">Dia do Check-in</td>
																<td class="td_format" v-else>Desativado</td>
															</tr>
															<tr>
																<th><b>Template</b>:</th>
																<td class="td_format" v-if="data.msg_3_template_id">{{ data.msg_3_template_id && data.msg_3_template_id.title }}</td>
																<td class="td_format" v-else>---</td>
															</tr>
															<tr>
																<th><b>Situação</b>:</th>
																<td>
																	<p v-if="data.msg_3_status_send == 1" class="status-send td_format">Enviado</p>
																	<p v-else-if="data.msg_3_status_send == 0" class="status-scheduled td_format">Pendente</p>
																	<p v-else class="status-failed td_format"><i class="fas fa-exclamation-triangle"></i> {{ data.msg_3_msg_send }}</p>
																</td>
															</tr>
														</tbody>
													</table>
												</th>
											</tr>
											<tr class="table_event_tr">
												<th colspan="2" class="event-info">
													<br/>
													<h4 class="title_send">Mensagem de Agradecimento do Checkout</h4>
													<table class="table_event_internal">
														<tbody>
															<tr>
																<th><b>Envio</b>:</th>
																<td class="td_format" v-if=" data.ind_msg_4 == 1">{{ data.ind_msg_4+' Dia Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_4 == 2">{{ data.ind_msg_4+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_4 == 3">{{ data.ind_msg_4+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_4 == 4">{{ data.ind_msg_4+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_4 == 5">{{ data.ind_msg_4+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_4 == 6">{{ data.ind_msg_4+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_4 == 7">{{ data.ind_msg_4+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_4 == 8">{{ data.ind_msg_4+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_4 == 9">{{ data.ind_msg_4+' Mês Após do Check-Out' }}</td>
																<td class="td_format" v-else>Desativado</td>
															</tr>
															<tr>
																<th><b>Template</b>:</th>
																<td class="td_format" v-if="data.msg_4_template_id">{{ data.msg_4_template_id && data.msg_4_template_id.title }}</td>
																<td class="td_format" v-else>---</td>
															</tr>
															<tr>
																<th><b>Situação</b>:</th>
																<td>
																	<p v-if="data.msg_4_status_send == 1" class="status-send td_format">Enviado</p>
																	<p v-else-if="data.msg_4_status_send == 0" class="status-scheduled td_format">Pendente</p>
																	<p v-else class="status-failed td_format"><i class="fas fa-exclamation-triangle"></i> {{ data.msg_4_msg_send }}</p>
																</td>
															</tr>
														</tbody>
													</table>
												</th>
											</tr>
											<tr class="table_event_tr">
												<th colspan="2" class="event-info">
													<br/>
													<h4 class="title_send">Mensagem Pesquisa de Sastifação</h4>
													<table class="table_event_internal">
														<tbody>
															<tr>
																<th><b>Envio</b>:</th>
																<td class="td_format" v-if=" data.ind_msg_5 == 1">{{ data.ind_msg_5+' Dia Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_5 == 2">{{ data.ind_msg_5+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_5 == 3">{{ data.ind_msg_5+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_5 == 4">{{ data.ind_msg_5+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_5 == 5">{{ data.ind_msg_5+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_5 == 6">{{ data.ind_msg_5+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_5 == 7">{{ data.ind_msg_5+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_5 == 8">{{ data.ind_msg_5+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_5 == 9">{{ data.ind_msg_5+' Mês Após do Check-Out' }}</td>
																<td class="td_format" v-else>Desativado</td>
															</tr>
															<tr>
																<th><b>Template</b>:</th>
																<td class="td_format" v-if="data.msg_5_template_id">{{ data.msg_5_template_id && data.msg_5_template_id.title }}</td>
																<td class="td_format" v-else>---</td>
															</tr>
															<tr>
																<th><b>Situação</b>:</th>
																<td>
																	<p v-if="data.msg_5_status_send == 1" class="status-send td_format">Enviado</p>
																	<p v-else-if="data.msg_5_status_send == 0" class="status-scheduled td_format">Pendente</p>
																	<p v-else class="status-failed td_format"><i class="fas fa-exclamation-triangle"></i> {{ data.msg_5_msg_send }}</p>
																</td>
															</tr>
														</tbody>
													</table>
												</th>
											</tr>
											<tr class="table_event_tr">
												<th colspan="2" class="event-info">
													<br/>
													<h4 class="title_send">Mensagem de Oferta:</h4>
													<table class="table_event_internal">
														<tbody>
															<tr>
																<th><b>Envio</b>:</th>
																<td class="td_format" v-if=" data.ind_msg_6 == 1">{{ data.ind_msg_6+' Dia Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_6 == 2">{{ data.ind_msg_6+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_6 == 3">{{ data.ind_msg_6+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_6 == 4">{{ data.ind_msg_6+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_6 == 5">{{ data.ind_msg_6+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_6 == 6">{{ data.ind_msg_6+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_6 == 7">{{ data.ind_msg_6+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_6 == 8">{{ data.ind_msg_6+' Dias Após do Check-Out' }}</td>
																<td class="td_format" v-else-if=" data.ind_msg_6 == 9">{{ data.ind_msg_6+' Mês Após do Check-Out' }}</td>
																<td class="td_format" v-else>Desativado</td>
															</tr>
															<tr>
																<th><b>Template</b>:</th>
																<td class="td_format" v-if="data.msg_6_template_id">{{ data.msg_6_template_id && data.msg_6_template_id.title }}</td>
																<td class="td_format" v-else>---</td>
															</tr>
															<tr>
																<th><b>Situação</b>:</th>
																<td>
																	<p v-if="data.msg_6_status_send == 1" class="status-send td_format">Enviado</p>
																	<p v-else-if="data.msg_6_status_send == 0" class="status-scheduled td_format">Pendente</p>
																	<p v-else class="status-failed td_format"><i class="fas fa-exclamation-triangle"></i> {{ data.msg_6_msg_send }}</p>
																</td>
															</tr>
														</tbody>
													</table>
												</th>
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
.inactive {
	color: #ff0000;;
}
.active {
	color: #008000;
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
.title_send {
	text-align: center;
}
</style>
<script setup>
import { formatDateTime, formatPhoneNumber, formatDate } from '@/helpers/Helpers';
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