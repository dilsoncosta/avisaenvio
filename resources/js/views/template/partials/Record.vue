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
						<tr v-if="ind_mod_order_tracking == 1">
							<th><b>Tipo:</b></th>
							<td v-if="data.type == 1" class="td_format">Pedido Postado</td>
							<td v-else-if="data.type == 2" class="td_format">Em Trânsito</td>
							<td v-else-if="data.type == 3" class="td_format">Saiu Entrega</td>
							<td v-else class="td_format">Entregue</td>
						</tr>
						<tr>
							<th><b>Titulo:</b></th>
							<td class="td_format">{{ data.title }}</td>
						</tr>
						<tr>
							<th><b>Mensagem:</b></th>
							<td class="td_format" v-html="data.message ? data.message.split('\r\n').join('<br>') : ''"></td>
						</tr>
						<tr>
							<th><b>Arquivo #1:</b></th>
							<td v-if="data.file_1"><a :href="`${path_storage}/${data.file_1}`" target="_blank" style="color:#0000ff;cursor:pointer;"><i class="fas fa-eye"></i></a></td>
							<td v-else><i class="fas fa-eye fa-eye-red"></i></td>
						</tr>
						<tr>
							<th><b>Arquivo #2:</b></th>
							<td v-if="data.file_2"><a :href="`${path_storage}/${data.file_2}`" target="_blank" style="color:#0000ff;cursor:pointer;"><i class="fas fa-eye"></i></a></td>
							<td v-else><i class="fas fa-eye fa-eye-red"></i></td>
						</tr>
						<tr>
							<th><b>Arquivo #3:</b></th>
							<td v-if="data.file_3"><a :href="`${path_storage}/${data.file_3}`" target="_blank" style="color:#0000ff;cursor:pointer;"><i class="fas fa-eye"></i></a></td>
							<td v-else><i class="fas fa-eye fa-eye-red"></i></td>
						</tr>
						<tr>
							<th><b>Situação:</b></th>
							<td v-if="data.situation == 1" class="td_format"><b class="active">Ativo</b></td>
							<td v-else class="td_format"><b class="inactive">Inativo</b></td>
						</tr>
						<tr>
							<th><b>Criado em:</b></th>
							<td class="td_format">{{ formatDateTime(data.created_at) }}</td>
						</tr>
						<tr v-if="data.created_at != data.updated_at">
							<th><b>Atualizado em:</b></th>
							<td class="td_format">{{ formatDateTime(data.updated_at) }}</td>
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
.td_format {
	font-size: 10.5px !important;
	padding-top: 17px;
}
.fa-eye-red {
	color:#ff0000;
	cursor:not-allowed;
}
.send_email {
	color: rgb(255, 255, 255); 
	background-color: rgb(0, 135, 255); 
	font-size: 11px; 
	padding: 1px 4px 1px 4px; 
	border-radius: 2px; 
	cursor: pointer;
}
.send_whatsapp {
	color: rgb(255, 255, 255); 
	background-color: rgb(0, 135, 255); 
	font-size: 11px; 
	padding: 1px 4px 1px 4px; 
	border-radius: 2px; 
	cursor: pointer;
}
.td_format {
	font-size: 11px !important;
}
</style>
<script setup>
import { formatDateTime, show_msgbox, confirm_alert } from '@/helpers/Helpers';
import { defineProps, defineEmits } from 'vue';
import { useStore } from 'vuex';

/* Props */
const store = useStore();
const props = defineProps({
	titleModal: {
		Type: String,
		required: true
	},
	data: {
		Type: Object,
		required: true
	}
});

const ind_mod_order_tracking = store.state.auth.me.ind_mod_order_tracking;

/* Ref or Reactive */
const path_storage = import.meta.env.VITE_APP_PATH_STORAGE

/* Emits */
const emit = defineEmits(['hideModalRecord']);

/* Functions */
const hideModal = () => {
	emit('hideModalRecord', false);
}
</script>