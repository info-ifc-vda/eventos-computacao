import Vue from 'vue';
import App from './App.vue';
import router from './router';
import vuetify from './plugins/vuetify';
import '@mdi/font/css/materialdesignicons.css'
import MaskField from "@/components/inputs/MaskField.vue";

Vue.config.productionTip = false;
Vue.component("mask-field", MaskField);

new Vue({
  render: h => h(App),
  router,
  vuetify,
}).$mount('#app');
