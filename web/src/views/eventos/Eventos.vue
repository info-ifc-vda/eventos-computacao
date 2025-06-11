<template>
  <v-container fluid style="padding-top: 0">
    <h2 style="margin-bottom: 30px">Eventos</h2>
    <v-row justify="center" v-if="carregando">
      <v-col
        v-for="n in 3"
        :key="n"
        cols="12"
        sm="6"
        md="4"
        lg="4"
        class="d-flex"
      >
        <v-skeleton-loader
          class="mx-auto"
          type="card"
          width="100%"
          height="350px"
          elevation="1"
        />
      </v-col>
    </v-row>

    <v-row justify="center" v-else>
      <v-col
        v-for="evento in eventos"
        :key="evento.id"
        cols="12"
        sm="6"
        md="4"
        lg="4"
        class="d-flex"
      >
        <v-card class="mx-auto d-flex flex-column fill-height" outlined>
          <v-img
            :src="evento.banner.url"
            width="100%"
            cover
            class="flex-shrink-0"
            style="min-height: 200px; max-height: 200px; object-fit: cover"
          />

          <v-card-text class="flex-grow-1">
            <div class="text-h6 mb-2">{{ evento.title }}</div>

            <div v-if="evento.sessoes && evento.sessoes.length">
              <span>{{ formatarData(evento.sessoes[0].data) }}</span>
              <span> - {{ evento.sessoes[0].inicio }}</span>
            </div>
            <div v-else>Sem sessão definida</div>
          </v-card-text>
          <v-card-actions>
            <template v-if="evento.inscrito">
              <v-btn block color="grey darken-1" class="white--text" disabled>
                Já inscrito
              </v-btn>
            </template>
            <template v-else-if="inscricoesAbertas(evento)">
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
              <div
                class="inscricoes-fechadas red--text text-center"
                style="width: 100%; padding-bottom: 8px"
              >
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
import EventoService from "@/services/EventoService";
import UsuarioService from "@/services/UsuarioService";

export default {
  name: "ListarEventos",
  data() {
    return {
      eventos: [],
      usuario: null,
      snackbar: false,
      snackbarMessage: "",
      carregando: true,
    };
  },
  async created() {
    this.carregando = true;
    await this.carregarUsuarioLogado();
    await this.carregarEventos();
    this.carregando = false;
  },
  methods: {
    async carregarEventos() {
      try {
        const eventos = await EventoService.listarEventos();

        // Para cada evento, verificar se o usuário está inscrito
        const eventosComStatus = await Promise.all(
          eventos.map(async (evento) => {
            const inscrito = await EventoService.isParticipante(
              evento.id,
              this.usuario.id
            );
            return { ...evento, inscrito };
          })
        );

        this.eventos = eventosComStatus;
      } catch (error) {
        console.log("Erro ao carregar eventos:", error);

        this.snackbarMessage = "Erro ao carregar eventos.";
        this.snackbar = true;
      }
    },

    async usuarioInscrito(evento) {
      const isParticipant = await EventoService.isParticipante(
        evento.id,
        this.usuario.id
      );

      return isParticipant;
    },

    inscricoesAbertas(evento) {
      return !evento.cancelled;
    },

    // A função abaixo foi comentada porque o back não retorna o que precisa

    //comentei porque o back não retorna oque precisa
    // inscricoesAbertas(evento) {
    //   if (!evento.subscription_deadline) return false;

    //   const hoje = new Date();
    //   hoje.setHours(0, 0, 0, 0);

    //   const limite = new Date(evento.subscription_deadline);
    //   limite.setHours(23, 59, 59, 999);
    //   return limite >= hoje;
    // },

    formatarData(isoDate) {
      if (!isoDate) return "";
      const dt = new Date(isoDate);
      return dt.toLocaleDateString("pt-BR", {
        day: "2-digit",
        month: "long",
        year: "numeric",
      });
    },

    async carregarUsuarioLogado() {
      try {
        const response = await UsuarioService.getUsuarioLogado();
        this.usuario = response.data;
      } catch (error) {
        console.error("Erro ao buscar usuário logado:", error);
      }
    },

    async inscrever(eventoId) {
      if (!this.usuario) {
        this.snackbarMessage = "Usuário não autenticado.";
        this.snackbar = true;
        return;
      }

      try {
        await EventoService.inscreverEvento(eventoId, this.usuario.id);
        this.snackbarMessage = "Inscrição no evento realizada com sucesso!";
        this.snackbar = true;
      } catch (error) {
        this.snackbarMessage = "Erro ao inscrever no evento.";
        this.snackbar = true;
      }
    },
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
