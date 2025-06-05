<template>
  <v-container>
    <h2 class="title">Cobrança & Finalização</h2>

    <v-form>
      <v-row>
        <v-col cols="12" md="8">
          <v-select
            v-model="eventoSelecionado"
            :items="eventos"
            item-text="nome"
            item-value="id"
            label="Selecione o evento"
            :rules="[v => !!v || 'Selecione um evento']"
            :loading="carregando"
            :disabled="carregando"
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-btn color="primary" @click="carregarEvento" :disabled="!eventoSelecionado">
            Carregar Participantes
          </v-btn>
        </v-col>
      </v-row>
    </v-form>

    <v-data-table
      :headers="headers"
      :items="participantes"
      class="mt-6"
      item-key="nome"
      hide-default-header
      dense
      v-if="participantes.length"
    >
      <template v-slot:header>
        <thead>
          <tr>
            <th class="text-left px-4">Nome</th>
            <th class="text-center px-4">Valor</th>
            <th class="text-center px-4">Pagamento Efetuado</th>
          </tr>
        </thead>
      </template>

      <template v-slot:item="{ item }">
        <tr>
          <td class="text-left px-4">{{ item.nome }}</td>
          <td class="text-center px-4">R$ {{ item.valor.toFixed(2) }}</td>
          <td
            class="text-center px-4"
            style="display: flex; justify-content: center; align-items: center; height: 48px;"
          >
            <v-switch
              v-model="item.pago"
              hide-details
              inset
              density="compact"
              color="success"
              class="ma-1 pa-1"
            />
          </td>
        </tr>
      </template>
    </v-data-table>

    <v-row class="mt-6" justify="center">
      <v-col cols="12" md="4">
        <v-btn block color="success" @click="salvarAlteracoes" :loading="loadingSalvar">
          Salvar Alterações
        </v-btn>
      </v-col>
      <v-col cols="12" md="4">
        <v-btn block color="warning" @click="solicitarPagamento" :loading="loadingSolicitar">
          Solicitar Pagamento
        </v-btn>
      </v-col>
      <v-col cols="12" md="4">
        <v-btn
          block
          color="error"
          @click="finalizarEvento"
          :disabled="!todosPagaram"
          :loading="loadingFinalizar"
        >
          Finalizar Evento
        </v-btn>
      </v-col>
    </v-row>

    <v-snackbar v-model="snackbar.visible" :color="snackbar.color" top timeout="3000">
      {{ snackbar.text }}
    </v-snackbar>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  name: "FinalizarEvento",
  data() {
    return {
      eventoSelecionado: null,
      eventos: [],
      participantes: [],
      headers: [
        { text: "Nome", value: "nome" },
        { text: "Valor", value: "valor" },
        { text: "Pagamento Efetuado", value: "pago", sortable: false },
      ],
      snackbar: {
        visible: false,
        text: "",
        color: "success",
      },
      carregando: false,
      loadingSalvar: false,
      loadingSolicitar: false,
      loadingFinalizar: false,
    };
  },

  computed: {
    todosPagaram() {
      return this.participantes.length > 0 && this.participantes.every((p) => p.pago);
    },
  },

  mounted() {
    this.carregarEventos();
  },

  methods: {
    async carregarEventos() {
      this.carregando = true;
      try {
        const response = await axios.get("/api/eventos");
        // Supondo que a API retorne { eventos: [...] }
        this.eventos = response.data.eventos;
      } catch (error) {
        this.snackbar = {
          visible: true,
          text: "Erro ao carregar eventos.",
          color: "error",
        };
      } finally {
        this.carregando = false;
      }
    },

    async carregarEvento() {
      if (!this.eventoSelecionado) return;

      this.carregando = true;
      try {
        const response = await axios.get(`/api/eventos/${this.eventoSelecionado}/participantes`);
        // Supondo que a API retorne { participantes: [...] }
        this.participantes = response.data.participantes.map((p) => ({
          nome: p.nome,
          valor: p.valor,
          pago: p.pago,
        }));
      } catch (error) {
        this.snackbar = {
          visible: true,
          text: "Erro ao carregar participantes.",
          color: "error",
        };
      } finally {
        this.carregando = false;
      }
    },

    async salvarAlteracoes() {
      if (!this.eventoSelecionado) {
        this.snackbar = {
          visible: true,
          text: "Selecione um evento antes de salvar.",
          color: "error",
        };
        return;
      }

      this.loadingSalvar = true;
      try {
        // Exemplo de payload: lista de participantes com status pago
        const payload = {
          participantes: this.participantes.map((p) => ({
            nome: p.nome,
            valor: p.valor,
            pago: p.pago,
          })),
        };

        console.log("Payload a ser enviado:", payload);
        await axios.put(`/api/eventos/${this.eventoSelecionado}/participantes`, payload);

        this.snackbar = {
          visible: true,
          text: "Alterações salvas com sucesso!",
          color: "success",
        };
      } catch (error) {
        this.snackbar = {
          visible: true,
          text: "Erro ao salvar alterações.",
          color: "error",
        };
      } finally {
        this.loadingSalvar = false;
      }
    },

    async solicitarPagamento() {
      if (!this.eventoSelecionado) {
        this.snackbar = {
          visible: true,
          text: "Selecione um evento antes de solicitar pagamento.",
          color: "error",
        };
        return;
      }

      const participantesPendentes = this.participantes.filter((p) => !p.pago);
      if (participantesPendentes.length === 0) {
        this.snackbar = {
          visible: true,
          text: "Todos os participantes já efetuaram o pagamento!",
          color: "info",
        };
        return;
      }

      this.loadingSolicitar = true;
      try {
        await axios.post(`/api/eventos/${this.eventoSelecionado}/solicitar-pagamento`, {
          participantes: participantesPendentes.map((p) => p.nome),
        });

        this.snackbar = {
          visible: true,
          text: `Solicitação de pagamento enviada para ${participantesPendentes.length} participante(s)!`,
          color: "warning",
        };
      } catch (error) {
        this.snackbar = {
          visible: true,
          text: "Erro ao solicitar pagamento.",
          color: "error",
        };
      } finally {
        this.loadingSolicitar = false;
      }
    },

    async finalizarEvento() {
      if (!this.eventoSelecionado) {
        this.snackbar = {
          visible: true,
          text: "Selecione um evento antes de finalizar.",
          color: "error",
        };
        return;
      }

      if (!this.todosPagaram) {
        this.snackbar = {
          visible: true,
          text: "Nem todos os participantes efetuaram o pagamento.",
          color: "error",
        };
        return;
      }

      this.loadingFinalizar = true;
      try {
        await axios.post(`/api/eventos/${this.eventoSelecionado}/finalizar`);

        this.snackbar = {
          visible: true,
          text: "Evento finalizado com sucesso!",
          color: "success",
        };

        // Opcional: Limpar participantes e seleção de evento
        this.participantes = [];
        this.eventoSelecionado = null;
      } catch (error) {
        this.snackbar = {
          visible: true,
          text: "Erro ao finalizar evento.",
          color: "error",
        };
      } finally {
        this.loadingFinalizar = false;
      }
    },
  },
};
</script>

<style scoped>
.title {
  text-align: center;
  margin-bottom: 20px;
}
</style>