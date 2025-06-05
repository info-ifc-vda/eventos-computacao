<template>
    <v-col class="custom-border" style="margin-top: 20px;">
        <v-card class="pa-5 custom-card" elevation="2">
            <div class="title-container">
                <h2 class="titulo">Seus Eventos</h2>
            </div>

            <v-row class="mb-4 filtros">
                <v-col cols="12" sm="4">
                    <v-text-field v-model="filtroNome" label="Filtrar por Nome" dense outlined class="campo-filtro" />
                </v-col>

                <v-col cols="12" sm="4">
                    <v-text-field v-model="filtroData" type="date" dense outlined class="campo-filtro" />
                </v-col>

                <v-col cols="12" sm="2">
                    <v-btn color="#005324" dark block class="botao-buscar" @click="filtrarEventos">
                        Buscar
                    </v-btn>
                </v-col>
            </v-row>

            <v-data-table :headers="headers" :items="eventosFiltrados" class="custom-table" dense hide-default-footer>
                <template v-slot:item="{ item }">
                    <tr>
                        <td>{{ item.nome }}</td>
                        <td>{{ item.data }}</td>
                        <td>
                            <v-btn color="#005324" dark small class="botao-cancelar" @click="abrirConfirmacao(item)">
                                Cancelar Participação
                            </v-btn>
                        </td>
                    </tr>
                </template>

            </v-data-table>
        </v-card>

        <v-dialog v-model="showConfirm" max-width="400">
            <v-card>
                <v-card-title class="text-h6">Confirmar Cancelamento</v-card-title>
                <v-card-text>
                    Deseja realmente cancelar a participação no evento
                    <strong>{{ eventoSelecionado?.nome }}</strong>?
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn color="green darken-1" text @click="fecharConfirmacao">Não</v-btn>
                    <v-btn color="red darken-1" text @click="confirmarCancelamento">Sim</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-col>
</template>

<script>
export default {
    name: "CancelarParticipacao",
    props: {
        eventos: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            filtroNome: "",
            filtroData: "",
            showConfirm: false,
            eventoSelecionado: null,
        };
    },
    computed: {
        eventosFiltrados() {
            return this.eventos.filter(evento => {
                const nomeMatch = evento.nome.toLowerCase().includes(this.filtroNome.toLowerCase());
                const dataMatch = this.filtroData ? evento.data === this.filtroData : true;
                return nomeMatch && dataMatch;
            });
        },
        headers() {
            return [
                { text: "Nome do Evento", value: "nome" },
                { text: "Data do Evento", value: "data" },
                { text: "Opções", value: "acao", sortable: false }
            ];
        }
    },
    methods: {
        abrirConfirmacao(evento) {
            this.eventoSelecionado = evento;
            this.showConfirm = true;
        },
        confirmarCancelamento() {
            this.$emit("cancelar-evento", this.eventoSelecionado);
            this.fecharConfirmacao();
        },
        fecharConfirmacao() {
            this.eventoSelecionado = null;
            this.showConfirm = false;
        },
        filtrarEventos() {
            // a filtragem já ocorre no computed
        }
    }
};
</script>

<style scoped>
.custom-card {
    border-radius: 8px;
    background-color: #fff;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px;
}

.titulo {
    font-family: "Poppins", sans-serif;
    font-size: 2rem;
    margin-bottom: 2rem;
    text-align: center;
}

.filtros {
    margin-bottom: 2rem;
}

.custom-table {
    background-color: #E8EDEE;
    font-family: "Nunito", sans-serif;
    border-radius: 8px;
    margin: 0 auto;
    border: 1px solid #ccc;
    text-align: center;
    padding: 20px;
    width: 100%;
}

.v-data-table-header th {
    font-family: "Poppins", sans-serif !important;
    padding: 25px !important;
}

.v-data-table .v-data-table__td {
    padding: 16px !important;
}

.botao-buscar {
    font-family: "Poppins", sans-serif;
}

.botao-cancelar {
    font-family: "Poppins", sans-serif;
    text-transform: none;
    margin: 12px;
}

.custom-border {
    border: 1px solid #352300;
    position: relative;
    padding: 25px 15px 15px 15px;
    border-radius: 8px;
    margin-bottom: 50px;
}

.title-container {
    position: relative;
    text-align: center;
    margin-bottom: 20px;
}
</style>
