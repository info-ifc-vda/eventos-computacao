<template>
  <v-container>
    <h2 class="title">Lista de Eventos</h2>
    <v-row>
      <v-col>
        <v-text-field v-model="filtro.nome" class="text" label="Filtrar por Nome" />
      </v-col>
      <v-col>
        <v-text-field v-model="filtro.data" class="text" type="date" label="Filtrar por Data" />
      </v-col>
      <v-col cols="12" md="2" class="d-flex align-center">
        <v-btn class="botao" @click="buscarEventos">Buscar</v-btn>
      </v-col>
    </v-row>

    <v-data-table
      class="tabela"
      v-if="eventos.length"
      :headers="headers"
      :items="eventos"
      item-key="id"
    >
      <template v-slot:item="{ item }">
        <tr :key="item.id">
          <td>{{ item.title }}</td>
          <td>{{ item.event_initial_date || '—' }}</td>
          <td>
            <v-btn color="botao-opcao" small @click="irParaDetalhes(item.id)">Detalhes</v-btn>
            <v-btn color="botao-opcao" small @click="irParaEditar(item.id)">Editar</v-btn>
            <v-btn color="botao-opcao" small @click="abrirDialog(item.id)">Excluir</v-btn>
          </td>
        </tr>
      </template>
    </v-data-table>

    <v-snackbar v-model="snackbar" :timeout="3000" top>
      {{ snackbarMessage }}
    </v-snackbar>

    <v-dialog v-model="dialog" max-width="350">
      <v-card>
        <div class="verde"></div>
        <h3>Cancelar Evento</h3>
        <p style="text-align: center;">Deseja realmente excluir este evento?</p>
        <v-card-actions class="justify-center">
          <v-btn class="botao-opcao1" @click="confirmarRemocao">Sim</v-btn>
          <v-btn class="botao-opcao1" @click="dialog = false">Não</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import EventoService from '@/services/EventoService';

export default {
  name: 'ListaEventos',
  data() {
    return {
      eventos: [],
      filtro: {
        nome: '',
        data: ''
      },
      headers: [
        { text: 'Nome do Evento', value: 'title' },
        { text: 'Data do Evento', value: 'event_initial_date' },
        { text: 'Opções', value: 'actions', sortable: false }
      ],
      snackbar: false,
      snackbarMessage: '',
      dialog: false,
      eventoSelecionado: null
    };
  },
  methods: {
  async carregarEventos() {
    try {
      const eventosUsuario = await EventoService.listarEventosDoUsuario();
      this.eventos = eventosUsuario;
    } catch (error) {
      this.snackbarMessage = "Erro ao carregar eventos do usuário.";
      this.snackbar = true;
    }
  },

    async buscarEventos() {
      try {
        const response = await EventoService.listarEventosPorFiltro(
          this.filtro.nome,
          this.filtro.data
        );
        this.eventos = response?.data || response || [];
      } catch (error) {
        this.snackbarMessage = 'Erro ao buscar eventos.';
        this.snackbar = true;
      }
    },

    abrirDialog(id) {
      this.eventoSelecionado = id;
      this.dialog = true;
    },

    async confirmarRemocao() {
      try {
        const dataAtual = new Date().toISOString().split('T')[0];
        await EventoService.cancelarEvento(this.eventoSelecionado, { data: dataAtual });
        this.snackbarMessage = 'Evento deletado com sucesso!';
        this.snackbar = true;
        await this.buscarEventos();
      } catch (error) {
        this.snackbarMessage = 'Erro ao deletar evento.';
        this.snackbar = true;
      } finally {
        this.dialog = false;
      }
    },

    irParaDetalhes(id) {
      this.$router.push(`/evento/${id}/detalhes`);
    },

    irParaEditar(id) {
      this.$router.push(`/cadastro-evento/${id}`);
    }
  },

  mounted() {
    this.carregarEventos();
  }
};
</script>

<style scoped>
.title {
  text-align: center;
  margin-bottom: 10px;
}

.botao {
  background-color: #005324 !important;
  color: white !important;
  text-transform: none;
}

.text {
  margin-right: 150px;
}

.botao-opcao,
.botao-opcao1 {
  background-color: #005324 !important;
  color: white !important;
  margin-right: 24px;
  text-transform: none;
}

.botao-opcao1 {
  margin-left: 40px !important;
  margin-bottom: 20px !important;
}

.verde {
  background-color: #005324;
  height: 8px;
  width: 100%;
}

.tabela {
  margin-top: 30px;
  background-color: #e8edee !important;
}

::v-deep(.v-data-table thead th) {
  font-weight: bold !important;
  color: black !important;
  text-align: center !important;
  font-size: 14px !important;
}

::v-deep(.v-data-table tbody td) {
  text-align: center !important;
  padding-bottom: 20px !important;
  padding-top: 20px !important;
}

h3 {
  margin-top: 10px;
  margin-bottom: 15px;
  text-align: center;
}
</style>
