<template>
	<main>
		<div class="page-content">
			<div class="table">
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><a>Configuração</a></li>
							<li class="active">Integração Nuvem Shop</li>
						</ol>
					</div>
					<div></div>
				</div>
			</div>
			<br/>
			<div class="container">
				<div class="instructions">
					<ol>
						<li>Clique em instalar aplicativo;</li>
						<li>Após concluir a instalação do aplicativo Avisa APP na sua loja Nuvem Shop, você será redirecionado para a página onde deverá existir o ID do Aplicativo e Código. Copie e cole no campo respectivo abaixo e, por fim, ative a integração.</li>
					</ol>
				</div>
				<table class="info_table_integration_best_shipping">
					<tbody>
						<tr>
							<th class="td_token">
								Aplicativo:
							</th>
							<td>
								<table>
									<tbody>
										<tr>
											<td>
												<a :href="intallerApp" target="_black" class="btn_installer_app">Instalar</a>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<th class="td_token">
								ID do Aplicativo:
							</th>
							<td>
								<table>
									<tbody>
										<tr>
											<td>
												<input type="text" v-model="idApp" :disabled="situation == 1">
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<th class="td_token">
								Código:
							</th>
							<td>
								<table>
									<tbody>
										<tr>
											<td>
												<input type="text" v-model="code" :disabled="situation == 1">
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<th v-if="situation == 1">
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
													<a id="btn_off" style="" role="button" v-if="situation == 0" @click.prevent="activeIntegrationWhatsApp()">
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
.info_table_integration_best_shipping th {
	width: 120px;
	text-align: right;
	vertical-align: middle;
	padding: 7px;
	border-spacing: 10px;
	color:#000000;
	white-space: nowrap;
	font-size: 16px;
}
.info_table_integration_best_shipping td {
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
img{
	margin-top:10px;
}
.td_token {
	vertical-align: top !important;
}
.instructions{
	margin: 4px 18px 18px;
	font-size: 14px;
}
.btn_installer_app {
	color: #0000ff;
}
/* End Content */

</style>
<script setup>
import { onMounted, ref} from 'vue';
import { useStore } from 'vuex';
import { show_msgbox, empty } from '@/helpers/Helpers';

/* Ref or Reactive */
const store             = useStore();
const intallerApp       = ref("https://www.tiendanube.com/apps/11443/authorize?state=csrf-code");
const statusIntegration = ref(3);
const idApp             = ref('');
const code              = ref('');
const uuid              = ref('');
const situation         = ref('');

onMounted( async () => {
	store.commit('CHANGE_LOADING', true);

	try {
		const response = await store.dispatch('getStatusIntegrationNuvemShopConfigIntegrationNuvemShop');
		idApp.value = response.data.idApp;
		code.value = response.data.code;
		uuid.value = response.data.uuid;
		situation.value = response.data.situation;
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
	
	if(empty(idApp.value))
	{
		return show_msgbox('O Campo ID DO APLICATIVO é obrigatório!', 'warning');
	}
	if(empty(code.value))
	{
		return show_msgbox('O Campo CÓDIGO é obrigatório!', 'warning');
	}
	
	statusIntegration.value = 0;

	store.commit('CHANGE_LOADING', true);
	
	try
	{
		const response = await store.dispatch('activeConfigIntegrationNuvemShop', {
			idApp: idApp.value,
			code: code.value,
			situation: 1,
			uuid: uuid.value
		});
		situation.value = 1;
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
		await store.dispatch('disabledConfigIntegrationNuvemShop', {
			idApp: idApp.value,
			code: code.value,
			situation: 0,
			uuid: uuid.value
		});
		code.value = "";
		situation.value = 0;
	}
	catch(error) {
		return show_msgbox(error.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}
</script>