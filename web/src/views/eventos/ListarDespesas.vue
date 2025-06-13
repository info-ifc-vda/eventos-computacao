<template>
  <v-container>
    <h2 class="title">Despesas do Evento</h2>

    <v-row>
      <!-- Formulário: ocupa 12 colunas em xs e sm, e 4 colunas em md+ -->
      <v-col cols="12" md="4">
        <v-card class="pa-4" outlined>
          <h3>Cadastrar Despesa</h3>
          <v-form ref="form" v-model="formValido" @submit.prevent="submitForm">
            <v-text-field
              v-model="novaDespesa.title"
              label="Título da Despesa"
              :rules="[(v) => !!v || 'Campo obrigatório']"
              required
              autofocus
            />
            <v-text-field
              v-model="novaDespesa.proof_access_key"
              label="Chave de Acesso do Comprovante"
              :rules="[(v) => !!v || 'Campo obrigatório']"
              required
            />
            <v-text-field
              v-model.number="novaDespesa.items_total"
              label="Valor"
              type="number"
              :rules="[(v) => v > 0 || 'Valor inválido']"
              required
              placeholder="0.00"
            />
            <v-btn color="primary" type="submit" :disabled="!formValido"
              >Cadastrar</v-btn
            >
          </v-form>
        </v-card>
      </v-col>

      <!-- Lista de despesas: ocupa 12 colunas em xs e sm, e 8 colunas em md+ -->
      <v-col cols="12" md="8">
        <div v-if="despesas.length === 0" class="text-center mt-6">
          <em>Nenhuma despesa encontrada.</em>
        </div>

        <div v-if="despesas.length === 0" class="text-center mt-6">
          <em>Nenhuma despesa encontrada.</em>
        </div>

        <v-data-table
          :headers="headers"
          :items="despesas"
          class="elevation-1 w-100"
          dense
          striped
          hide-default-footer
          fixed-header
          height="auto"
        >
          <template v-slot:item.actions="{ item }">
            <v-btn color="success" small @click="editarDespesa(item)"
              >Editar</v-btn
            >
            <v-btn
              color="error"
              small
              class="ml-2"
              @click="excluirDespesa(item)"
              >Excluir</v-btn
            >
          </template>
        </v-data-table>
      </v-col>
    </v-row>

    <v-snackbar v-model="snackbar" :timeout="3000" top>
      {{ snackbarMessage }}
    </v-snackbar>
  </v-container>
</template>

<script>
import router from "@/router";
import DespesaService from "@/services/DespesaService";

export default {
  data() {
    return {
      despesas: [],
      novaDespesa: {
        proof_access_key: "",
        items_total: "",
        title: "",
      },
      formValido: false,
      snackbar: false,
      snackbarMessage: "",
      headers: [
        { text: "Título", value: "title" },
        { text: "Chave de Acesso", value: "proof_access_key" },
        { text: "Valor", value: "items_total" },
        { text: "Ações", value: "actions", sortable: false, align: "center" },
      ],
    };
  },
  computed: {
    idEvento() {
      return this.$route.params.id;
    },
  },
  methods: {
    carregarDespesas() {
      DespesaService.listarDespesas(this.idEvento)
        .then((response) => {
          this.despesas = response;
        })
        .catch(() => {
          this.snackbarMessage = "Erro ao carregar despesas.";
          this.snackbar = true;
        });
    },

    submitForm() {
      console.log("ID do Evento:", this.idEvento);

      if (!this.$refs.form.validate()) {
        return;
      }
      DespesaService.criarDespesa(this.idEvento, this.novaDespesa)
        .then(() => {
          this.snackbarMessage = "Despesa cadastrada com sucesso!";
          this.snackbar = true;
          this.novaDespesa = {
            proof_access_key: "",
            items_total: "",
            title: "",
          };
          this.$refs.form.resetValidation();
          this.carregarDespesas();
        })
        .catch(() => {
          this.snackbarMessage = "Erro ao cadastrar despesa.";
          this.snackbar = true;
        });
    },

    editarDespesa(item) {
      router.push({ name: "EditarDespesas", params: { id: item.id } });
    },

    excluirDespesa(item) {
      DespesaService.deletarDespesa(this.idEvento, item.id)
        .then(() => {
          this.snackbarMessage = "Despesa excluída com sucesso!";
          this.snackbar = true;
          this.carregarDespesas();
        })
        .catch(() => {
          this.snackbarMessage = "Erro ao excluir despesa.";
          this.snackbar = true;
        });
    },
  },
  created() {
    this.carregarDespesas();
  },
};
</script>

<style scoped>
.title {
  text-align: center;
  margin-bottom: 20px;
}
</style>
