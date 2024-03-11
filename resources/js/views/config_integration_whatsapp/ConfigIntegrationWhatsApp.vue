<template>
	<main>
		<div class="page-content">
			<div class="table">
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><a>Configuração</a></li>
							<li class="active">Integração WhatsApp</li>
						</ol>
					</div>
					<div></div>
				</div>
			</div>
			<br/>
			<div class="container">
				<div class="form_group">
					<label><span class="input_required">*</span> Seleciona a Integração WhatsApp:</label>
					<Multiselect
						v-model="integration_whatsapps.value"
						v-bind="integration_whatsapps"
						@select="handleSearchIntegration()">
					</Multiselect>
				</div>
				<br/>
				<table class="info_table_integration_whatsapp" v-if="showOrHideContainerItg">
					<tbody>
						<tr>
							<th>
								Número WhatsApp:
							</th>
							<td>
								<table>
									<tbody>
										<tr>
											<td>
												<input type="text" v-model="whatsapp" :disabled="statusIntegration == 1">
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<th v-if="statusIntegration == 1">
								Desativar Integração:
							</th>
							<th v-else>
								Ativar Integração:
							</th>
							<td>
								<table>
									<tbody>
										<tr>
											<td class="panel_bt_onoff_td">
												<div id="panel_bt_onoff">
													<a id="btn_off" style="" role="button" v-if="statusIntegration == 3" @click.prevent="activeIntegrationWhatsApp()">
														<b><i class="fas fa-toggle-off"></i></b>
													</a>
													<a id="btn_on" role="button" v-else @click.prevent="disabledIntegrationWhatsApp()">
														<b><i class="fas fa-toggle-on"></i></b>
													</a>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr class="container_config" v-if="statusIntegration == 1">
							<th>Configuração:</th>
							<td class="panel_config">
								<div>
									<b><i class="fas fa-check"></i> Conectado</b>
								</div>
							</td>
						</tr>
						<tr class="container_config" v-if="statusIntegration == 0">
							<th>Configuração:</th>
							<td class="panel_config">
								<div><b><i class="fas fa-cog fa-2x fa-spin"></i> Iniciando WhatsApp Web. Aguarde...</b></div>
							</td>
						</tr>
						<tr class="container_config" v-if="statusIntegration == 3">
							<th id="device">Aparelho:</th>
							<td>
								<p>
									<b id="disconnected"><i class="fas fa-times"></i> Disconectado</b>
								</p>
							</td>
						</tr>
						<tr class="container_config" v-if="statusIntegration == 1">
							<th id="device">Aparelho:</th>
							<td>
								<p>
									<b id="connected"><i class="fas fa-check"></i> Conectado</b>
								</p>
								<p>
									<b id="authenticated"><i class="fas fa-check"></i> Autenticado</b>
								</p>
							</td>
						</tr>
						<tr class="container_config" v-if="statusIntegration == 2">
							<th id="speak_reading">Faça a Leitura:</th>
							<td>
								<img :src="qrcode">
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
	</main>
</template>
<style scoped>
main {
	width: 100%;
}
a {
	text-decoration:none;
}
ul li {
	list-style:none;
	font-size:14px;
}
a {
	text-decoration:none;
}
.page-content {
	margin: 30px;
	background-color: #fff;
	border-radius: 0.25rem;
	padding:20px;
}
.container {
	margin-top:10px;
}
/* Table Header */
.table {
	width: 100%;
}
.table .header {
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
/* Fim Table Header */
 
/* Inputs */
.form_container .form_group {
	padding:5px 0px;
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
.input_required {
	color:#ff0000;
}
.multiselect {
	margin-top:5px;
}
/* End Inputs */

/* Content */
.info_table_integration_whatsapp th {
	width: 120px;
	text-align: right;
	vertical-align: middle;
	padding: 7px;
	border-spacing: 10px;
	color:#000000;
	white-space: nowrap;
	font-size: 16px;
}
.info_table_integration_whatsapp td {
	
	text-align: left;
	vertical-align: middle;
	border-spacing: 10px;
	border-bottom: 1px solid #ddd;
	color:#000080;
	font-size: 14px;
	border: none;
}
.container_config .panel_config div {
	font-size:16px;
	color:#008000;
}
.container_config .panel_config div b i{
	font-size:19px;
}
.container_config .panel_config div span {
	background-color:#337ab7;
	display: inline;
	padding: 0.2em 0.6em 0.3em;
	font-size: 75%;
	font-weight: 700;
	line-height: 1;
	color: #fff;
	text-align: center;
	white-space: nowrap;
	vertical-align: baseline;
	border-radius: 0.25em;cursor:pointer;
}
#speak_reading {
	vertical-align: top;
}
.container_config #connected, .container_config #authenticated {
	font-size:16px;
	color:#008000;
}
.container_config #disconnected {
	font-size:16px;
	color:#ff0000;
}
.container_config #authenticated i{
	font-size:16px;
	color:#008000;
	vertical-align:top;
}
#container_config #device {
	vertical-align: top;
}
#panel_bt_onoff #btn_off {
	font-size: 32px;
	color:#555555;
	cursor:pointer
}
#panel_bt_onoff #btn_on {
	font-size: 32px;
	color:#008000;
	cursor:pointer;
}
#wait_processed i{
	font-size:19px;
	color:#000;
}
img{
	margin-top:10px;
}
/* End Content */
</style>
<script setup>
import { onMounted, ref} from 'vue';
import { useStore } from 'vuex';
import { show_msgbox, empty, validatedPhone } from '@/helpers/Helpers';
import io from 'socket.io-client';

