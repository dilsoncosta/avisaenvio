<template>
	<main>
		<div class="page-content">
			<div :class="user.category == 'FR' || user.category == 'FRCLB'  ? {'container_1' :'container_1'} : {'container' :'container'}" >
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><router-link to="/"><i class="fas fa-home-lg"></i></router-link></li>
							<li class="active">Dashboard</li>
						</ol>
					</div>
					<div></div>
				</div>
				<br/>
				<div class="content">
					<div v-if="($can('show-portal')|| $can('show-portal')) && $can('show-module-portal')">
						<p class="title"><b>Portal / Franqueado:</b></p>
						<div class="total">{{ portal_total_franchise }}</div>
						<router-link :to="{name : 'portal.franchise'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="($can('show-page-informative') || $can('show-portal') && $can('show-module-portal'))">
						<p class="title"><b>Portal / Informativo:</b></p>
						<div class="total">{{ portal_total_informative }}</div>
						<router-link :to="{name : 'portal.informative'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="($can('show-page-checklist') || $can('show-portal')) && $can('show-module-portal')">
						<p class="title"><b>Portal / Checklist:</b></p>
						<div class="total">{{ portal_total_checklist }}</div>
						<router-link :to="{name : 'portal.checklist'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="($can('show-page-training') || $can('show-portal')) && $can('show-module-portal')">
						<p class="title"><b>Portal / Treinamento:</b></p>
						<div class="total">{{ portal_total_training }}</div>
						<router-link :to="{name : 'portal.training'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="($can('show-page-marketing') || $can('show-portal')) && $can('show-module-portal')">
						<p class="title"><b>Portal / Marketing:</b></p>
						<div class="total">{{ portal_total_marketing }}</div>
						<router-link :to="{name : 'portal.material'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="($can('show-page-manual') || $can('show-portal')) && $can('show-module-portal')">
						<p class="title"><b>Portal / Manual:</b></p>
						<div class="total">{{ portal_total_manual }}</div>
						<router-link :to="{name : 'portal.material'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="$can('show-crm') && $can('show-module-crm')">
						<p class="title"><b>Crm / Contato:</b></p>
						<div class="total">{{ crm_total_contact }}</div>
						<router-link :to="{name : 'crm.contact'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="$can('show-crm') && $can('show-module-crm') && user.category == 'CL'">
						<p class="title"><b>Crm / Vendedores:</b></p>
						<div class="total">{{ crm_total_seller }}</div>
						<router-link :to="{name : 'crm.seller'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="$can('show-crm') && $can('show-module-crm')">
						<p class="title"><b>Crm / Mensagem:</b></p>
						<div class="total">{{ crm_total_message }}</div>
						<router-link :to="{name : 'crm.message'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="$can('show-crm') && $can('show-module-crm')">
						<p class="title"><b>Crm / Tarefa:</b></p>
						<div class="total">{{ crm_total_task }}</div>
						<router-link :to="{name : 'crm.task'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="$can('show-crm') && $can('show-module-crm')">
						<p class="title"><b>Crm / Evento:</b></p>
						<div class="total">{{ crm_total_event }}</div>
						<router-link :to="{name : 'crm.event'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="user.category == 'CL' || user.category == 'CLB'">
						<p class="title"><b>Configuração / Colaborador:</b></p>
						<div class="total">{{ config_total_collaborator }}</div>
						<router-link :to="{name : 'collaborator'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
					</div>
					<div v-if="user.category == 'CL' || user.category == 'CLB'">
						<p class="title"><b>Configuração / Acesso:</b></p>
						<div class="total access" v-if="access == 'A'">Ativo</div>
						<div class="total access inactive" v-if="access == 'I'">Inativo</div>
						<div class="total access suspended" v-if="access == 'S'">Suspenso</div>
						<div class="total access expiration" v-if="access == 'E'">Expirado</div>
						<div class="total access canceled" v-if="access == 'C'">Cancelado</div>
						<a href="#"><p class="see_details"><b>+ Detalhes</b></p></a>
					</div>
				</div>
				<div class="box-data">
					<div class="box-data-internal" v-if="$can('show-page-informative')">
						<h5>Últimos Informativos</h5>
						<ul v-if="portal_last_informative.length > 0">
							<li v-for="(item, index) in portal_last_informative" :key="index">
								<div>
									<p>{{ convertToUpperCase(item.name) }}</p>
								</div>
							</li>
						</ul>
						<p v-else><i>Nenhum informativo cadastrado!</i></p>
					</div>
					<div class="box-data-internal" v-if="$can('show-page-training')">
						<h5>Últimos Treinamentos</h5>
						<ul v-if="portal_last_training.length > 0">
							<li v-for="(item, index) in portal_last_training" :key="index">
								<div>
									<p>{{ convertToUpperCase(item.name) }}</p>
									<router-link :to="{name: 'portal.page.training.preview', params: {uuid: item.uuid}}" style="color:#0000ff;cursor:pointer;"><i class="fas fa-eye"></i></router-link>
								</div>
							</li>
						</ul>
						<p v-else><i>Nenhum treinamento cadastrado!</i></p>
					</div>
				</div>
			</div>
		</div>
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
	padding:20px;
}
.container .header {
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
.container_1 {
	max-width:1400px;
	margin:0 auto;
}
.content {
	display: grid;
	grid-template-columns: repeat(5, 1fr);
	gap: 10px;
	margin-top: 13px;
}
.content h2 {
	font-size:16px;
}
.content div{
	background: #FFF;
	border: 1px solid #E4E4E4;
	border-radius: 5px;
}
.content .total{
	text-align:center;
	border:none;
	font-size: 38px;
	font-weight: bold;
	line-height: 1.65857;
	color: #3a3a3aee;
}
.content .title{
	text-align:center;
	margin-top: 5px;
	font-size: 12px;
}
.content a {
	text-decoration:none;
}
.content .see_details {
	background-color: #e6e6e6;
	color: #3a3a3aee;
	padding:4px 0px;
	cursor: pointer;
	text-align:center;
	font-size: 13px;
	border:none;
}
.fa-home-lg {
	color:#fff;
}
.inactive, .suspended, .expiration, .canceled {
	color: #ff0000 !important;
}
.box-data {
	margin-top:10px;
	padding:12px 0px;
	border-radius: 3px;
	display:flex;
	gap:15px;
}
.box-data .box-data-internal {
	flex:1;
}
.box-data .box-data-internal p{
	font-size:11px;
}
.box-data h5 {
	font-size:16px;
}
.box-data ul {
	list-style:none;
	font-size:14px;
	margin-top:10px;
}
.box-data ul li {
	padding:5px 0px;
	border-bottom:1px solid #ccc;
}
.box-data ul li div {
	display:flex;
	justify-content:space-between;
}
.box-data  .box-data-internal p i {
	font-size:13px;
}
</style>
<script setup>
import { onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import { show_msgbox, convertToUpperCase } from '@/helpers/Helpers';

/* Ref or Reactive */
const store              = useStore();
const portal_total_informative  = ref(0);
const portal_total_checklist    = ref(0);
const portal_total_training     = ref(0);
const portal_total_marketing    = ref(0);
const portal_total_manual       = ref(0);
const portal_total_franchise    = ref(0);

const portal_last_informative   = ref([]);
const portal_last_training      = ref([]);

const crm_total_event    = ref(0);
const crm_total_task     = ref(0);
const crm_total_seller   = ref(0);
const crm_total_contact  = ref(0);
const crm_total_message  = ref(0);

const config_total_collaborator = ref(0);

const access             = store.state.auth.me.access;
const user               = store.state.auth.me;

/* Events */
onMounted( async () => {
	store.commit('CHANGE_LOADING', true);

	try {
		const response = await store.dispatch('getDatasDashbboard', {
			flow: 0,
			segmentation : store.state.auth.me.segmentations_frachise
		});
		
		portal_total_informative.value = response.portal_total_informative;
		portal_total_checklist.value   = response.portal_total_checklist;
		portal_total_training.value    = response.portal_total_training;
		portal_total_marketing.value   = response.portal_total_marketing;
		portal_total_manual.value      = response.portal_total_manual;
		portal_total_franchise.value   = response.portal_total_franchise;
		portal_last_training.value     = response.portal_last_training.data;
		portal_last_informative.value  = response.portal_last_informative.data;

		crm_total_event.value    = response.crm_total_event;
		crm_total_task.value     = response.crm_total_task;
		crm_total_seller.value   = response.crm_total_seller;
		crm_total_contact.value  = response.crm_total_contact;
		crm_total_message.value  = response.crm_total_message;
		
		config_total_collaborator.value = response.config_total_collaborator;
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	
	store.commit('CHANGE_LOADING', false);
});
</script>