<template>
    <v-container>
      <v-row justify="center" >
        <v-col cols="12" md="6">
            <h3 class="text-center my-8">Evento 1</h3>

            <v-divider></v-divider>

            <v-row class="align-center justify-space-between my-7 mx-1">
            <span>Convidar previamente para o Evento 1</span>
            <v-btn style="text-transform: none;" color="#005324" dark @click="enviarConvites">Enviar Convites</v-btn>
            </v-row>

            <v-divider></v-divider>

            <v-row class="align-center justify-space-between my-7 mx-1">
            <span>Enviar Lembrete para Confirmação de Presença</span>
            <v-btn style="text-transform: none; " color="#005324" dark @click="enviarLembrete">Enviar Lembrete</v-btn>
            </v-row>

            <v-divider></v-divider>

            <v-row class="align-center justify-space-between my-7 mx-1">
            <span>Realizar Cadastro de Despesas Individuais</span>
            <v-btn style="text-transform: none; " color="#005324" dark @click="cadastrarDespesaIndividual">Cadastrar Despesas</v-btn>
            </v-row>

            <v-divider></v-divider>

            <v-row class="align-center justify-space-between my-7 mx-1">
            <p>Gerenciar Despesas do Evento (id evento)</p>
            <v-btn style="text-transform: none; " color="#005324" dark @click="gerenciarDespesas">Gerenciar Despesas</v-btn>
            </v-row>

            <v-divider></v-divider>

            <v-row class="align-center justify-space-between my-7 mx-1">
            <span>Lista de Presença nos Dias do Evento</span>
            <v-btn style="text-transform: none;" color="#005324" dark @click="visualizarPresencas">Ver Lista</v-btn>
            </v-row>

            <v-divider></v-divider>

            <v-row class="align-center justify-space-between my-7 mx-1">
            <span>Cobrar taxa dos participantes e Finalizar o Evento</span>
            <v-btn style="text-transform: none;" color="#005324" dark @click="cobrarFinalizar">Cobrança e Finalização</v-btn>
            </v-row>

            <v-divider></v-divider>
        </v-col>
      </v-row>
  
    </v-container>
  </template>
  
  <script>
    export default {
        methods: {
            enviarConvites() {
            this.$router.push('/evento/enviar-convites')
            },
            enviarLembrete() {
            this.$router.push('/evento/enviar-lembrete')
            },
            cadastrarDespesaIndividual() {
              const idEvento = this.$route.params.id || this.eventoId;
              this.$router.push(`/evento/${idEvento}/cadastro-despesa-individual`);
            },
            gerenciarDespesas() {
            this.$router.push('/evento/gerenciar-despesas')
            },
            visualizarPresencas() {
            this.$router.push('/evento/visualizar-presencas')
            },
            cobrarFinalizar() {
            this.$router.push('/evento/cobrar-finalizar')
            }
        }
    }

  </script>

<style scoped>
h3 {
  margin-bottom: 16px;
  font-weight: bold;
}
</style>

