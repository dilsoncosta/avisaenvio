<template>
	<div class="container_filters">
		<div class="filters_form_container">
			<div class="form_group">
				<label>Filtro - Cliente:</label>
				<Multiselect
					v-model="clients.value"
					v-bind="clients"
					@select='emitValue("srch_client", $event)'
					@clear="clearFilterClientId()">
				</Multiselect>
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
	grid-template-columns: repeat(2, 1fr);
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
import { ref } from 'vue';

/* Props */
const props = defineProps({
	srch_client: String,
	srch_situation: String,
	optionsClients: Object
});

/* Ref or Reactive */
const clients = ref({
	mode: 'single',
	value: null,
	closeOnSelect: true,
	options: props.optionsClients,
	searchable: true,
	createOption: true,
	noResultsText: "Nenhum resultado encontrado",
	noOptionsText: "Nenhum resultado encontrado",
});

/* Emits */
const emit = defineEmits(['update:srch_client', 'update:srch_situation']);

/* Functions */
const emitValue =  (propName, value) => {
	emit(`update:${propName}`, value);
}

const clearFilterClientId = () => {
	emit('update:srch_client', '');
}
</script>
