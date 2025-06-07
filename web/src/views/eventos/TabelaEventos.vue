<template>
  <section class="table-container">
    <table class="event-table">
      <thead>
        <tr>
          <th>Nome do Evento</th>
          <th>Data do Evento</th>
          <th>Opções</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="evento in eventos"
          :key="evento.nome"
        >
          <td>{{ evento.nome }}</td>
          <td>{{ evento.data }}</td>
          <td>
            <button
              class="btn-cancelar"
              @click="$emit('cancelar', evento)"
            >
              Cancelar Participação
            </button>
          </td>
        </tr>
        <tr v-if="eventos.length === 0">
          <td colspan="3" class="sem-eventos">Nenhum evento encontrado.</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<script>
export default {
  name: 'TabelaEventos',
  props: {
    eventos: {
      type: Array,
      required: true,
      default: () => []
    }
  }
};
</script>

<style scoped>
.table-container {
  max-width: 900px;
  margin: 0 auto;
  overflow-x: auto;
  padding: 16px;
}

.event-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #f8f9fa;
  font-family: 'Poppins', sans-serif;
  border: 1px solid #ccc;
}

thead {
  background-color: #dce4e6;
}

th {
  font-weight: 600;
  padding: 14px;
  border: 1px solid #ccc;
  text-align: center;
}

td {
  padding: 12px;
  border: 1px solid #ccc;
  text-align: center;
}

.sem-eventos {
  font-style: italic;
  color: #888;
  background-color: #f1f1f1;
}

.btn-cancelar {
  background-color: #005324;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.btn-cancelar:hover {
  background-color: #003d1d;
}
</style>
