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
							<td class="td_format">{{ `${name} ${ surname}`}}</td>
						</tr>
						<tr>
							<th><b>Username:</b></th>
							<td class="td_format">{{ username }}</td>
						</tr>
						<tr>
							<th><b>Email:</b></th>
							<td class="td_format">{{ email }}</td>
						</tr>
						<tr>
							<th><b>Celular:</b></th>
							<td class="td_format">{{ phone }}</td>
						</tr>
						<tr>
							<th><b>WhatsApp:</b></th>
							<td class="td_format">{{ whatsapp }}</td>
						</tr>
						<tr>
							<th><b>Situação:</b></th>
							<td v-if="situation == 1" class="td_format"><b class="active">Ativo</b></td>
							<td v-else class="td_format"><b class="inactive">Inativo</b></td>
						</tr>
						<tr>
							<th><b>Criado em:</b></th>
							<td class="td_format">{{ created_at }}</td>
						</tr>
						<tr v-if="created_at != updated_at">
							<th><b>Atualizado em:</b></th>
							<td class="td_format">{{ updated_at }}</td>
						</tr>
					</tbody>
				</table>
				<b id="title_permission">Permissões</b>
				<table class="acesso-table">
					<tbody>
						<tr v-for="(item, index) in resources_general" :key="index">
							<th>{{ item.name }}</th>
							<td>&nbsp;&nbsp;<i class="fas fa-arrow-right fa-lg" style="color:#000;"></i></td>
							<div class="list_permissions">
								<div v-for="(item_permission, index_permission) in item.permissions" :key="index_permission">
									<td class="checkbox_td" v-if="item_permission.name.includes('access') && permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox">Acessar</span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('access') && !permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox"><s>Acessar</s></span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('view') && permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox">Visualizar</span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('view') && !permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox"><s>Visualizar</s></span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('edit') && permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox">Editar</span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('edit') && !permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox"><s>Editar</s></span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('delete') && permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox">Excluir</span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('delete') && !permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox"><s>Excluir</s></span>
											</label>
										</div>
									</td>
								</div>
							</div>
						</tr>
						<!-- End Module Portal -->
						<!-- Module Config -->
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
									<td class="checkbox_td" v-if="item_permission.name.includes('access') && permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox">Acessar</span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('access') && !permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox"><s>Acessar</s></span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('view') && permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox">Visualizar</span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('view') && !permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox"><s>Visualizar</s></span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('edit') && permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox">Editar</span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('edit') && !permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox"><s>Editar</s></span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('delete') && permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox">Excluir</span>
											</label>
										</div>
									</td>
									<td class="checkbox_td" v-if="item_permission.name.includes('delete') && !permissionIds.includes(item_permission.id)">
										<div class="alinhar-cheks">
											<label class="checkbox_style">
												<span class="span_checkbox"><s>Excluir</s></span>
											</label>
										</div>
									</td>
								</div>
							</div>
						</tr>
						<!-- End Module Config -->
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
	width: 550px;
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
	font-size: 12px;
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
#title_permission {
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
}
.acesso-table th {
	width:180px;
	text-align:right;
}
.list_permissions {
	display:flex;
}
.span_checkbox s {
	color:#ff0000;
}
.title_permission {
	text-align:center;
	font-size:16px;
	margin:0 auto;
	display:flex;
	justify-content:center;
	align-items:center;
}
.td_format {
	font-size: 10.5px !important;
}
</style>
<script setup>
import { watch, toRaw, ref } from 'vue';
import { formatPhoneNumber, formatDateTime } from '@/helpers/Helpers';

/* Ref or Reactive */
const name      = ref('');
const surname   = ref('');
const email     = ref('');
const phone     = ref('');
const whatsapp  = ref('');
const username  = ref('');
const situation = ref('');
const collaborator_type = ref('0');
const created_at = ref('');
const updated_at = ref('');
const permissionIds  = ref([]);

/* Props */
const props = defineProps({
	titleModal: {
		Type: String,
		required: true
	},
	data: {
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

/* Emits */
const emit = defineEmits(['hideModalRecord']);

/* Events */
watch(() => props.data, (value) => {
	let formData    = toRaw(value);
	
	name.value      = formData.user.name;
	surname.value   = formData.user.surname;
	email.value     = formData.user.email;
	phone.value     = formatPhoneNumber(formData.user.phone);
	whatsapp.value  = formatPhoneNumber(formData.user.whatsapp);
	username.value  = formData.user.username;
	collaborator_type.value = formData.collaborator_type;
	situation.value = formData.user.situation;
	permissionIds.value = [];
	formData.permissions.forEach(item => {
		permissionIds.value.push(item.id);
	});
	created_at.value = formatDateTime(formData.created_at);
	updated_at.value = formatDateTime(formData.updated_at);
});

/* Functions */
const hideModal = () => {
	emit('hideModalRecord', false);
}
</script>