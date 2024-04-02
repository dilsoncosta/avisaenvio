<template>
	<main>
		<div class="page-content">
			<div class="container" >
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
					<div v-if="user.category == 'CL' || user.category == 'CLB'">
						<p class="title"><b>Pedido:</b></p>
						<div class="total">{{ order }}</div>
						<router-link :to="{name : 'order'}" ><p class="see_details"><b>+ Detalhes</b></p></router-link>
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
	grid-template-columns: repeat(3, 1fr);
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
import { show_msgbox } from '@/helpers/Helpers';

/* Ref or Reactive */
const store    = useStore();
const order = ref(0);
const config_total_collaborator = ref(0);
const access   = store.state.auth.me.access;
const user     = store.state.auth.me;

/* Events */
onMounted( async () => {
	store.commit('CHANGE_LOADING', true);

	try {
		const response = await store.dispatch('getDatasDashbboard');

		order.value = response.order;
		config_total_collaborator.value = response.config_total_collaborator;
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	
	store.commit('CHANGE_LOADING', false);
});
</script>