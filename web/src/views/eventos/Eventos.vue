<template>
  <v-container fluid style="padding-top: 0;">
    <h2 style="margin-bottom: 30px;">Eventos</h2>

    <v-row justify="center">
      <v-col
        v-for="evento in eventos"
        :key="evento.id"
        cols="12"
        sm="6"
        md="4"
        lg="3"
        class="d-flex"
      >
        <v-card class="mx-auto d-flex flex-column fill-height" outlined>
            <v-img
            :src="evento.bannerUrl"
            width="100%"
            cover
            class="flex-shrink-0"
            style="min-height: 200px; max-height: 200px; object-fit: cover;"
            />

          <v-card-text class="flex-grow-1">
            <div class="text-h6 mb-2">{{ evento.nome }}</div>

            <div v-if="evento.sessoes && evento.sessoes.length">
              <span>{{ formatarData(evento.sessoes[0].data) }}</span>
              <span> - {{ evento.sessoes[0].inicio }}</span>
            </div>
            <div v-else>Sem sessão definida</div>
          </v-card-text>

          <v-card-actions>
            <template v-if="inscricoesAbertas(evento)">
              <v-btn
                block
                color="green darken-2"
                class="white--text"
                @click="inscrever(evento.id)"
              >
                Inscreva-se já!
              </v-btn>
            </template>
            <template v-else>
              <div class="inscricoes-fechadas red--text text-center" style="width: 100%; padding-bottom: 8px;">
                Inscrições encerradas!
              </div>
            </template>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    <v-snackbar v-model="snackbar" :timeout="3000" top>
      {{ snackbarMessage }}
    </v-snackbar>
  </v-container>
</template>

<script>
import EventoService from '@/services/EventoService'; 

export default {
  name: 'ListarEventos',
  data() {
    return {
      eventos: [],
      snackbar: false,
      snackbarMessage: '',
    };
  },
  created() {
    this.carregarEventos();
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

    inscricoesAbertas(evento) {
      if (!evento.dataInscricoes) return false;

      const hoje = new Date();
      hoje.setHours(0, 0, 0, 0);

      const [ano, mes, dia] = evento.dataInscricoes.split('-').map(Number);
      const limite = new Date(ano, mes - 1, dia, 0, 0, 0, 0);

      return limite >= hoje;
    },

    formatarData(isoDate) {
      if (!isoDate) return '';
      const dt = new Date(isoDate);
      return dt.toLocaleDateString('pt-BR', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
      });
    },

    inscrever(eventoId) {
      this.snackbarMessage = `Você clicou em Inscrever-se no evento ${eventoId}.`;
      this.snackbar = true;
    }
  },
};
</script>

<style scoped>
  .v-card {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 10px !important;
    transition: transform 0.2s;
  }
  .v-card:hover {
    transform: scale(1.02);
  }
  .v-btn {
    border-radius: 8px !important;
  }

</style>
