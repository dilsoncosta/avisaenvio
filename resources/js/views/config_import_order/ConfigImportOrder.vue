<template>
	<main>
		<div class="page-content" v-on:scroll.prevent>
			<div class="table">
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><a>Configuração</a></li>
							<li class="active">Importação</li>
						</ol>
					</div>
					<div></div>
				</div>
			</div>
			<br/>
			<div class="container">
				<div class="instructions">
					<ol>
						<li>Baixe a planilha template para importação - <a :href="path_import_tpl+'/import_order.xlsx'">Baixar Planilha</a>; </li>
							<li>
								Preencha a planilha com os dados: 
								<ul>
									<li>Obs. 1: Campo "Destinatário" é obrigatório;</li>
									<li>Obs. 2: Campo "WhatsApp (DDD + DDI + NÚMERO)" é obrigatório;</li>
									<li>Obs. 3: Campo "Código Pedido" é obrigatório;</li>
									<li>Obs. 4: Campo "Objeto" é obrigatório;</li>
								</ul>
							</li>
							<li>Indique a Integração;</li>
							<li>Indique o arquivo .XLSX que será enviado para processamento;</li>
							<li>Clique em Importar;</li>
						</ol>
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Integração:</label>
					<select name="type" v-model="type_integration">
						<option></option>
						<option value="0">Correios</option>
						<option value="1">Melhor Envio</option>
					</select>
				</div>
				<br/>
				<div class="form_group">
					<label><span class="input_required">*</span> Arquivo:</label>
					<div class="uploadFiles">
						<input type="file" style="display:none;" id="files">
						<div class="init-upload" @click="handleUploadFile"><i class="fas fa-upload"></i> Enviar Arquivo</div>
						<div class="previewFiles" v-for="(item, index) in fileItems" :key="index">
							<div>{{ item.name }}</div>
							<div><button @click.prevent="removeFile(index, item)"><i class="fal fa-times"></i></button></div>
						</div>
					</div>
				</div>
				<br/>
				<button class="btn_import" @click.prevent="submit">Importar</button>
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
.uploadFiles {
	border:1px solid #ccc;
	padding:10px;
	margin-top:5px;
}
.uploadFiles .previewFiles {
	display: flex;
	justify-content: space-between;
	align-content: center;
	cursor:pointer;
	margin-top: 20px;
	font-size: 13.5px;
	color: #0000ff;
}
.uploadFiles .previewFiles button {
	cursor: pointer;
	border: none;
	background-color: #ef9900;
	color: #fff;
}
.uploadFiles .init-upload {
	font-size: 13px;
	cursor: pointer;
}
.multiselect {
	margin-top:5px;
}
/* End Inputs */

/* Button */
.btn_import {
	display: flex;
	justify-content: center;
	border-radius: 0px;
	color: #000000;
	background-color: #f8d039;
	border: 1px solid #ef9900;
	box-shadow: none !important;
	cursor: pointer;
	padding: 10px;
	font-size: 17px;
	width: 100%;
}
.btn_import:hover {
	background-color: #f8d039 !important;
	border-color: #ef9900 !important;
	color:#000000 !important;
	opacity: 0.9;
}
/* End Button */

.instructions{
	margin: 4px 18px 18px;
	font-size: 14px;
}
</style>
<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';
import { show_msgbox, empty } from '@/helpers/Helpers';

/* Ref or Reactive */
const path_import_tpl = import.meta.env.VITE_APP_PATH_IMPORT_TPL;
const store = useStore();
const fileList  = ref([]);
const fileItems = ref([]);
const type_integration = ref('');

/* Functions */
const handleUploadFile = () => {
	let files = document.getElementById('files');
	files.click();
	
	files.addEventListener('change', (e) => {
		if(files.files.length <= 0){ return; }
		
		fileList.value = [];
		fileItems.value = [];
		
		for(let i = 0;i<e.target.files.length;i++)
		{
			fileList.value.push(e.target.files[i])
		}
		
		for(var i =0; i<files.files.length; i++){
			fileItems.value.push({ name: files.files[i].name });
		}
		files.value = ""; 
	});
}

const removeFile = async (index, item) => {
	const fileListArr = Array.from(fileList.value);
	fileListArr.splice(index, 1);
	fileList.value = fileListArr;
	fileItems.value.splice(index, 1);
}

const submit = async () => {
	if(empty(type_integration.value))
	{
		return show_msgbox('O Campo INTEGRAÇÃO é obrigatório!', 'warning');
	}
	if(fileItems.value.length == 0)
	{
		return show_msgbox('O Campo ARQUIVO é obrigatório!', 'warning');
	}
	if(fileList.value.length > 0)
	{
		let file_allowed = ['xlsx'];
		let file_size_defined = 262144000;
		let file_size_total = 0;
		for(let i = 0;i<fileList.value.length;i++)
		{
			let file_ext = fileList.value[i].name.split('.').pop();
			
			if(typeof file_allowed.find(function (ext) { return file_ext == ext; }) == 'undefined')
			{
				return show_msgbox('Ops! ARQUIVO inválida. Extensões permitidas: xlsx.', 'warning');
			}
			
			file_size_total += fileList.value[i].size;
		}
		if(file_size_total > file_size_defined)
		{
			return show_msgbox('O tamanho máximo permitido para upload é até 250MB.', 'warning');
		}
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		let response = '';
		let data = {
			type_integration: type_integration.value,
			file: fileList.value[0]
		};
		
		response = await store.dispatch('importConfigImportOrder', data);
		clearInputs();
		return show_msgbox(response, 'success');
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const clearInputs = async () => {
	type_integration.value = '';
	fileList.value = [];
	fileItems.value = [];
}
</script>