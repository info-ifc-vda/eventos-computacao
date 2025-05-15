<template>
  <v-container>
    <h2 class="title">Lista de Produtos</h2>
    <v-row>
      <v-col>
        <v-text-field v-model="filtro.nome" label="Filtrar por Nome"></v-text-field>
      </v-col>
      <v-col>
        <v-text-field v-model="filtro.preco" label="Filtrar por Preço" type="number"></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="primary" @click="carregarProdutos">Carregar Produtos</v-btn>
    <v-data-table v-if="produtos.length" :headers="headers" :items="produtos" item-key="id">
      <template v-slot:item="{ item }">
        <tr :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.nome }}</td>
          <td>{{ item.preco }}</td>
          <td>
            <v-btn color="error" small @click="removerProduto(item.id)">Excluir</v-btn>
          </td>
        </tr>
      </template>
    </v-data-table>
    <v-snackbar v-model="snackbar" :timeout="3000" top>
      {{ snackbarMessage }}
    </v-snackbar>
  </v-container>
</template>

<script>
import ProdutoService from '@/services/ProdutoService';

export default {
  data() {
    return {
      produtos: [],
      filtro: {
        nome: '',
        preco: ''
      },
      headers: [
        { text: 'ID', value: 'id' },
        { text: 'Nome', value: 'nome' },
        { text: 'Preço', value: 'preco' },
        { text: 'Ações', value: 'actions', sortable: false }
      ],
      snackbar: false,
      snackbarMessage: ''
    };
  },
  methods: {
    carregarProdutos() {
      ProdutoService.listarProdutos()
        .then(response => {
          this.produtos = response;
        })
        .catch(() => {
          this.snackbarMessage = 'Erro ao carregar produtos.';
          this.snackbar = true;
        });
    },
    buscarProdutos() {
      ProdutoService.listarProdutosPorFiltro(this.filtro.nome, this.filtro.preco)
        .then(response => {
          this.produtos = response;
        })
        .catch(() => {
          this.snackbarMessage = 'Erro ao buscar produtos.';
          this.snackbar = true;
        });
    },
    removerProduto(id) {
      if (confirm('Tem certeza que deseja excluir este produto?')) {
        ProdutoService.deletarProduto(id)
          .then(() => {
            this.snackbarMessage = 'Produto deletado com sucesso!';
            this.snackbar = true;
            this.carregarProdutos();
          })
          .catch(() => {
            this.snackbarMessage = 'Erro ao deletar produto.';
            this.snackbar = true;
          });
      }
    }
  },
  created() {
    this.carregarProdutos();
  }
};
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: auto;
  padding: 20px;
}
.title {
  text-align: center;
}
</style>