<template>
  <v-container>
    <h2 class="title">Lista de Eventos</h2>
    <v-row>
      <v-col>
        <v-text-field v-model="filtro.nome" class="text" label="Filtrar por Nome"></v-text-field>
      </v-col>
      <v-col>
        <v-text-field v-model="filtro.data"  class="text" type="date"></v-text-field>
      </v-col>
      <v-btn class="botao" @click="buscarEventos">Buscar</v-btn>
    </v-row>
   
    <v-data-table class="tabela" v-if="eventos.length" :headers="headers" :items="eventos" item-key="id">
      <template v-slot:item="{ item }">
        <tr :key="item.id">
          <td>{{ item.nome }}</td>
          <td>{{ item.data }}</td>
          <td>
            <v-btn color="botao-opcao" small @click="irParaDetalhes(item.id)">Detalhes</v-btn>
            <v-btn color="botao-opcao" small @click="$router.push(`/evento/${item.id}/editar`)">Editar</v-btn>
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

            <p style="text-align: center;">Deseja realmente excluir este evento? </p>

            <v-card-actions class="justify-center">
                <v-btn class="botao-opcao1" @click="confirmarRemocao">Sim</v-btn>
                <v-btn class="botao-opcao1" @click="dialog=false">Não</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import EventoService from '../../services/EventoService.js';

export default {
  data() {
    return {
      //eventos teste: [],
      eventos: [
        { id: 1, nome: 'Workshop de Vue.js', data: '2025-06-10' },
        { id: 2, nome: 'Palestra de Inteligência Artificial', data: '2025-06-15' },
        { id: 3, nome: 'Encontro de Programadores', data: '2025-06-20' }
      ],

      filtro: {
        nome: '',
        data: ''
      },
      headers: [
        { text: 'Nome do Evento', value: 'nome' },
        { text: 'Data do Evento', value: 'data' },
        { text: 'Opções', value: 'actions', sortable: false }
      ],
      snackbar: false,
      snackbarMessage: '',
      dialog: false,
      eventoSelecionado: null
    };
  },

  methods: {
    carregarEventos() {
      EventoService.listarEventos()
        .then(response => {
          this.eventos = response;
        })
        .catch(() => {
          this.snackbarMessage = 'Erro ao carregar eventos.';
          this.snackbar = true;
        });
    },
    buscarEventos() {
      EventoService.listarEventosPorFiltro(this.filtro.nome, this.filtro.data)
        .then(response => {
          this.eventos = response;
        })
        .catch(() => {
          this.snackbarMessage = 'Erro ao buscar eventos.';
          this.snackbar = true;
        });
    },

    abrirDialog(id){
        this.eventoSelecionado = id;
        this.dialog = true;
    },

    confirmarRemocao(){
        EventoService.deletarEvento(this.eventoSelecionado)
            .then(() => {
                this.snackbarMessage='Evento deletado com sucesso!';
                this.snackbar = true;
                this.carregarEventos();
            })

            .catch(() => {
                this.snackbarMessage = 'Erro ao deletar evento. ';
                this.snackbar = true;
            })

            .finally(() => {
                this.dialog = false;
            })
    },

    irParaDetalhes(id) {
    this.$router.push(`/evento/${id}/detalhes`);
    },

    irParaEditar(id) {
        this.$router.push(`/evento/${id}/editar`);
    }

  },
 // created() {
   // this.carregarEventos();
 // }
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
  margin-bottom: 10px;
}

.botao{
  background-color: #005324 !important;
  color: white !important;
  margin-top: 24px;
  text-transform: none;
}

.botao:last-child {
  margin-right: 10px;
}

.text{
  margin-right: 150px;
}

.botao-opcao, .botao-opcao1{
  background-color: #005324 !important;
  color: white !important;
  margin-right: 24px;
  text-transform: none;
}

.botao-opcao1{
    margin-left: 40px !important;
    margin-bottom: 20px !important;
}

.botao-opcao:last-child {
  margin-right: 10px !important;
}

.verde {
  background-color: #005324;
  height: 8px;
  width: 100%;
}

.tabela{
    margin-top: 30px;
    background-color: #E8EDEE !important;
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

h3{
    margin-top: 10px;
    margin-bottom: 15px;
    text-align: center;
}

</style>