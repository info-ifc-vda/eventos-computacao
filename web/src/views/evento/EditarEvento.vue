<template>
    <v-container>
      <h2 class="title"><b>Editar Evento</b> {{ evento.id }}</h2>

      <v-form @submit.prevent="salvarAlteracoes">

        <v-text-field v-model="evento.nome" label="Nome do Evento" disabled></v-text-field>
        <v-text-field v-model="evento.descricao" label="Descrição" disabled></v-text-field>
        <v-text-field v-model="evento.banner" label="Banner" disabled></v-text-field>
        <v-text-field class="texto" v-model="evento.data" label="Data do Evento" type="date"></v-text-field>
        <v-text-field class="texto" v-model="evento.horarioAbertura" label="Horário Abertura" type="time"></v-text-field>
        <v-text-field class="texto" v-model="evento.horarioFechamento" label="Horário Fechamento" type="time"></v-text-field>
        <v-text-field  v-model="evento.dataLimiteConfirmacao" label="Data Limite Confirmação" type="date"></v-text-field>
        <v-text-field v-model="evento.local" label="Local" disabled></v-text-field>
        <v-text-field v-model="evento.linkGoogleMaps" label="Link Google Maps" disabled></v-text-field>
        <v-text-field v-model="evento.valorEstimadoGastos" label="Valor Estimado Gastos" prefix="R$" disabled></v-text-field>
        <v-text-field class="texto" v-model="evento.dataLimitePagamento" label="Data Limite Pagamento" type="date"></v-text-field>
        <v-text-field v-model="evento.natureza" label="Natureza do Evento" disabled></v-text-field>
  
        <v-btn class="botao" type="submit">Salvar Alterações</v-btn>
        
      </v-form>
  
      <v-snackbar v-model="snackbar" :timeout="3000" top>
        {{ snackbarMessage }}
      </v-snackbar>
    </v-container>
  </template>
  
  <script>
  import EventoService from '../../services/EventoService.js';
  
  export default {
    data() {
      return {
        evento: {
          id: null,
          nome: '',
          descricao: '',
          banner: '',
          data: '',
          horarioAbertura: '',
          horarioFechamento: '',
          dataLimiteConfirmacao: '',
          local: '',
          linkGoogleMaps: '',
          valorEstimadoGastos: '',
          dataLimitePagamento: '',
          natureza: ''
        },
        snackbar: false,
        snackbarMessage: ''
      };
    },
    created() {
      this.carregarEvento();
    },
    methods: {
      carregarEvento() {
        const id = this.$route.params.id;
        EventoService.obterEventoPorId(id)
          .then(data => {
            this.evento = data;
          })
          .catch(() => {
            this.snackbarMessage = 'Erro ao carregar evento.';
            this.snackbar = true;
          });
      },
      salvarAlteracoes() {
        EventoService.atualizarEvento(this.evento.id, this.evento)
          .then(() => {
            this.snackbarMessage = 'Evento atualizado com sucesso!';
            this.snackbar = true;
            this.$router.push('/eventos');
          })
          .catch(() => {
            this.snackbarMessage = 'Erro ao atualizar evento.';
            this.snackbar = true;
          });
      }
    }
  };
  </script>
  
<style scoped>
  .container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
  }

  .title {
    text-align: center;
    margin-bottom: 20px;
  }

  .botao {
    background-color: #005324 !important;
    color: white !important;
    margin-top: 20px;
    text-transform: none;
    display: block;
    margin-left: auto;
    margin-right: auto;
  }

  .texto{
    margin-top: 10px;
    margin-bottom: 10px;
  }
  
</style>
  