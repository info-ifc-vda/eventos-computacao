<template>
  <v-container>
    <h2 class="text-center my-6">Participantes do Evento</h2>

    <v-row>
      <v-col cols="12" md="5">
        <v-card outlined>
          <v-card-title>Informações do Evento</v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-skeleton-loader
              v-if="carregando"
              type="paragraph, text, text, text"
            ></v-skeleton-loader>
            <div v-else class="text-left">
              <div><strong>Título:</strong> {{ evento.title }}</div>
              <div><strong>Descrição:</strong> {{ evento.decription }}</div>
              <div v-if="evento.event_periods && evento.event_periods.length">
                <strong>Data:</strong>
                {{ formatarData(evento.event_periods[0].date) }},
                {{ evento.event_periods[0].opening_time }} -
                {{ evento.event_periods[0].closing_time }}
              </div>
              <div v-if="evento.location">
                <strong>Local:</strong> {{ evento.location.address.street }},
                {{ evento.location.address.number }},
                {{ evento.location.address.city }} -
                {{ evento.location.address.state }}
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="7">
        <v-card outlined>
          <v-card-title>Participantes</v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <v-skeleton-loader
              v-if="carregando"
              type="table-heading, table-row, table-row, table-row"
            ></v-skeleton-loader>
            <v-simple-table v-else class="striped-table" dense>
              <thead>
                <tr>
                  <th class="text-left">Nome</th>
                  <th class="text-left">Email</th>
                  <th class="text-left">Telefone</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="p in participantes" :key="p.id">
                  <td>{{ p.user.name }}</td>
                  <td>{{ p.user.email }}</td>
                  <td>
                    {{
                      p.user.phone
                        ? p.user.phone.replace(
                            /(\d{2})(\d{5})(\d{4})/,
                            "($1) $2-$3"
                          )
                        : "N/A"
                    }}
                  </td>
                </tr>
                <tr v-if="participantes.length === 0">
                  <td colspan="3" class="text-center text-grey">
                    Nenhum participante encontrado.
                  </td>
                </tr>
              </tbody>
            </v-simple-table>
          </v-card-text>
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

export default {
  name: "VisualizarParticipantes",
  data() {
    return {
      eventoId: null,
      evento: {},
      participantes: [],
      snackbar: false,
      snackbarMessage: "",
      carregando: true, // nova propriedade
    };
  },
  async created() {
    this.eventoId = this.$route.params.id;
    await this.carregarDados();
  },
  methods: {
    async carregarDados() {
      try {
        const response = await EventoService.getEventParticipants(
          this.eventoId
        );
        this.participantes = response.participantes;
        this.evento = response.evento;
      } catch (error) {
        console.error("Erro ao carregar dados do evento:", error);
        this.snackbarMessage = "Erro ao carregar dados do evento.";
        this.snackbar = true;
      } finally {
        this.carregando = false; // finaliza o loading
      }
    },
    formatarData(isoDate) {
      if (!isoDate) return "";
      const [year, month, day] = isoDate.split("-");
      const dt = new Date(year, month - 1, day);
      return dt.toLocaleDateString("pt-BR", {
        day: "2-digit",
        month: "long",
        year: "numeric",
      });
    },
  },
};
</script>

<style scoped>
.striped-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}
.striped-table tbody tr:nth-child(even) {
  background-color: #f5f5f5;
}
.striped-table th {
  background-color: #e0e0e0;
  font-weight: bold;
}
</style>
