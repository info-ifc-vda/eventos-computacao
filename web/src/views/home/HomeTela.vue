<template>
  <v-app>
    <v-app-bar color="#005324" dark app elevate-on-scroll>
      <v-app-bar-nav-icon @click="drawer = !drawer" v-if="logado">
        <v-icon>mdi-menu</v-icon>
      </v-app-bar-nav-icon>
      <router-link to="/" class="logo-link">
        <img src="@/assets/EventIF.png" alt="Logo do EventIF" />
      </router-link>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" app v-if="logado">
      <v-list>
        <v-list-item>
          <v-list-item-avatar>
            <v-icon color="green">mdi-account-circle</v-icon>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="black--text">{{ usuario.nome }}</v-list-item-title>
            <v-list-item-subtitle class="black--text">{{
              usuario.email
            }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>

        <v-list-item to="/cadastro-evento" v-if="isAdmin">
          <v-list-item-icon>
            <v-icon>mdi-calendar-clock</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Cadastrar Eventos</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/cobranca-finalizacao" v-if="isAdmin">
          <v-list-item-icon>
            <v-icon>mdi-cash-multiple</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text"
              >Cobrança e Finalização</v-list-item-title
            >
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/lista-presenca" v-if="isAdmin">
          <v-list-item-icon>
            <v-icon>mdi-cash-sync</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Pagamento</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/pagamento-pix" v-if="isAdmin">
          <v-list-item-icon>
            <v-icon>mdi-hand-coin-outline</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Pagamento Pix</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/gerenciar-eventos" v-if="isAdmin">
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

        <v-list-item to="/listar-despesas" v-if="isAdmin">
          <v-list-item-icon>
            <v-icon>mdi-cart-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Listar Despesas</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/editar-despesas" v-if="isAdmin">
          <v-list-item-icon>
            <v-icon>mdi-cart-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Editar Despesas</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <!-- <v-list-item to="/registro-evento">
          <v-list-item-icon>
            <v-icon>mdi-cart-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text"
              >Cadastrar Evento</v-list-item-title
            >
          </v-list-item-content>
        </v-list-item> -->

        <v-list-item to="/cancelar-participacao" v-if="isAdmin">
          <v-list-item-icon>
            <v-icon>mdi-cart-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Cancelar Evento</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/cadastro-despesa-individual" v-if="isAdmin">
          <v-list-item-icon>
            <v-icon>mdi-cart-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="black--text">Cadastrar Despesa</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>
        <v-list-item @click="logout" class="logout-item" style="cursor: pointer">
          <v-list-item-icon>
            <v-icon color="red">mdi-logout</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="red--text">Sair</v-list-item-title>
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
import UsuarioService from "@/services/UsuarioService";

export default {
  name: "HomeTela",
  data() {
    return {
      drawer: false,
      usuario: {
        nome: "Convidado",
        email: "",
        permissions: [],
      },
      logado: false,
    };
  },
  created() {
    this.carregarUsuarioLogado();
  },
  mounted() {
    this.$root.$on("usuario-logado", (usuario) => {
      this.usuario.nome = usuario.nome;
      this.usuario.email = usuario.email;
      this.usuario.permissions = usuario.permissions;
      this.logado = usuario.logado;
    });
  },
  computed: {
    isAdmin() {
      return this.usuario.permissions.includes("admin");
    },
  },
  methods: {
    async carregarUsuarioLogado() {
      this.logado = false;
      try {
        console.log("Chamando serviço para carregar usuário...");
        const dadosUsuario = await UsuarioService.getUsuarioLogado();

        this.usuario.nome = dadosUsuario.data.name || "Convidado";
        this.usuario.email = dadosUsuario.data.email || "";
        this.usuario.permissions = dadosUsuario.data.permissions || [];
        this.logado = true;
      } catch (error) {
        this.logado = false;
        console.error("Erro ao carregar dados do usuário logado:", error);
      }
    },
    async logout() {
      try {
        localStorage.removeItem("JWT_TOKEN_KEY");
        localStorage.removeItem("JWT_REFRESH_TOKEN_KEY");
        localStorage.removeItem("usuario_nome");
        localStorage.removeItem("usuario_email");
        await UsuarioService.logout();
        this.usuario = {
          nome: "Convidado",
          email: "",
          permissions: [],
        };
        this.logado = false;
        this.$router.push("/login");
      } catch (error) {
        console.error("Erro ao fazer logout:", error.response?.data || error);
      }
    },
  },
};
</script>

<style scoped>
.v-navigation-drawer {
  background: #e8edee !important;
  border-radius: 20px 0 0 20px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.v-navigation-drawer .v-list-item {
  transition: background-color 0.3s ease;
}

.v-navigation-drawer .v-list-item--active {
  background-color: #acf4cb !important;
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
  margin-top: -5px;
  overflow: hidden;
}

img {
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

.logo-link {
  display: inline-block;
  text-decoration: none;
}

.logo-link img {
  display: block;
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

/* Estilo para o item de logout */
.logout-item:hover {
  background-color: #ffcccc !important;
}
</style>
