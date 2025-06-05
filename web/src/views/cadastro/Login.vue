<template>
  <v-container class="d-flex justify-center align-center fill-height login-container">
    <v-card elevation="10" class="pa-8" max-width="500" shaped>
      <div class="text-center mb-8">
        <img src="@/assets/EventIF.png" alt="Logo do EventIF" class="logo-img" />
        <h2 class="mt-4 font-weight-medium">Bem-vindo ao EventIF</h2>
        <p class="subtitle">Faça login para continuar</p>
      </div>
      <v-text-field v-model="email" label="Email" prepend-inner-icon="mdi-email" outlined dense class="mb-4" />
      <v-text-field v-model="senha" label="Senha" type="password" prepend-inner-icon="mdi-lock" outlined dense
        class="mb-4" />

      <v-btn color="#36c000" block large @click="fazerLogin">
        Entrar
      </v-btn>

      <div class="text-center mt-5">
        <router-link to="/cadastro-usuario" class="cadastro-link">
          Não tem conta? <strong>Cadastre-se</strong>
        </router-link>
      </div>
    </v-card>
  </v-container>
</template>

<script>
import VueMask from 'v-mask';
import UsuarioService from "@/services/UsuarioService";

export default {
  name: "LoginView",
  directives: { mask: VueMask.VueMaskDirective },
  data() {
    return {
      email: "",
      senha: "",
    };
  },
  methods: {
    async fazerLogin() {
      if (!this.email || !this.senha) {
        alert("Preencha todos os campos!");
        return;
      }
      try {
        await UsuarioService.login(this.email, this.senha);
        alert("Login realizado com sucesso!");
        this.$router.push("/eventos");
      } catch (error) {
        alert("email ou senha inválidos.");
      }
    },
  },
};
</script>

<style scoped>
.logo-img {
  width: 380px;
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
</style>
