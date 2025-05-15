<template>
  <a-container>
    <v-form ref="form" v-model="valid" lazy-validation>
      <h2 style="margin-left: 0;">Dados do Produto</h2>
      <v-row>
        <v-col cols="12" md="6">
          <v-text-field 
            v-model="produto.nome" 
            label="Nome do Produto" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="6">
          <v-text-field 
            v-model="produto.preco" 
            label="Preço" 
            type="number" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
      </v-row>
    </v-form>
    <a-container>
      <v-row justify="center">
        <v-col cols="auto">
          <v-btn
            @click="adicionarProduto"
            :loading="buttonLoading"
            color="#388E3C"
            class="white--text"
          >
            Cadastrar
          </v-btn>
        </v-col>
      </v-row>
    </a-container>
    <v-snackbar v-model="snackbarErro" color="red">
      {{ mensagemErro }}
    </v-snackbar>
    <v-snackbar v-model="snackbarSucesso" color="green">
      {{ mensagemSucesso }}
    </v-snackbar>
  </a-container>
</template>

<script>
import ProdutoService from '@/services/ProdutoService';

export default {
  name: "CadastroProduto",
  data() {
    return {
      valid: false,
      produto: {
        nome: "",
        preco: "",
      },
      buttonLoading: false,
      mensagemErro: "",
      mensagemSucesso: "",
      snackbarErro: false,
      snackbarSucesso: false,
    };
  },
  methods: {
    async adicionarProduto() {
      if (!this.$refs.form.validate()) {
        this.mensagemErro = "Preencha todos os campos obrigatórios!";
        this.snackbarErro = true;
        return;
      }

      this.buttonLoading = true;
      try {
        await ProdutoService.criarProduto(this.produto);
        this.mensagemSucesso = "Produto cadastrado com sucesso!";
        this.snackbarSucesso = true;
        this.limparFormulario();
      } catch (error) {
        console.error("Erro ao cadastrar produto", error);
        this.mensagemErro = "Erro ao cadastrar produto! Tente novamente.";
        this.snackbarErro = true;
      } finally {
        this.buttonLoading = false;
      }
    },

    limparFormulario() {
      this.produto = { nome: "", preco: "" };
      this.$refs.form.resetValidation();
    }
  },
};
</script> 
<style scoped>
.container {
  max-width: 400px;
  margin: auto;
  padding: 20px;
}
.title {
  text-align: center;
}
</style>
