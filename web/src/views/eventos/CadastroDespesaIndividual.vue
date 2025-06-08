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
                    <v-btn block color="#757575" @click="registrarDespesa">
                        Registrar Despesa
                    </v-btn>
                </v-col>
            </v-row>
        </v-col>
    </Fragment>
</template>

<script>
import { Fragment } from "vue-frag";

export default {
    name: "CadastroDespesaIndividual",
    components: {
        Fragment,
    },
    data() {
        return {
            titulo: "",
            valor: "",
            valorConfirm: "",
            chave: "",
            imagePreview: null,
        };
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

        registrarDespesa() {
            if (!this.titulo || !this.valor || !this.valorConfirm || !this.chave) {
                this.$alert("Por favor, preencha todos os campos.");
                return;
            }
            if (this.valor !== this.valorConfirm) {
                this.$alert("Os valores não coincidem.");
                return;
            }

            if (!this.imagePreview) {
                this.$alert("Por favor, envie uma imagem.");
                return;
            }

            const payload = {
                titulo: this.titulo,
                valor: this.valor,
                chave: this.chave,
                imagemBase64: this.imagePreview,
            };
            console.log("Payload para enviar:", payload);
            this.$alert("Despesa registrada com sucesso!");
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
