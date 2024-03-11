<template>
	<div class="container_filters">
		<div class="filters_form_container">
			<div class="form_group">
				<label>Filtro - Titulo:</label>
				<input type="text" name="srch_title" @input='emitValue("srch_title", $event.target.value)'>
			</div>
			<div class="form_group">
				<label>Filtro - Tipo:</label>
				<select name="srch_type" @input='emitValue("srch_type", $event.target.value)'>
					<option></option>
					<option value="1">Objeto Postado</option>
					<option value="2">Objeto Encaminhado</option>
					<option value="3">Objeto Saiu para Entrega</option>
					<option value="4">Objeto Entregue</option>
				</select>
			</div>
			<div class="form_group">
				<label>Filtro - Situação:</label>
				<select name="srch_situation" @input='emitValue("srch_situation", $event.target.value)'>
					<option></option>
					<option value="1">Ativo</option>
					<option value="0">Inativo</option>
				</select>
			</div>
		</div>
	</div>
</template>
<style scoped>
.filters_form_container {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
	margin-top: 18px;
}
.form_container .form_group {
	padding:5px 0px;
}
label {
	margin-bottom: 0.5rem !important;
	font-size: 13px;
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
.container_filters {
	margin: 10px 0px;
}
.multiselect {
	margin-top:5px;
}
</style>
<script setup>
import { defineProps, defineEmits } from 'vue';

/* Props */
const props = defineProps({
	srch_type: String,
	srch_title: String,
	srch_situation: String
});

/* Emits */
const emit = defineEmits(['update:srch_title', 'update:srch_situation', 'update:srch_type',]);

/* Functions */
const emitValue =  (propName, value) => {
	emit(`update:${propName}`, value);
}
</script>
