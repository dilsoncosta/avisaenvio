
import { createApp } from 'vue';
import App from './App.vue';

import router from './router';
import store from './store';
import { vfmPlugin } from 'vue-final-modal';
import Multiselect from '@vueform/multiselect';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import simpleAcl from './acl';
import money from 'v-money3';
import Preloader from './components/Preloader.vue';

const app = createApp(App);

app.use(simpleAcl)
app.use(store)
app.use(vfmPlugin)
app.use(router)
app.use(money)
app.component('Multiselect', Multiselect)
app.component('Preloader', Preloader)

app.mount('#app');

store.dispatch('checkLogin').catch(() => {
	if(store.state.requiredPageAuth == true)
	{
		router.push({name: 'login'})
	}
});
