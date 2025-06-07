<template>
  <v-container>
    <h2 class="title">Lista de Despesas</h2>

    <v-row>
      <v-col cols="12" sm="5">
        <v-text-field
          v-model="filtro.nome"
          label="Filtrar por Nome"
          @input="validarNome"
          :rules="[apenasLetras]"
        />
      </v-col>
      <v-col cols="12" sm="5">
        <v-text-field
         v-model="filtro.valor"
         label="Filtrar por Valor"
         clearable
         @blur="normalizarFiltroValor"
        />
      </v-col>
      <v-col cols="12" sm="2">
        <v-btn color="primary" @click="buscarDespesas">Buscar</v-btn>
      </v-col>
    </v-row>

    <v-card v-for="item in despesas" :key="item.id" class="mb-3 pa-4" outlined>
      <v-row align="center" justify="space-between">
        <v-col>
          <div><strong>{{ item.nome }}</strong></div>
          <div>R$ {{ item.valor.toFixed(2) }}</div>
        </v-col>
        <v-col class="text-right">
          <v-btn color="success" @click="editarDespesa(item)">Editar</v-btn>
        </v-col>
      </v-row>
    </v-card>

    <v-snackbar v-model="snackbar" :timeout="3000" top>
      {{ snackbarMessage }}
    </v-snackbar>
  </v-container>
</template>

<script>
import router from '@/router';
import DespesaService from '@/services/DespesaService';

export default {
  data() {
    return {
      despesas: [],
      filtro: {
        nome: '',
        valor: ''
      },
      snackbar: false,
      snackbarMessage: ''
    };
  },
  methods: {
    normalizarFiltroValor() {
        if (this.filtro.valor) {
            // Substitui vírgula por ponto e tenta converter
            const valorNumerico = parseFloat(this.filtro.valor.replace(',', '.'));
            if (!isNaN(valorNumerico) && valorNumerico >= 0) {
                this.filtro.valor = valorNumerico;
            } else {
                this.filtro.valor = '';
                this.snackbarMessage = 'Valor inválido para filtro.';
                this.snackbar = true;
            }
        }
    },

    validarNome() {
      this.filtro.nome = this.filtro.nome.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
    },
    apenasLetras(valor) {
      return /^[a-zA-ZÀ-ÿ\s]*$/.test(valor) || 'Digite apenas letras';
    },

    carregarDespesa() {
      DespesaService.listarDespesas()
        .then(response => {
          this.produtos = response;
        })
        .catch(() => {
          this.snackbarMessage = 'Erro ao carregar produtos.';
          this.snackbar = true;
        });
    },

    buscarDespesas() {
      DespesaService.listarDespesasPorFiltro(this.filtro.nome, this.filtro.valor)
        .then(response => {
          this.despesas = response;
        })
        .catch(() => {
          this.snackbarMessage = 'Erro ao buscar despesas.';
          this.snackbar = true;
        });
    },

    editarDespesa(item) {
      router.push({ name: 'EditarDespesa', params: { id: item.id } });
    }
  },
  created() {
    this.buscarDespesa();
  }
};
</script>

<style scoped>
.title {
  text-align: center;
  margin-bottom: 20px;
}
</style>
