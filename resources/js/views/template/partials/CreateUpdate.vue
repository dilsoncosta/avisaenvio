<template>
	<div>
		<button class="modal__close" @click.prevent="hideModal">
			<i class="fal fa-times"></i>
		</button>
		<span class="modal__title">{{ titleModal }}</span>
		<div class="modal__content">
			<span class="text_inputs_required">Campos com <span class="input_required">*</span> são obrigatórios</span>
			<div class="form_container">
				<div class="form_group">
					<label><span class="input_required">*</span> Tipo:</label>
					<select name="type" v-model="type">
						<option value="1">Objeto Postado</option>
						<option value="2">Objeto Encaminhado</option>
						<option value="3">Objeto Saiu para Entrega</option>
						<option value="4">Objeto Entregue</option>
					</select>
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Titulo:</label>
					<input type="text" name="title" maxlength="255" v-model="title" @input="TITLEConvertWordToUppercase()">
				</div>
				<div class="form_group">
					<div class="textarea-container">
						<label>Mensagem:</label>
						<img src="../../../../../public/images/rosto.png" @click.prevent="statusImojis = !statusImojis">
						<div class="emoji_picker" v-if="statusImojis">
							<div class="picker_container">
								<div class="category" v-for="category in categories" :key="`category_${category}`">
									<span>{{ category }}</span>
									<div class="emojis_container">
										<button @click="handleEmojiClick($event, emoji)" v-for="(emoji, index) in category_emojis(category)" :key="`emoji_${index}`">
											{{ emoji }}
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<textarea id="custom-textarea" class="custom-textarea form-control" rows="8" v-model="message"></textarea>
					<b class="title_tags">Tags:</b>
					<a @click.prevent="handleEmojiClick($event, '[NOME]')" class="tags" role="button"><b>[NOME]</b></a>
					&nbsp;&nbsp; 
					<a @click.prevent="handleEmojiClick($event, '[WHATSAPP]')" class="tags" role="button"><b>[WHATSAPP]</b></a>
					&nbsp;&nbsp; 
					<a @click.prevent="handleEmojiClick($event, '[DATA]')" class="tags" role="button"><b>[DATA EVENTO]</b></a>
					&nbsp;&nbsp; 
					<a @click.prevent="handleEmojiClick($event, '[STATUS]')" class="tags" role="button"><b>[STATUS]</b></a>
					&nbsp;&nbsp; 
					<a @click.prevent="handleEmojiClick($event, '[OBJETO]')" class="tags" role="button"><b>[OBJETO]</b></a>
					&nbsp;&nbsp;
				</div>
				<div class="form_group">
					<label><span class="input_required">*</span> Situação:</label>
					<select name="situation" v-model="situation">
						<option value="1">Ativo</option>
						<option value="0">Inativo</option>
					</select>
				</div>
				<div class="form_group">
					<label>Arquivo #1:</label>
					<div class="uploadFiles">
						<input type="file" style="display:none;" id="file_1">
						<div class="init-upload" @click="handleUploadFile_1"><i class="fas fa-upload"></i> Enviar Arquivo(s)</div>
						<div class="previewFiles" v-for="(item, index) in fileItems_1" :key="index">
							<div>{{ item.name }}</div>
							<div><button @click.prevent="removeFile_1(index, item, 0)"><i class="fal fa-times"></i></button></div>
						</div>
					</div>
				</div>
				<div class="form_group">
					<label>Arquivo #2:</label>
					<div class="uploadFiles">
						<input type="file" style="display:none;" id="file_2">
						<div class="init-upload" @click="handleUploadFile_2"><i class="fas fa-upload"></i> Enviar Arquivo(s)</div>
						<div class="previewFiles" v-for="(item, index) in fileItems_2" :key="index">
							<div>{{ item.name }}</div>
							<div><button @click.prevent="removeFile_2(index, item, 1)"><i class="fal fa-times"></i></button></div>
						</div>
					</div>
				</div>
				<div class="form_group">
					<label>Arquivo #3:</label>
					<div class="uploadFiles">
						<input type="file" style="display:none;" id="file_3">
						<div class="init-upload" @click="handleUploadFile_3"><i class="fas fa-upload"></i> Enviar Arquivo(s)</div>
						<div class="previewFiles" v-for="(item, index) in fileItems_3" :key="index">
							<div>{{ item.name }}</div>
							<div><button @click.prevent="removeFile_3(index, item, 2)"><i class="fal fa-times"></i></button></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal__action">
			<button class="btn_modal__action" @click.prevent="submit" v-if="update">Salvar</button>
			<button class="btn_modal__action" @click.prevent="submit" v-else>Registrar</button>
		</div>
	</div>
