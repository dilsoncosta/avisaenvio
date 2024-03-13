<template>
	<div class="container_filters">
		<div class="filters_form_container">
			<div class="form_group">
				<label>Filtro - Destinatário:</label>
				<input type="text" name="srch_destination" @input='emitValue("srch_destination", $event.target.value)'>
			</div>
			<div class="form_group">
				<label>Filtro - Objeto:</label>
				<input type="text" name="srch_object" @input='emitValue("srch_object", $event.target.value)'>
			</div>
			<div class="form_group">
				<label>Filtro - Situação:</label>
				<select name="srch_situation" @input='emitValue("srch_situation", $event.target.value)'>
					<option></option>
					<option value="0">Pendente</option>
					<option value="1">Em Andamento</option>
					<option value="2">Concluido</option>
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
</style>
<script setup>
import { defineProps, defineEmits } from 'vue';

/* Props */
defineProps({
	srch_destination: String,
	srch_object: String,
	srch_situation: String
});

/* Emits */
const emit = defineEmits(['update:srch_destination', 'update:srch_object', 'update:srch_situation']);

/* Functions */
const emitValue =  (propName, value) => {
	emit(`update:${propName}`, value);
}
</script>
