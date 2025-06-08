<template>
  <v-container class="mt-10" max-width="800">
    <v-card>
      <v-card-title class="headline">Cadastro de Usuário</v-card-title>
      <v-card-text>
        <v-form ref="form">
          <v-row>
            <v-col cols="12" md="4">
              <v-text-field label="Nome" v-model="usuario.nome" autofocus />
            </v-col>
            <!-- <v-col cols="12" md="6">
              <v-text-field label="CPF" v-model="usuario.cpf" v-mask="'###.###.###-##'" />
            </v-col> -->
            <v-col cols="12" md="4">
              <v-text-field label="Email" v-model="usuario.email" />
            </v-col>
            <v-col cols="12" md="4">
              <v-text-field label="Telefone" v-model="usuario.telefone" v-mask="'(##) #####-####'" />
            </v-col>
            <!-- <v-col cols="12" md="6">
              <v-text-field label="Endereço" v-model="usuario.endereco" />
            </v-col>
            <v-col cols="12" md="6">
              <v-select label="Sexo" :items="['Masculino', 'Feminino', 'Outro']" v-model="usuario.sexo" />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field label="Data de Nascimento" v-model="usuario.dataNascimento" type="date" />
            </v-col> -->
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field label="Senha" v-model="usuario.senha" />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field label="Confirmar Senha" v-model="usuario.confirmarSenha" />
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-btn color="primary" @click="cadastrarUsuario" block>Cadastrar</v-btn>
      </v-card-actions>
      <v-card-actions class="justify-center">
        <router-link to="/">Já tem conta? Faça login</router-link>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script>
import VueMask from 'v-mask';
import UsuarioService from "@/services/UsuarioService";

export default {
  directives: { mask: VueMask.VueMaskDirective },
  data() {
    return {
      usuario: {
        nome: "",
        email: "",
        telefone: "",
        senha: "",
        confirmarSenha: "",
        // cpf: "",
        // endereco: "",
        // sexo: "",
        // dataNascimento: "",
      },
    };
  },
  methods: {
    async cadastrarUsuario() {
      const camposVazios = Object.values(this.usuario).some((v) => !v);
      if (camposVazios) {
        alert("Preencha todos os campos!");
        return;
      }

      if (this.usuario.senha !== this.usuario.confirmarSenha) {
        alert("As senhas não coincidem!");
        return;
      }

      try {
        const usuarioParaEnviar = { ...this.usuario };
        delete usuarioParaEnviar.confirmarSenha;

        await UsuarioService.cadastrarUsuario(usuarioParaEnviar);
        // alert("Usuário cadastrado com sucesso!");
        this.$router.push("/");
      } catch (error) {
        alert("Erro ao cadastrar usuário: " + error.response.data.message);
      }
    },
  },
};
</script>
