<template>
  <v-container>
    <h2 class="title">Editar Despesa</h2>

    <v-form ref="form" @submit.prevent="salvarAlteracoes">
      <v-text-field v-model="despesa.titulo" label="Título" required />
      <v-text-field
        v-model="valorFormatado"
        label="Valor Total"
        required
        @blur="validarValor"
        :error="valorInvalido"
        error-messages="Insira um valor válido (>= 0)"
      />
      <v-text-field v-model="despesa.chave" label="Chave de Acesso" required />
        
        <v-file-input
        label="Comprovante"
        accept="image/*"
        @change="handleImagem"
        />

      <v-btn color="primary" type="salvarAlteracao">Salvar Alterações</v-btn>
    </v-form>

    <v-snackbar v-model="snackbar" :timeout="3000" top>
      {{ snackbarMessage }}
    </v-snackbar>
  </v-container>
</template>

<script>
import DespesaService from '@/services/DespesaService';

export default {
  data() {
    return {
      despesa: {
        titulo: '',
        valorFormatado: '0,00',
        valorInvalido: false,
        chave: '',
        comprovante: null
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

    carregarDespesa() {
      const id = this.$route.params.id;
      DespesaService.buscarPorId(id).then(response => {
        this.despesa = response;
      });
    },

    handleImagem(file) {
      if (!file) return;

      const reader = new FileReader();
      reader.onload = () => {
      this.despesa.comprovante = reader.result; // base64
    };
    reader.readAsDataURL(file);
  },

    salvarAlteracoes() {
      const payload = {
        titulo: this.despesa.titulo,
        valor: parseFloat(String(this.despesa.valor).replace(',', '.')),
        chave: this.despesa.chave,
        comprovante: this.despesa.comprovante // já em base64
      };
      
      DespesaService.atualizarDespesa(this.despesa.id, payload)
      .then(() => {
        this.snackbarMessage = 'Despesa atualizada com sucesso!';
        this.snackbar = true;
      }).catch(() => {
        this.snackbarMessage = 'Erro ao salvar despesa.';
        this.snackbar = true;
      });
    }
  },
  created() {
    this.carregarDespesa();
  }
};
</script>

<style scoped>
.title {
  text-align: center;
  margin-bottom: 20px;
}
</style>
