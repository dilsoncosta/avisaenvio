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
							<th><b>Cliente:</b></th>
							<td>{{ data.client ? convertWordToUppercase(`${data.client.name} ${data.client.surname}`) : '' }}</td>
						</tr>
						<tr>
							<th><b>TÍtulo:</b></th>
							<td >{{ data.title }}</td>
						</tr>
						<tr>
							<th><b>Url:</b></th>
							<td >{{ data.url }}</td>
						</tr>
						<tr>
							<th><b>Porta:</b></th>
							<td >{{ data.port }}</td>
						</tr>
						<tr>
							<th><b>WhatsApp:</b></th>
							<td v-if="data.whatsapp">{{ formatPhoneNumber(data.whatsapp)}}</td>
							<td v-else class="not_defined">Não definido</td>
						</tr>
						<tr>
							<th><b>Situação:</b></th>
							<td v-if="data.situation == 1"><b class="active">Ativo</b></td>
							<td v-else><b class="inactive">Inativo</b></td>
						</tr>
						<tr>
							<th><b>Criado em:</b></th>
							<td>{{ formatDateTime(data.created_at) }}</td>
						</tr>
						<tr v-if="data.created_at != data.updated_at">
							<th><b>Atualizado em:</b></th>
							<td>{{ formatDateTime(data.updated_at) }}</td>
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
.active {
	color:#008000;
}
.inactive {
	color:#ff0000;
}
.not_defined {
	color: #ff0000 !important;
}
</style>
<script setup>
import { formatDateTime, convertWordToUppercase, formatPhoneNumber } from '@/helpers/Helpers';

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