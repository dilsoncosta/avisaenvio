<template>
	<main>
		<div class="page-content" v-on:scroll.prevent>
			<div class="table">
				<div class="header">
					<div>
						<ol class="page-content-title">
							<li><a>Configuração</a></li>
							<li class="active">Conta</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="form_container">
					<div class="form_group"  v-if="$can('show-module-portal')">
						<label>Upload do Certificado:</label>
						<div class="uploadFile">
							<input type="file" style="display:none;" id="fileCertificate">
							<div class="init-upload" @click="handleUploadCertificate()"><i class="fas fa-upload"></i>&nbsp;Enviar Arquivo(s)</div>
							<div v-if="fileCertificateItem.length > 0">
								<div class="previewUploadFile" v-for="(item, index) in fileCertificateItem" :key="index">
									<div>{{ item.filename_certificate }}</div>
									<div>
										<button v-if="item.file_certificate" class="view_uploadFile"><a :href="`${path_storage}/${ item.file_certificate }`" target="_blank"><i class="fas fa-eye"></i></a></button>
										<button @click.prevent="removeFileCertificate()"><i class="fal fa-times"></i></button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form_group" v-if="$can('show-module-portal')">
						<label>Logo do Portal:</label>
						<div class="uploadFile">
							<input type="file" style="display:none;" id="fileLogoPortal">
							<div class="init-upload" @click="handleUploadLogoPortal()"><i class="fas fa-upload"></i>&nbsp;Enviar Arquivo(s)</div>
							<div v-if="fileLogoPortalItem.length > 0">
								<div class="previewUploadFile" v-for="(item, index) in fileLogoPortalItem" :key="index">
									<div>{{ item.filename_logo_portal }}</div>
									<div>
										<button v-if="item.file_logo_portal" class="view_uploadFile"><a :href="`${path_storage}/${ item.file_logo_portal }`" target="_blank"><i class="fas fa-eye"></i></a></button>
										<button @click.prevent="removeFileLogoPortal()"><i class="fal fa-times"></i></button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form_group">
						<label>Cor Geral:</label>
						<input type="color" name="cor_general" v-model="color_general">
					</div>
				</div>
				<div class="button_area">
					<button @click.prevent="handleSave">Salvar</button>
				</div>
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
.form_container {
	display: grid;
	grid-template-columns: repeat(1, 1fr);
	gap: 10px;
	margin-top: 18px;
}
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
input[type="color"] {
  padding:0px;
	height: 35px;
}
.input_required {
	color:#ff0000;
}
.multiselect {
	margin-top:5px;
}
.uploadFile {
	border:1px solid #ccc;
	padding:10px;
	margin-top:5px;
}
.uploadFile .previewUploadFile {
	display: flex;
	justify-content: space-between;
	align-content: center;
	cursor:pointer;
	margin-top: 20px;
	font-size: 13.5px;
	color: #0000ff;
}
.uploadFile .previewUploadFile button {
	cursor: pointer;
	border: none;
	background-color: #ef9900;
	color: #fff;
}
.uploadFile .init-upload {
	font-size: 13px;
	cursor: pointer;
}
.previewUploadFile button {
	margin-left:5px;
}
.previewUploadFile .view_uploadFile{
	color:#fff;
	background-color:#0000ff !important;
}
.previewUploadFile .view_uploadFile a{
	text-decoration:none;
	color:#fff;
}
/* End Inputs */

/* Buttons */
.button_area {
	display: flex;
	justify-content: flex-end;
	margin-top: 12px;
}
.button_area button {
	display: flex;
	justify-content: center;
	border-radius: 0px;
	color: #000000;
	background-color: #f8d039;
	border: 1px solid #ef9900;
	box-shadow: none !important;
	cursor: pointer;
	padding: 10px;
	width: 100px;
}
.button_area button:hover {
	background-color: #f8d039 !important;
	border-color: #ef9900 !important;
	color:#000000 !important;
	opacity: 0.9;
}
/* End Buttons */
</style>
<script setup>
import { onMounted, ref, toRaw } from 'vue';
import { useStore } from 'vuex';
import { show_msgbox, empty } from '@/helpers/Helpers';

/* Ref or Reactive */
const store     = useStore();
const fileCertificateList  = ref([]);
const fileLogoPortalList   = ref([]);
const fileCertificateItem  = ref([]);
const fileLogoPortalItem   = ref([]);
const file_certificate     = ref('');
const filename_certificate = ref('');
const color_general        = ref('');
const path_storage         = import.meta.env.VITE_APP_PATH_STORAGE

