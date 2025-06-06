<template>
  <v-app>
    <v-app-bar color="#005324" dark app elevate-on-scroll>
      <v-app-bar-nav-icon @click="drawer = !drawer">
        <v-icon>mdi-menu</v-icon>
      </v-app-bar-nav-icon>
      <img src="@/assets/EventIF.png" alt="Logo do EventIF">
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" app>
      <v-list>

        <v-list-item to="/cadastro-evento">
          <v-list-item-icon>
            <v-icon>mdi-calendar-clock</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Cadastrar Eventos</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/cobranca-finalizacao">
            <v-list-item-icon>
              <v-icon>mdi-cash-multiple</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title class="black--text">Cobrança e Finalização</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item to="/lista-presenca">
              <v-list-item-icon>
                <v-icon>mdi-cash-sync</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="black--text">Pagamento</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item to="/pagamento-pix">
            <v-list-item-icon>
              <v-icon>mdi-hand-coin-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title class="black--text">Pagamento Pix</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

        <v-list-item to="/gerenciar-eventos">
          <v-list-item-icon>
            <v-icon>mdi-calendar-edit</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Gerenciar Eventos</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/listar-eventos">
          <v-list-item-icon>
            <v-icon>mdi-format-list-bulleted</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Listagem de Eventos</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/seus-eventos">
          <v-list-item-icon>
            <v-icon>mdi-account-details</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Seus Eventos</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item to="/listar-despesas">
          <v-list-item-icon>
            <v-icon>mdi-cart-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Listar Despesas</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item to="/editar-despesas">
          <v-list-item-icon>
            <v-icon>mdi-cart-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Editar Despesas</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/registro-evento">
          <v-list-item-icon>
            <v-icon>mdi-cart-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Cadastrar Evento</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/cancelar-participacao">
          <v-list-item-icon>
            <v-icon>mdi-cart-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Cancelar Evento</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

 <v-list-item to="/cadastro-despesa-individual">
          <v-list-item-icon>
            <v-icon>mdi-cart-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Cadastrar Despesa</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

      </v-list>
    </v-navigation-drawer>
    <v-main>
      <v-container>
        <router-view></router-view>
      </v-container>
      <footer class="text-center">
        <p>&copy; EventIF 2025</p>
      </footer>
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
      menuEvento: false,
    };
  },
};

</script>

<style scoped>
.v-navigation-drawer {
  background: #E8EDEE !important;
  border-radius: 20px 0 0 20px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.v-navigation-drawer .v-list-item {
  transition: background-color 0.3s ease;
}

.v-navigation-drawer .v-list-item--active {
  background-color: #ACF4CB !important;
  color: black !important;
}

.v-list-item:hover {
  background-color: #bff4d6;
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
  margin-left: -3px;
  /* Move para a esquerda */
  margin-top: -5px;
  /* Move para cima */
  overflow: hidden;
}

img {
  /* width: 6%; */
  width: 100px;
  height: auto;
}

.v-main {
  background-color: #fff;
  display: flex;
  flex-direction: column;
  min-height: 128vh;
  padding-bottom: 70px;
}

.content-wrapper {
  flex: 1;
  padding-top: 20px;
}

footer {
  background-color: #005324;
  color: white;
  text-align: center;
  padding: 1rem;
  position: fixed;
  bottom: 0;
  width: 100%;
  height: 60px;
}
</style>
