<template>
	<div class="pagination" v-if="pagination.data">
		<div v-if="meta.current_page > 1" class="page-number" @click.prevent="changePage(meta.current_page - 1)"><i class="fal fa-chevron-left"></i></div>
			<div class="active">
				{{ meta.current_page }}
			</div>
		<div v-if="meta.current_page < meta.last_page" class="page-number prev" @click.prevent="changePage(meta.current_page + 1)"><i class="fal fa-chevron-right"></i></div>
	</div>
</template>

<style scoped>
.pagination {
	display: flex;
	justify-content: flex-end;
	width: 100%;
}
.pagination div {
	padding: 18px;
	border: 2px solid #f6f9fc;
	height: 40px;
	width: 40px;
	border-radius: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	background-color: #f6f9fc;
	color:#000;
	margin-right: 4px;
	box-shadow: 0px 0px 4px 0px rgb(0,0,0,0,75);
	cursor: pointer;
}
.pagination .active {
	background-color: #2957a7;
	color: #fff;
}
.pagination ul {
	margin: 2em auto;
	padding-left: 0;
	list-style-type: none;
}
</style>
<script setup>
import { computed, ref, watch } from "vue";

/* Ref or Reactive */
const pagesArray = ref([]);

/* Props */
const props = defineProps({
	pagination: {
		type: Object,
		required: true,
		default: () => {
			return {
				data: [],
				links: {
					first: "",
					last: "",
					next: "",
					prev: "",
				},
				meta: {
					current_page: 1,
					from: 1,
					last_page: 1,
					links: [],
					path: "",
					per_page: 0,
					to: 0,
					total: 0,
				},
			};
		},
	}
});

/* Emits */
const emit = defineEmits(['changePage']);

/* Events */
watch(()=> props.pagination.meta, () => {
		pagesArray.value = []
		for (let page = 1; page <= props.pagination.meta.last_page; page++) {
				pagesArray.value.push(page);
		}
});

const meta = computed(() => props.pagination.meta)

/* Functions */
const changePage = (page) => {
	emit("changePage", page)
}
</script>