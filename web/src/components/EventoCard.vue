<template>
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
      <template v-if="inscrito">
        <v-btn block color="grey darken-1" class="white--text" disabled>
          Já inscrito
        </v-btn>
      </template>
      <template v-else-if="inscricoesAbertas">
        <v-btn
          block
          color="green darken-2"
          class="white--text"
          @click="$emit('inscrever')"
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
</template>

<script>
export default {
  name: "EventoCard",
  props: {
    evento: {
      type: Object,
      required: true,
    },
    inscrito: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    inscricoesAbertas() {
      return !this.evento.cancelled;
    },
  },
  methods: {
    formatarData(isoDate) {
      if (!isoDate) return "";
      const dt = new Date(isoDate);
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
