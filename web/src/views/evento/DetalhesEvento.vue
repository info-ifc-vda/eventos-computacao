<template>
  <v-container>
    <v-row justify="center">
      <v-col cols="12" md="6">
        <h3 class="text-center my-8">Detalhes do Evento</h3>

        <v-divider></v-divider>

        <v-row class="align-center justify-space-between my-7 mx-1">
          <span>Convidar previamente para o Evento</span>
          <v-btn style="text-transform: none;" color="#005324" dark @click="enviarConvites">
            Enviar Convites
          </v-btn>
        </v-row>

        <v-divider></v-divider>

        <v-row class="align-center justify-space-between my-7 mx-1">
          <span>Enviar Lembrete para Confirmação de Presença</span>
          <v-btn style="text-transform: none;" color="#005324" dark @click="enviarLembrete">
            Enviar Lembrete
          </v-btn>
        </v-row>

        <v-divider></v-divider>

        <v-row class="align-center justify-space-between my-7 mx-1">
          <span>Realizar Cadastro de Despesas Individuais</span>
          <v-btn style="text-transform: none;" color="#005324" dark @click="cadastrarDespesaIndividual">
            Cadastrar Despesas
          </v-btn>
        </v-row>

        <v-divider></v-divider>

        <v-row class="align-center justify-space-between my-7 mx-1">
          <span>Gerenciar Despesas do Evento</span>
          <v-btn style="text-transform: none;" color="#005324" dark @click="gerenciarDespesas">
            Gerenciar Despesas
          </v-btn>
        </v-row>

        <v-divider></v-divider>

        <v-row class="align-center justify-space-between my-7 mx-1">
          <span>Lista de Presença nos Dias do Evento</span>
          <v-btn style="text-transform: none;" color="#005324" dark @click="visualizarPresencas">
            Ver Lista
          </v-btn>
        </v-row>

        <v-divider></v-divider>

        <v-row class="align-center justify-space-between my-7 mx-1">
          <span>Cobrar taxa dos participantes e Finalizar o Evento</span>
          <v-btn style="text-transform: none;" color="#005324" dark @click="cobrarFinalizar">
            Cobrança e Finalização
          </v-btn>
        </v-row>

        <v-divider></v-divider>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  computed: {
    eventoId() {
      return this.$route.params.id;
    }
  },
  methods: {
    enviarConvites() {
      this.$router.push(`/evento/${this.eventoId}/enviar-convites`);
    },
    enviarLembrete() {
      this.$router.push(`/evento/${this.eventoId}/enviar-lembrete`);
    },
    cadastrarDespesaIndividual() {
      this.$router.push(`/evento/${this.eventoId}/cadastro-despesa-individual`);
    },
    gerenciarDespesas() {
      this.$router.push(`/evento/${this.eventoId}/gerenciar-despesas`);
    },
    visualizarPresencas() {
      this.$router.push(`/evento/${this.eventoId}/visualizar-presencas`);
    },

    cobrarFinalizar() {
      this.$router.push(`/evento/${this.eventoId}/cobrar-finalizar`);
    }
  }
};
</script>

<style scoped>
h3 {
  margin-bottom: 16px;
  font-weight: bold;
}
</style>
