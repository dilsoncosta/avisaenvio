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
							<th><b>Destinatário:</b></th>
							<td class="td_format">{{ data.destination }}</td>
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
							<th><b>Situação:</b></th>
							<td v-if="data.situation == 1" class="td_format"><b class="pendent">Pendente</b></td>
							<td v-else-if="data.situation == 2" class="td_format"><b class="in_progress">Em Andamento</b></td>
							<td v-else><b class="concluded">Concluido</b></td>
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
									<table>
										<tbody v-if="data.tracking_events && data.tracking_events.length > 0">
											<tr v-for="(item_event, index_event) in data.tracking_events" :key="index_annotation">
												<th colspan="2" class="event-info">
													<br/>
													<table class="table_event">
														<tbody>
															<tr>
																<th><b>Data</b>:</th>
																<td class="event-title">{{ formatDateTime(item_event.date_event) }}</td>
															</tr>
															<tr>
																<th><b>Status</b>:</th>
																<td class="event-title">{{ item_event.msg_event }}</td>
															</tr>
															<tr>
																<th><b>Template</b>:</th>
																<td class="event-title">{{ item_event.template && item_event.template.title }}</td>
															</tr>
															<tr>
																<th><b>Situação</b>:</th>
																<td class="communication-situation">
																	<p v-if="item_event.status_send == 1" class="status-send">Enviado</p>
																	<p v-else-if="item_event.status_send == 0" class="status-scheduled">Pendente</p>
																	<p v-else class="td-situation">Falha: <br><i class="fas fa-exclamation-triangle"></i> {{ item_event.failure_reason }}</p>
																</td>
															</tr>
														</tbody>
													</table>
												</th>
											</tr>
										</tbody>
										<tbody v-else>
											<tr>
												<th colspan="2" class="center-text">Nenhuma evento encontrado.</th>
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
.td_format {
	font-size: 10.5px !important;
}
.pendent {
	color:#000000;
}
.in_progress {
	color:#FFA500;
}
.concluded {
	color:#008000;
}
.title_event {
	margin-top: 5px;
	text-align: center;
}
.table_event {
	text-align: lef !important;
	vertical-align: top;
	padding: 2px;
	color: black;
	white-space: nowrap;
	width: 12%;
	font-size: 12px;
}
</style>
<script setup>
import { formatDateTime, formatPhoneNumber } from '@/helpers/Helpers';
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
</script>