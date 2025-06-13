<template>
  <v-container v-if="!carregando">
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
              <address v-if="evento.location" style="font-style: normal">
                <strong>Local:</strong><br />
                {{ evento.location.address.street }},
                {{ evento.location.address.number }}<br />
                {{ evento.location.address.city }} -
                {{ evento.location.address.state }}
                {{ evento.location.address.zip_code }}
                {{
                  evento.location.address.complement
                    ? `, ${evento.location.address.complement}`
                    : ""
                }}
                {{
                  evento.location.address.neighborhood
                    ? `, ${evento.location.address.neighborhood}`
                    : ""
                }}
                <br />
                <div
                  v-if="evento.location && evento.location.maps_link"
                  class="mt-4"
                >
                  <iframe
                    :src="gerarEmbedMapa(evento.location.maps_link)"
                    width="100%"
                    height="300"
                    style="border: 1px solid #ccc; border-radius: 8px"
                    allowfullscreen
                    loading="lazy"
                  ></iframe>
                </div>
              </address>
            </div>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="7">
        <v-card outlined>
          <v-card-title class="d-flex justify-space-between align-center">
            Participantes do Evento
            <v-chip color="success">
              {{ participantes.length }} participantes
            </v-chip>
          </v-card-title>
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
import UsuarioService from "@/services/UsuarioService";
import { gerarEmbedMapa, formatarData } from "@/util/formatUtils";

export default {
  name: "VisualizarParticipantes",
  data() {
    return {
      eventoId: null,
      evento: {},
      participantes: [],
      snackbar: false,
      snackbarMessage: "",
      carregando: true,
    };
  },

  async created() {
    this.eventoId = this.$route.params.id;

    const isAdmin = await UsuarioService.isAdmin();
    if (!isAdmin) {
      this.$router.push("/pagina-nao-autorizada");
      return;
    }

    await this.carregarDados();
  },

  methods: {
    gerarEmbedMapa,
    formatarData,
    async carregarDados() {
      try {
        const response = await EventoService.getEventParticipants(
          this.eventoId
        );
        this.evento = response.evento;
        this.participantes = response.participantes || [];

        // sort participants by name and capitalize names
        this.participantes.sort((a, b) =>
          a.user.name.localeCompare(b.user.name)
        );
        this.participantes.forEach((p) => {
          p.user.name = p.user.name
            .split(" ")
            .map((n) => n.charAt(0).toUpperCase() + n.slice(1).toLowerCase())
            .join(" ");
        });
      } catch (error) {
        console.error("Erro ao carregar dados do evento:", error);
        this.snackbarMessage = "Erro ao carregar dados do evento.";
        this.snackbar = true;
      } finally {
        this.carregando = false; // finaliza o loading
      }
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
