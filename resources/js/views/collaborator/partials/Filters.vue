<template>
	<div class="container_filters">
		<div class="filters_form_container">
			<div class="form_group">
				<label>Filtro - Username:</label>
				<input type="text" name="username" @input='emitValue("srch_username", $event.target.value)'>
			</div>
			<div class="form_group">
				<label>Filtro - Email:</label>
				<input type="text" name="email" @input='emitValue("srch_email", $event.target.value)'>
			</div>
			<div class="form_group">
				<label>Filtro - Situação:</label>
				<select name="situation" @input='emitValue("srch_situation", $event.target.value)'>
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
</style>
<script setup>
import { defineProps, defineEmits } from 'vue';

/* Props */
defineProps({
	srch_username: String,
	srch_email: String,
	srch_situation: String
});

/* Emits */
const emit = defineEmits(['update:srch_username', 'update:srch_email', 'update:srch_situation']);

/* Functions */
const emitValue =  (propName, value) => {
	emit(`update:${propName}`, value);
}
</script>
