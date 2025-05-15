<template>
  <v-app>
    <v-app-bar color="primary" dark app elevate-on-scroll>
      <v-app-bar-nav-icon @click="drawer = !drawer">
        <v-icon>mdi-menu</v-icon>
      </v-app-bar-nav-icon>
      <v-toolbar-title>Sistema de Gestão IFC</v-toolbar-title>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" app dark color="grey lighten-2" shaped  class="rounded-xl drawer-custom">
      <v-list>
        <v-list-item to="/home">
          <v-list-item-icon>
            <v-icon>mdi-home</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Home</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-group v-model="menuProduto" :prepend-icon="'mdi-cart-plus'">
          <template v-slot:activator>
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-cart-plus</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="black--text">Produto</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
          <v-list-item to="/cadastro-produto">
            <v-list-item-icon>
              <v-icon>mdi-cart-plus</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title class="black--text">Cadastrar Produto</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/listar-produtos">
            <v-list-item-icon>
              <v-icon>mdi-format-list-bulleted</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title class="black--text">Lista de Produtos</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>
    <v-main>
      <v-container>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "HomeTela",
  data() {
    return {
      drawer: false,
      menuProduto: false,
      menuPedido: false,
    };
  },
};
</script>

<style scoped>
.v-navigation-drawer {
  background: linear-gradient(180deg, #eceff1, #cfd8dc);
  border-radius: 20px 0 0 20px;
  box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.v-navigation-drawer .v-list-item {
  transition: background-color 0.3s ease;
}

.v-navigation-drawer .v-list-item:hover {
  background-color: #90a4ae;
}

.v-navigation-drawer .v-list-item-title {
  font-size: 1.1rem;
  font-weight: bold;
  color: black !important;
}

.v-navigation-drawer .v-list-item-icon {
  color: black;
  font-size: 1.5rem;
}

.v-app-bar {
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
}

.v-app-bar-nav-icon {
  background-color: transparent;
}

.v-main {
  background-color: #f4f7fb;
  padding: 20px;
}

.v-list-item-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: black;
}

.v-navigation-drawer--close {
  transform: translateX(-100%);
}

.v-navigation-drawer--open {
  transform: translateX(0);
}

.drawer-custom {
  border-radius: 16px !important;
  margin-left: -3px;  /* Move para a esquerda */
  margin-top: -5px;   /* Move para cima */
  overflow: hidden;
}


</style>
