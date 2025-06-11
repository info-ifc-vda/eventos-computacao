<template>
  <v-container
    class="d-flex justify-center align-center fill-height login-container"
  >
    <transition name="fade">
      <v-card elevation="10" class="pa-8 login-card" max-width="500" shaped>
        <div class="text-center mb-8">
          <img
            src="@/assets/EventIF.png"
            alt="Logo do EventIF"
            class="logo-img"
          />
          <h2 class="mt-4 font-weight-medium">Bem-vindo ao EventIF</h2>
          <p class="subtitle">Faça login para continuar</p>
        </div>

        <v-alert
          v-if="mensagemErro"
          type="error"
          dense
          outlined
          class="mb-4"
          transition="fade-transition"
        >
          {{ mensagemErro }}
        </v-alert>

        <v-form @submit.prevent="fazerLogin" ref="form">
          <v-text-field
            v-model="email"
            label="Email"
            prepend-inner-icon="mdi-email"
            placeholder="seuemail@exemplo.com"
            outlined
            dense
            :rules="[(v) => !!v || 'Email é obrigatório']"
            required
            type="email"
            autocomplete="email"
            autofocus
          />

          <v-text-field
            v-model="senha"
            :type="mostrarSenha ? 'text' : 'password'"
            label="Senha"
            placeholder="Digite sua senha"
            prepend-inner-icon="mdi-lock"
            :append-icon="mostrarSenha ? 'mdi-eye-off' : 'mdi-eye'"
            @click:append="mostrarSenha = !mostrarSenha"
            outlined
            dense
            :rules="[(v) => !!v || 'Senha é obrigatória']"
            required
          />

          <v-btn
            color="#36c000"
            block
            large
            :loading="carregando"
            type="submit"
            class="white--text"
          >
            <v-icon left>mdi-login</v-icon>
            Entrar
          </v-btn>
        </v-form>

        <div class="text-center mt-5">
          <router-link to="/cadastro-usuario" class="cadastro-link">
            Não tem conta? <strong>Cadastre-se</strong>
          </router-link>
        </div>
      </v-card>
    </transition>
  </v-container>
</template>

<script>
import UsuarioService from "@/services/UsuarioService";
import { JWT_TOKEN_KEY } from "@/constants";

export default {
  name: "LoginView",
  data() {
    return {
      email: "",
      senha: "",
      mostrarSenha: false,
      carregando: false,
      mensagemErro: "",
    };
  },
  methods: {
    async fazerLogin() {
      this.mensagemErro = "";
      const valido = this.$refs.form.validate();
      if (!valido) return;

      this.carregando = true;
      try {
        await UsuarioService.login(this.email, this.senha);
        const dadosUsuario = await UsuarioService.getUsuarioLogado();

        this.$root.$emit("usuario-logado", {
          nome: dadosUsuario.data.name,
          email: dadosUsuario.data.email,
          permissions: dadosUsuario.data.permissions,
          logado: true,
        });

        this.$router.push("/listar-eventos");
      } catch (error) {
        this.mensagemErro =
          error.response?.data?.message || "Erro ao realizar login.";
      } finally {
        this.carregando = false;
      }
    },
    async verificarToken() {
      const token = localStorage.getItem(JWT_TOKEN_KEY);
      if (!token) return;

      const resultado = await UsuarioService.validarToken();
      if (resultado) {
        this.$router.push("/listar-eventos");
      } else {
        localStorage.removeItem(JWT_TOKEN_KEY);
      }
    },
  },
};
</script>

<style scoped>
.login-card {
  animation: fadeIn 0.7s ease;
  width: 100%;
  max-width: 500px;
}

.logo-img {
  width: 250px;
  height: auto;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.subtitle {
  color: #757575;
  font-size: 18px;
  margin-top: 4px;
}

.cadastro-link {
  font-size: 15px;
  color: #36c000;
  text-decoration: none;
}

.cadastro-link:hover {
  text-decoration: underline;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(15px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Para animar a transição v-alert */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
