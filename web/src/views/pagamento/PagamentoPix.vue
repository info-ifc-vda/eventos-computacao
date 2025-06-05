<template>
  <v-container class="pa-4">
    <v-card class="pa-4" outlined>
      <v-card-title>
        <h2 class="text-h5">Pagamento via Pix</h2>
      </v-card-title>

      <v-card-text>
        <v-form ref="form" v-model="formValido">
          <v-row dense>
            <v-col cols="12" md="6">
              <v-text-field
                label="Valor total das despesas"
                v-model="form.valorTotal"
                prefix="R$"
                type="number"
                :rules="[v => !!v || 'Campo obrigatório']"
                required
              />
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field
                label="Pagamento Fixo"
                v-model="form.pagamentoFixo"
                prefix="R$"
                type="number"
                :rules="[v => !!v || 'Campo obrigatório']"
                required
              />
            </v-col>

            <v-col cols="12">
              <v-card class="pa-4" outlined>
                <v-row dense>
                  <v-col cols="12" md="4">
                    <v-text-field
                      label="Banco"
                      v-model="form.pix.banco"
                      :rules="[v => !!v || 'Campo obrigatório']"
                      required
                    />
                  </v-col>
                  <v-col cols="12" md="4">
                    <v-text-field
                      label="Titular"
                      v-model="form.pix.titular"
                      :rules="[v => !!v || 'Campo obrigatório']"
                      required
                    />
                  </v-col>
                  <v-col cols="12" md="4">
                    <v-text-field
                      label="Chave Pix"
                      v-model="form.pix.chave"
                      :rules="[v => !!v || 'Campo obrigatório']"
                      required
                    />
                  </v-col>
                </v-row>
              </v-card>
            </v-col>

            <v-col cols="12">
              <v-file-input
                label="Anexe o comprovante Pix"
                v-model="form.comprovante"
                accept=".pdf,image/*"
                show-size
                :rules="[v => !!v || 'Anexe o comprovante']"
                required
              />
            </v-col>

            <v-col cols="12">
              <v-btn
                color="primary"
                block
                class="mt-4"
                @click="enviarPagamento"
              >
                Confirmar Pagamento
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "PagamentoPix",
  data() {
    return {
      formValido: false,
      form: {
        valorTotal: "",
        pagamentoFixo: "",
        pix: {
          banco: "",
          titular: "",
          chave: "",
        },
        comprovante: null,
      },
    };
  },
  methods: {
    enviarPagamento() {
      if (this.$refs.form.validate()) {
        // Aqui você pode enviar os dados para uma API
        alert("Pagamento confirmado com sucesso!");
        console.log("Dados enviados:", this.form);
      } else {
        alert("Preencha todos os campos obrigatórios.");
      }
    },
  },
};
</script>

<style scoped>
</style>
