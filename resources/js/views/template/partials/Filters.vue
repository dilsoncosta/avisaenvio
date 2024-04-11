<template>
	<div class="container_filters">
		<div :class="{ filters_form_container_three_column: ind_mod_order_tracking === 1, filters_form_container_two_column: ind_mod_order_tracking !== 1 }">
			<div class="form_group">
				<label>Filtro - Titulo:</label>
				<input type="text" name="srch_title" @input='emitValue("srch_title", $event.target.value)'>
			</div>
			<div class="form_group" v-if="ind_mod_order_tracking == 1">
				<label>Filtro - Tipo:</label>
				<select name="srch_type" @input='emitValue("srch_type", $event.target.value)'>
					<option></option>
					<option value="1">Pedido postado</option>
					<option value="2">Em trânsito</option>
					<option value="3">Saiu entrega</option>
					<option value="4">Entregue</option>
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
.filters_form_container_three_column {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 10px;
	margin-top: 18px;
}
.filters_form_container_two_column {
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
import { useStore } from 'vuex';

/* Props */
const store = useStore();
const props = defineProps({
	srch_type: String,
	srch_title: String,
	srch_situation: String
});
const ind_mod_order_tracking = store.state.auth.me.ind_mod_order_tracking;

/* Emits */
const emit = defineEmits(['update:srch_title', 'update:srch_situation', 'update:srch_type',]);

/* Functions */
const emitValue =  (propName, value) => {
	emit(`update:${propName}`, value);
}
</script>
