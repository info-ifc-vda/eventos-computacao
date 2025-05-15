import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';  // Importando o CSS do Vuetify

Vue.use(Vuetify);

export default new Vuetify({
  theme: { dark: false }, // Adapte o tema conforme necessário
});