/* Ref or Reactive */
const store             = useStore();
const qrcode            = ref('');
const statusIntegration = ref(3);
const integration_whatsapps = ref({
	mode: 'single',
	value: null,
	closeOnSelect: true,
	options: [],
	searchable: true,
	createOption: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado",
});
const showOrHideContainerItg = ref(false);
const whatsapp = ref('');
var socket = null;

onMounted( async () => {
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await store.dispatch('genereateOptionsIntegrationWhatsApp');
		
		response.forEach(item => {
			integration_whatsapps.value.options.push({ value: item.id, label: item.title });
		});
	}
	catch(error)
	{
		if(error.status != 404)
		{
			return show_msgbox(error.data.message, 'warning');
		}
	}
	
	store.commit('CHANGE_LOADING', false);
});

/* Functions */
const activeIntegrationWhatsApp = async () => {
	
	if(empty(whatsapp.value))
	{
		return show_msgbox('Digite o NÚMERO DO WHATSAPP', 'warning');
	}
	if(validatedPhone(whatsapp.value))
	{
		return show_msgbox('Entre com um NÚMERO DO WHATSAPP válido!<br/><br/>Formato:<br/><br/><b style="color:#0000ff;">[Código do País]</b><b style="color:#fd9109;">[Código de Área]</b><b style="color:#000000;">[Número do Celular]</b><br/><br/>Ex.: <b style="color:#0000ff;">55</b><b style="color:#fd9109;">31</b><b style="color:#000000;">911112222</b>.', 'warning');
	}
	
	statusIntegration.value = 0;

	store.commit('CHANGE_LOADING', true);
	
	try
	{
		const response = await store.dispatch('activeConfigIntegrationWhatsApp', {
			integration_whatsapp_id: integration_whatsapps.value.value,
			whatsapp: whatsapp.value
		});
		
		if(response.createNow == "1")
		{
			integration_whatsapps.value.value = '';
			showOrHideContainerItg.value = false;
			return show_msgbox('Selecione a integração WhatsApp novamente. Essa mensagem será exibida somente na primeira conexão.', 'warning');
		}
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const disabledIntegrationWhatsApp = async () => {
	store.commit('CHANGE_LOADING', true);

	try
	{
		await store.dispatch('disabledConfigIntegrationWhatsApp', {
			integration_whatsapp_id: integration_whatsapps.value.value,
			whatsapp: whatsapp.value
		});
		statusIntegration.value = 3;
	}
	catch(error) {
		return show_msgbox(error.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const handleSearchIntegration = async () => {
	store.commit('CHANGE_LOADING', true);
	
	try
	{
		const response = await store.dispatch('getStatusIntegrationWhatsAppConfigIntegrationWhatsApp', {
			integration_whatsapp_id: integration_whatsapps.value.value,
			whatsapp: whatsapp.value
		});
		
		closeSocketConnection();
		
		openSocketConnection(response.data.url, response.data.session_name);
		
		showOrHideContainerItg.value = true;
		whatsapp.value = response.data.whatsapp;

		if(response.status_integration == 'disconnected')
		{
			statusIntegration.value = 3;
			return;
		}
		statusIntegration.value = 1;
	}
	catch(error) {
		showOrHideContainerItg.value = false;
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const openSocketConnection = (url, sessionName) => {
	socket = io(url + '/' + sessionName, {
		transports: ['websocket']
	});
	
	socket.on('connect', () => {
		console.log('Conexão com WebSocket efetuada com sucesso!');
	});

	socket.on('qrcode.updated', (data) => {
		statusIntegration.value = 2;
		qrcode.value = data.data.qrcode.base64;
	});

	socket.on('connection.update', (data) => {
		if (data.data.state == 'close') {
			statusIntegration.value = 3;
		}
		if (data.data.state == 'open') {
			statusIntegration.value = 1;
		}
	});
};

const closeSocketConnection = () => {
	if (socket)
	{
		socket.disconnect();
		socket = null;
	}
};
</script>