<template>
	<div class="container_filters">
		<div class="filters_form_container">
			<div class="form_group">
				<label>Filtro - Data do Check-in:</label>
				<input type="date" name="srch_date_checkin" @input='emitValue("srch_date_checkin", $event.target.value)'>
			</div>
			<div class="form_group">
				<label>Filtro - Data do Checkout:</label>
				<input type="date" name="srch_date_checkout"  @input='emitValue("srch_date_checkout", $event.target.value)'>
			</div>
			<div class="form_group">
				<label>Filtro - Nome e Sobrenome:</label>
				<input type="text" name="srch_name_surname" @input='emitValue("srch_name_surname", $event.target.value)'>
			</div>
			<div class="form_group">
				<label>Filtro - WhatsApp:</label>
				<input type="text" name="srch_whatsapp" @input='emitValue("srch_whatsapp", $event.target.value)'>
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
</style>
<script setup>

/* Props */
defineProps({
	srch_date_checkin: String,
	srch_date_checkout: String,
	srch_name_surname: String,
	srch_whatsapp: String,
	srch_situation: String
});

/* Emits */
const emit = defineEmits(['update:srch_date_checkin', 'update:srch_date_checkout', 'update:srch_name_surname', 'update:srch_whatsapp', 'update:srch_situation']);

/* Functions */
const emitValue =  (propName, value) => {
	emit(`update:${propName}`, value);
}
</script>
