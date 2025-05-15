import Vue from 'vue';
import App from './App.vue';
import router from './router';
import vuetify from './plugins/vuetify';  // Importando Vuetify do arquivo plugins/vuetify.js

Vue.config.productionTip = false;

new Vue({
  render: h => h(App),
  router,
  vuetify,  // Certifique-se de adicionar o Vuetify aqui
}).$mount('#app');