/* Events */
onMounted( async () => {
	try {
		const response = await store.dispatch('getAccount');
		fileCertificateList.value = [];
		if(!empty(response.file_certificate)){ fileCertificateItem.value.push(response); } else { fileCertificateItem.value = []; }
		fileLogoPortalList.value = [];
		if(!empty(response.file_logo_portal)){ fileLogoPortalItem.value.push(response); } else { fileLogoPortalItem.value = []; }
		if(!empty(response.color_general)){ color_general.value = response.color_general } else { color_general.value = '#2957a7'; }
	}
	catch(error)
	{
		if(error.status != 404)
		{
			return show_msgbox(error.data.message, 'warning', 'warning');
		}
	}
});

/* Functions */
const handleUploadCertificate = () => {
	let files = document.getElementById('fileCertificate');
	files.click();
	
	files.addEventListener('change', (e) => {
		if(files.files.length <= 0){ return; }
		
		fileCertificateList.value = [];
		fileCertificateItem.value = [];
		
		fileCertificateList.value.push(e.target.files[0]);
		fileCertificateItem.value.push({filename_certificate: files.files[0].name});
		
		files.value = "";
	});
}

const handleUploadLogoPortal = () => {
	let files = document.getElementById('fileLogoPortal');
	files.click();
	
	files.addEventListener('change', (e) => {
		if(files.files.length <= 0){ return; }
		
		fileLogoPortalList.value = [];
		fileLogoPortalItem.value = [];
		
		fileLogoPortalList.value.push(e.target.files[0]);
		fileLogoPortalItem.value.push({filename_logo_portal: files.files[0].name});
		
		files.value = "";
	});
}

const removeFileCertificate = async () => {
	fileCertificateList.value = [];
	fileCertificateItem.value = [];
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await store.dispatch('destroyCertificateAccount', {});
		
		return show_msgbox(response, 'success');
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const removeFileLogoPortal = async () => {
	fileLogoPortalList.value = [];
	fileLogoPortalItem.value = [];
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await store.dispatch('destroyLogoPortalAccount', {});
		
		return show_msgbox(response, 'success');
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}

const handleSave = async () => {
	
	let fileCertificate = toRaw(fileCertificateList.value);
	let fileLogoPortal = toRaw(fileLogoPortalList.value);

	if(fileCertificate.length > 0)
	{
		let file_allowed = ['png'];
		let file_size_defined = 262144000;
		let file_size_total = 0;
		let file_ext = fileCertificate[0].name.split('.').pop();
		
		if(typeof file_allowed.find(function (ext) { return file_ext == ext; }) == 'undefined')
		{
			return show_msgbox('Ops! CERTIFICADO inválido. Extensão permitida: png.', 'warning');
		}
		
		file_size_total = fileCertificate[0].size;
		
		if(file_size_total > file_size_defined)
		{
			return show_msgbox('O tamanho máximo permitido para upload é até 250MB.', 'warning');
		}
	}
	
	if(fileLogoPortal.length > 0)
	{
		let file_allowed = ['png', 'jpg', 'jpeg'];
		let file_size_defined = 262144000;
		let file_size_total = 0;
		let file_ext = fileLogoPortal[0].name.split('.').pop();
		
		if(typeof file_allowed.find(function (ext) { return file_ext == ext; }) == 'undefined')
		{
			return show_msgbox('Ops! LOGO DO PORTAL inválido. Extensão permitida: png, jpg e jpeg.', 'warning');
		}
		
		file_size_total = fileLogoPortal[0].size;
		
		if(file_size_total > file_size_defined)
		{
			return show_msgbox('O tamanho máximo permitido para upload é até 250MB.', 'warning');
		}
	}
	
	fileCertificateItem.value = [];
	fileLogoPortalItem.value = [];
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await store.dispatch('updateAccount', {
			certificate: fileCertificate[0],
			logo_portal: fileLogoPortal[0],
			color_general: color_general.value
		});
		
		try {
			const response = await store.dispatch('getAccount');
			response.file_certificate != '' ? fileCertificateItem.value.push(response) : [];
			response.file_logo_portal != '' ? fileLogoPortalItem.value.push(response) : [];
			response.color_general != '' ? color_general.value = response.color_general : color_general.value = '#2957a7';
			
			setTimeout(() => {
				window.location.reload();
			}, 2000);
		}
		catch(error){
			return show_msgbox(error.data.message, 'warning', 'warning');
		}
		
		return show_msgbox(response, 'success');
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}
</script>