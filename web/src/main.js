import Vue from 'vue';
import App from './App.vue';
import router from './router';
import vuetify from './plugins/vuetify';
import '@mdi/font/css/materialdesignicons.css';

import MaskField from "@/components/inputs/MaskField.vue";
import VueTheMask from 'vue-the-mask';

Vue.config.productionTip = false;

Vue.component("mask-field", MaskField);

Vue.use(VueTheMask);

router.afterEach((to) => {
  const defaultTitle = 'EventIF';
  document.title = to.meta.title ? `${to.meta.title} - ${defaultTitle}` : defaultTitle;
});

new Vue({
  render: h => h(App),
  router,
  vuetify,
}).$mount('#app');
