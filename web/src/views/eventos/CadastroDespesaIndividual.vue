<template>
    <Fragment>
        <v-col class="custom-border" style="margin-top: 20px;">
            <v-row>
                <v-col cols="12">
                    <div class="title-container" :style="titleContainerStyle">
                        <h2>Cadastrar Despesa Individual</h2>
                    </div>
                </v-col>

                <v-col cols="12" md="6">
                    <v-text-field v-model="titulo" label="Título da Despesa" placeholder="Ex: Compra de pão" />
                </v-col>

                <v-col cols="12" md="3">
                    <v-text-field v-model="valor" label="Valor Total da Despesa" type="number" step="0.01" />
                </v-col>

                <v-col cols="12" md="3">
                    <v-text-field v-model="valorConfirm" label="Confirmar Valor" type="number" step="0.01" />
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="chave" label="Chave de Acesso" />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="12">
                    <div class="image-upload" @click="$refs.uploadInput.click()"
                        style="cursor: pointer; display: flex; flex-direction: column; align-items: center;">
                        <v-avatar size="140" class="upload-avatar" color="#E0E0E0">
                            <v-icon large color="#757575">mdi-cloud-upload</v-icon>
                        </v-avatar>
                        <span style="margin-top: 8px; color: #555;">Clique para enviar imagem</span>
                        <input ref="uploadInput" type="file" accept="image/*" style="display: none"
                            @change="handleFileUpload" />
                    </div>
                    <v-img v-if="imagePreview" :src="imagePreview" class="image-upload-preview" max-height="200"
                        max-width="200" contain style="margin-top: 12px; border-radius: 8px;" />
                </v-col>
                <v-col cols="12">
                    <v-btn block color="#757575" type="button" @click="registrarDespesa">
                        Registrar Despesa
                    </v-btn>
                </v-col>
            </v-row>
        </v-col>
    </Fragment>
</template>

<script>
import { Fragment } from "vue-frag";
import despesaService from '@/services/DespesaService.js';

export default {
    name: "CadastroDespesaIndividual",
    components: {
        Fragment,
    },
    data() {
        return {
            idEvento: null,
            titulo: "",
            valor: "",
            valorConfirm: "",
            chave: "",
            imagePreview: null,
            titleContainerStyle: {
                backgroundColor: "#E0E0E0",
                padding: "10px",
                borderRadius: "8px",
                textAlign: "center",
                marginBottom: "20px",
            },
            snackbar: false,
            snackbarMessage: "",
            dialog: false,
            dialogMessage: "Deseja realmente excluir este evento?",
            dialogTitle: "Cancelar Evento",
            dialogConfirmText: "Sim",
            dialogCancelText: "Não",
            dialogConfirmAction: this.confirmarRemocao,
            dialogCancelAction: () => {
                this.dialog = false;
            },
            dialogStyle: {
                backgroundColor: "#E0E0E0",
                padding: "20px",
                borderRadius: "8px",
                textAlign: "center",
            },
            dialogActionsStyle: {
                justifyContent: "center",
            },
            dialogTitleStyle: {
                color: "#333",
                fontSize: "20px",
                marginBottom: "10px",
            },
            dialogMessageStyle: {
                color: "#555",
                fontSize: "16px",
                marginBottom: "20px",
            },
            dialogButtonStyle: {
                backgroundColor: "#005324",
                color: "#fff",
                textTransform: "none",
                margin: "0 10px",
            },
            dialogButtonCancelStyle: {
                backgroundColor: "#757575",
                color: "#fff",
                textTransform: "none",
                margin: "0 10px",
            },
            dialogButtonConfirmStyle: {
                backgroundColor: "#005324",
                color: "#fff",
                textTransform: "none",
                margin: "0 10px",
            },
            dialogButtonTextStyle: {
                fontSize: "16px",
                fontWeight: "bold",
            },
            dialogButtonCancelTextStyle: {
                fontSize: "16px",
                fontWeight: "bold",
            },
            dialogButtonConfirmTextStyle: {
                fontSize: "16px",
                fontWeight: "bold",
            },      
        };
    },
    mounted() {
        this.idEvento = this.$route.params.id;
    },
    methods: {
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        async registrarDespesa() {
            if (!this.titulo || !this.valor || !this.valorConfirm || !this.chave) {
                window.alert("Por favor, preencha todos os campos.");
                return;
            }

            if (this.valor !== this.valorConfirm) {
                window.alert("Os valores não coincidem.");
                return;
            }

            if (!this.imagePreview) {
                window.alert("Por favor, envie uma imagem.");
                return;
            }

            const payload = {
                id: this.idEvento,
                description: this.titulo,
                unit_value: parseFloat(this.valor),
                quantity: 1,
                total_value: parseFloat(this.valor),
            };

            try {
                await despesaService.criarDespesa(this.idEvento, payload);
                window.alert("Despesa registrada com sucesso!");
                this.$router.push(`/evento/${this.idEvento}/detalhes`);
            } catch (error) {
                window.alert("Erro ao registrar a despesa. Tente novamente.");
                console.error("Erro:", error);
            }
        },
    },
};
</script>

<style scoped>
.custom-border {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 20px;
    background-color: #fff;
}

.title-container {
    text-align: center;
    margin-bottom: 20px;
}

.image-upload {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    margin-bottom: 20px;
}

.image-upload-preview {
    margin-top: 20px;
    max-width: 400px;
    max-height: 400px;
    border-radius: 8px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    object-fit: contain;
}
</style>