</template>

<style scoped>
/* Modal */
.modal__title {
	margin: 0 2rem 0.5rem 0;
	font-size: 17px;
}
.modal__content {
	flex-grow: 1;
	overflow-y: auto;
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
.modal__action {
	display: flex;
	justify-content: center;
	align-items: center;
	flex-shrink: 0;
	padding: 1rem 0 0;
}
/* End Modal */

/* Inputs */
.form_container {
	display: grid;
	grid-template-columns: repeat(1, 1fr);
	gap: 10px;
	margin-top: 13px;
}
.form_container .form_group {
	padding:4px 0px;
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
.text_inputs_required {
	font-size:12px;
}
.input_required {
	color:#ff0000;
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
/* End Input */

/* Button */
.modal__action .btn_modal__action {
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
.modal__action .btn_modal__action:hover {
	background-color: #f8d039 !important;
	border-color: #ef9900 !important;
	color:#000000 !important;
	opacity: 0.9;
}
/* End Button */

/* Content */
.emoji_picker
{
	position: relative;
	display: flex;
	flex-direction: column;
	width: 20rem;
	height: 20.5rem;
	max-width: 100%;
	top:23px;
}
.emoji_picker,
.bottom_arrow
{
	box-shadow: 0 0 5px 1px rgba(0, 0, 0, .0975);
}
.emoji_picker,
.picker_container
{
	border-radius: 0.5rem;
	background: white;
	border-radius: 0.5rem;
	background: white;
	position: absolute;
	right: 0;
}
.picker_container
{
	position: relative;
	padding: 12px;
	overflow-x: hidden;
	z-index: 1;
	border: 1px solid #ccc;
}
.category
{
	display: flex;
	flex-direction: column;
	margin-bottom: 1rem;
	color: rgb(169, 169, 169);
}
.emojis_container
{
	display: flex;
	flex-wrap: wrap;
	width:18rem;
}
.category button
{
	margin: 0.5rem;
	margin-left: 0;
	background: inherit;
	border: none;
	font-size: 1.75rem;
	padding: 0;
	cursor:pointer;
}
.category button:hover
{
 background-color: #ddd;
border-radius: 10px;
}
.textarea-container {
	position: relative;
}
.custom-textarea {
	width: 100%;
	padding-right: 30px;
}
.textarea-container img {
	position: absolute;
	top: 0px;
	right: 5px;
	color: gray;
	height:20px;
	width:20px;
	cursor:pointer;
}
.tags {
	color: rgb(255, 255, 255); 
	background-color: rgb(0, 135, 255); 
	font-size: 11px; 
	padding: 1px 4px 1px 4px; 
	border-radius: 2px; 
	cursor: pointer;
}
.title_tags {
	color:#555555;
	font-size:13px;
	margin-right:5px;
}
#title_digit_tag {
	color:#ff0000;
	font-size:12px;
	margin-top:-10px;
}
.hidden {
	display:none;
}
/* End Content */

</style>
<script setup>
import { watch, ref, defineProps, defineEmits, computed, onMounted, toRaw } from 'vue';
import { useStore } from 'vuex';
import { empty, show_msgbox, convertToUpperCase } from '@/helpers/Helpers';
import { emojis } from '@/helpers/Emojis';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

/* Props */
const props = defineProps({
	titleModal: {
		Type: String,
		required: true
	},
	update: {
		Type: Boolean,
		required: true,
		default: false
	},
	form: {
		Type: Object,
		required: true
	},
});

/* Computed */
const categories = computed(() => {
	return Object.keys(emojis);
});

/* Emits */
const emit = defineEmits(['hideModalCreateUpdate', 'emoji_click']);

/* Ref or Reactive */
const store                = useStore();
const statusImojis         = ref(false);
const id                   = ref('');
const type                 = ref('1');
const type_tmp             = ref('');
const title                = ref('');
const message              = ref('');
const situation   = ref('1');
const fileList_1  = ref([]);
const fileItems_1 = ref([]);
const fileList_2  = ref([]);
const fileItems_2 = ref([]);
const fileList_3  = ref([]);
const fileItems_3 = ref([]);
const business = ref({
	mode: 'single',
	value: null,
	closeOnSelect: true,
	options: props.optionsBusiness,
	searchable: true,
	createOption: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado",
});

/* Events */
watch(() => props.form, (value) => {
	if(props.update == false)
	{
		clearInputs(0);
	}
	else
	{
		let data  = { ...value };
		
		id.value                   = data.id;
		business.value.value       = data.business ? data.business.id : '';
		type.value                 = data.type;
		type_tmp.value             = data.type;
		title.value                = data.title;
		message.value              = data.message;
		situation.value            = data.situation;
		fileItems_1.value          = [];
		data.file_1 ? fileItems_1.value.push({name: data.filename_1, path: data.file_1}) : [];
		fileItems_2.value          = [];
		data.file_2 ? fileItems_2.value.push({name: data.filename_2, path: data.file_2}) : [];
		fileItems_3.value          = [];
		data.file_3 ? fileItems_3.value.push({name: data.filename_3, path: data.file_3}) : [];
	}
});

/* Events */
onMounted(() => {
	document.addEventListener('mousedown', (event) => {
		if (!event.target.closest('.emoji_picker')) {
			statusImojis.value = false;
		}
	});
});


/* Functions */
const category_emojis = (category) => {
	return Object.values(emojis[category]);
}

const hideModal = () => {
	emit('hideModalCreateUpdate', false);
}

const submit = async () => {
	if(empty(id.value) && props.update == true)
	{
		return show_msgbox('Incapaz de processar a solicitaçãõ!', 'error');
	}
	if(empty(type.value))
	{
		return show_msgbox('O Campo TIPO é obrigatório!', 'warning');
	}
	if(empty(title.value))
	{
		return show_msgbox('O Campo TITULO é obrigatório!', 'warning');
	}
	if(type.value == 0)
	{
		if(empty(message.value) && fileItems_1.value.length == 0 && fileItems_2.value.length == 0 && fileItems_3.value.length == 0)
		{
			return show_msgbox('O Campo MENSAGEM ou ARQUIVO #1 OU ARQUIVO #2 OU ARQUVO #3 um deles deve ser preenchido!', 'warning');
		}
	}
	if(fileList_1.value.length > 0)
	{
		let file_allowed = ['jpg','jpeg','png','mp3','ogg','pdf','doc','docx','rar','zip','xlsx','mp4'];
		let file_size_defined = 262144000;
		let file_size_total = 0;
		for(let i = 0;i<fileList_1.value.length;i++)
		{
			let file_ext = fileList_1.value[i].name.split('.').pop();
			
			if(typeof file_allowed.find(function (ext) { return file_ext == ext; }) == 'undefined')
			{
					return show_msgbox('Ops! ARQUIVO #1 inválido(s). Extensões permitidas: jpg,jpeg,png,mp3,ogg,pdf,doc,docx,rar,zip,xlsx,mp4.', 'warning');
			}
			
			file_size_total += fileList_1.value[i].size;
		}
		if(file_size_total > file_size_defined)
		{
			return show_msgbox('O tamanho máximo permitido para upload é até 250MB.', 'warning');
		}
	}
	if(fileList_2.value.length > 0)
	{
		let file_allowed = ['jpg','jpeg','png','mp3','ogg','pdf','doc','docx','rar','zip','xlsx','mp4'];
		let file_size_defined = 262144000;
		let file_size_total = 0;
		for(let i = 0;i<fileList_2.value.length;i++)
		{
			let file_ext = fileList_2.value[i].name.split('.').pop();
			
			if(typeof file_allowed.find(function (ext) { return file_ext == ext; }) == 'undefined')
			{
					return show_msgbox('Ops! ARQUIVO #2 inválido(s). Extensões permitidas: jpg,jpeg,png,mp3,ogg,pdf,doc,docx,rar,zip,xlsx,mp4.', 'warning');
			}
			
			file_size_total += fileList_2.value[i].size;
		}
		if(file_size_total > file_size_defined)
		{
			return show_msgbox('O tamanho máximo permitido para upload é até 250MB.', 'warning');
		}
	}
	if(fileList_3.value.length > 0)
	{
		let file_allowed = ['jpg','jpeg','png','mp3','ogg','pdf','doc','docx','rar','zip','xlsx','mp4'];
		let file_size_defined = 262144000;
		let file_size_total = 0;
		for(let i = 0;i<fileList_3.value.length;i++)
		{
			let file_ext = fileList_3.value[i].name.split('.').pop();
			
			if(typeof file_allowed.find(function (ext) { return file_ext == ext; }) == 'undefined')
			{
					return show_msgbox('Ops! ARQUIVO #3 inválido(s). Extensões permitidas: jpg,jpeg,png,mp3,ogg,pdf,doc,docx,rar,zip,xlsx,mp4.', 'warning');
			}
			
			file_size_total += fileList_3.value[i].size;
		}
		if(file_size_total > file_size_defined)
		{
			return show_msgbox('O tamanho máximo permitido para upload é até 250MB.', 'warning');
		}
	}
	if(empty(situation.value))
	{
		return show_msgbox('O Campo SITUAÇÃO é obrigatório!', 'warning');
	}
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		let response = '';
		let formData = new FormData();
		formData.append('id', id.value);
		formData.append('type', type.value);
		formData.append('title', title.value);
		formData.append('situation', situation.value);
		
		if(!empty(message.value))
		{
			formData.append('message', message.value);
		}
		if(fileList_1.value.length > 0)
		{
			formData.append('file_1', fileList_1.value[0]);
		}
		if(fileList_2.value.length > 0)
		{
			formData.append('file_2', fileList_2.value[0]);
		}
		if(fileList_3.value.length > 0)
		{
			formData.append('file_3', fileList_3.value[0]);
		}
		
		if(props.update == false)
		{
			response = await store.dispatch('insertTemplate', formData);
		}
		else
		{
			response = await store.dispatch('updateTemplate', formData);
		}
		
		try {
			await store.dispatch('getTemplate', {
				srch_type : store.state.template.filters.srch_type,
				srch_title : store.state.template.filters.srch_title,
				srch_situation: store.state.template.filters.srch_situation
			});
		}
		catch(error) {
			return show_msgbox(error.data.message, 'warning');
		}
		
		hideModal();
		return show_msgbox(response, 'success');
	}
	catch(error) {
		return show_msgbox(error.data.message, 'warning');
	}
	finally {
		store.commit('CHANGE_LOADING', false);
	}
}


const TITLEConvertWordToUppercase = () => {
	title.value = convertToUpperCase(title.value);
}

const handleEmojiClick = (e, emoji) => {
	e.preventDefault();
	
	const txtarea = document.getElementById('custom-textarea');
	if (!txtarea) {
		return;
	}

	const scrollPos = txtarea.scrollTop;
	const strPos = txtarea.selectionStart || 0;

	const front = txtarea.value.substring(0, strPos);
	const back = txtarea.value.substring(strPos);
	const newText = front + emoji + back;

	txtarea.value = newText;
	txtarea.selectionStart = strPos + emoji.length;
	txtarea.selectionEnd = strPos + emoji.length;

	txtarea.focus();
	txtarea.scrollTop = scrollPos;
	message.value = txtarea.value;
}

const handleUploadFile_1 = () => {
	let files = document.getElementById('file_1');
	files.click();
	
	files.addEventListener('change', (e) => {
		if(files.files.length <= 0){ return; }
		
		fileList_1.value = [];
		fileItems_1.value = [];
		
		for(let i = 0;i<e.target.files.length;i++)
		{
			fileList_1.value.push(e.target.files[i])
		}
		
		for(var i =0; i<files.files.length; i++){
			fileItems_1.value.push({ name: files.files[i].name });
		}
		files.value = "";
	});
}

const removeFile_1 = async (index, item, type) => {
	const fileListArr = Array.from(fileList_1.value);
	fileListArr.splice(index, 1);
	fileList_1.value = fileListArr;
	fileItems_1.value.splice(index, 1);
	
	if(!props.update){ return; }
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await store.dispatch('destroyFileTemplate', {
			id: id.value,
			type: type
		});
		
		try {
			await store.dispatch('getTemplate', {
				srch_type : store.state.template.filters.srch_type,
				srch_title : store.state.template.filters.srch_title,
				srch_situation: store.state.template.filters.srch_situation
			});
		}
		catch(error) {
			return show_msgbox(error.data.message, 'warning');
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

const handleUploadFile_2 = () => {
	let files = document.getElementById('file_2');
	files.click();
	
	files.addEventListener('change', (e) => {
		if(files.files.length <= 0){ return; }
		
		fileList_2.value = [];
		fileItems_2.value = [];
		
		for(let i = 0;i<e.target.files.length;i++)
		{
			fileList_2.value.push(e.target.files[i])
		}
		
		for(var i =0; i<files.files.length; i++){
			fileItems_2.value.push({ name: files.files[i].name });
		}
		files.value = "";
	});
}

const removeFile_2 = async (index, item, type) => {
	const fileListArr = Array.from(fileList_2.value);
	fileListArr.splice(index, 1);
	fileList_2.value = fileListArr;
	fileItems_2.value.splice(index, 1);
	
	if(!props.update){ return; }
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await store.dispatch('destroyFileTemplate', {
			id: id.value,
			type: type
		});
		
		try {
			await store.dispatch('getTemplate', {
				srch_type : store.state.template.filters.srch_type,
				srch_title : store.state.template.filters.srch_title,
				srch_situation: store.state.template.filters.srch_situation
			});
		}
		catch(error) {
			return show_msgbox(error.data.message, 'warning');
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

const handleUploadFile_3 = async () => {
	let files = document.getElementById('file_3');
	files.click();
	
	files.addEventListener('change', (e) => {
		if(files.files.length <= 0){ return; }
		
		fileList_3.value = [];
		fileItems_3.value = [];
		
		for(let i = 0;i<e.target.files.length;i++)
		{
			fileList_3.value.push(e.target.files[i])
		}
		
		for(var i =0; i<files.files.length; i++){
			fileItems_3.value.push({ name: files.files[i].name });
		}
		files.value = "";
	});
}

const removeFile_3 = async (index, item, type) => {
	const fileListArr = Array.from(fileList_3.value);
	fileListArr.splice(index, 1);
	fileList_3.value = fileListArr;
	fileItems_3.value.splice(index, 1);

	if(!props.update){ return; }
	
	store.commit('CHANGE_LOADING', true);
	
	try {
		const response = await store.dispatch('destroyFileTemplate', {
			id: id.value,
			type: type
		});
		
		try {
			await store.dispatch('getTemplate', {
				srch_type : store.state.template.filters.srch_type,
				srch_title : store.state.template.filters.srch_title,
				srch_situation: store.state.template.filters.srch_situation
			});
		}
		catch(error) {
			return show_msgbox(error.data.message, 'warning');
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

const clearInputs = (flow) => {
	if(flow == 0){ type.value = '1'; }
	title.value                = '';
	message.value              = '';
	if(document.getElementsByClassName("ql-editor")[0] &&
		document.getElementsByClassName("ql-editor")[1])
	{
		document.getElementsByClassName("ql-editor")[0].innerHTML = "";
		document.getElementsByClassName("ql-editor")[1].innerHTML = "";
	}
	situation.value   = '1';
	fileList_1.value  = [];
	fileItems_1.value = [];
	fileList_2.value  = [];
	fileItems_2.value = [];
	fileList_3.value  = [];
	fileItems_3.value = [];
}
</script>