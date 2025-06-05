<template>
  <v-col class="custom-border" style="margin-top: 20px;">
    <v-row justify="center">
      <v-col cols="12" v-if="exibirTitulo">
        <div class="title-container" :style="titleContainerStyle">
          <h2>Registrar-se no Evento</h2>
        </div>
      </v-col>

      <v-col cols="12" md="6">
        <v-form ref="form">
          <v-row class="mb-3" align="center">
            <v-col cols="4" class="text-right">
              <label for="nome">Nome completo:</label>
            </v-col>
            <v-col cols="8">
              <v-text-field
                id="nome"
                v-model="nome"
                dense
                outlined
                hide-details
              />
            </v-col>
          </v-row>

          <v-row class="mb-3" align="center">
            <v-col cols="4" class="text-right">
              <label for="email">E-mail:</label>
            </v-col>
            <v-col cols="8">
              <v-text-field
                id="email"
                v-model="email"
                dense
                outlined
                hide-details
              />
            </v-col>
          </v-row>

          <v-row class="mb-3" align="center">
            <v-col cols="4" class="text-right">
              <label for="telefone">Telefone:</label>
            </v-col>
            <v-col cols="8">
              <v-text-field
                id="telefone"
                v-model="telefone"
                dense
                outlined
                hide-details
              />
            </v-col>
          </v-row>

          <v-row align="center" class="mb-4">
            <v-col cols="12">
              <v-checkbox
                v-model="confirmado"
                label="Confirmo minha participação no evento"
                color="#005324"
              />
            </v-col>
          </v-row>

          <v-btn
            block
            color="#005324"
            dark
            class="text-capitalize"
            @click="registrar"
          >
            Registrar-se
          </v-btn>
        </v-form>
      </v-col>
    </v-row>
  </v-col>
</template>

<script>
export default {
  name: "RegistrarEvento",
  props: {
    ehModal: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      nome: "",
      email: "",
      telefone: "",
      confirmado: false,
      exibirTitulo: true,
      titleContainerStyle: {
        top: this.ehModal ? "-12px" : "-20px",
      },
    };
  },
  watch: {
    ehModal(novoValor) {
      this.titleContainerStyle.top = novoValor ? "-12px" : "-20px";
    },
  },
  methods: {
    registrar() {
      if (this.confirmado) {
        this.$emit("registrado", {
          nome: this.nome,
          email: this.email,
          telefone: this.telefone,
        });
        alert("Registrado com sucesso!");
      } else {
        alert("Por favor, confirme sua participação.");
      }
    },
  },
};
</script>

<style scoped>
.custom-border {
  border: 1px solid #352300;
  position: relative;
  padding: 25px 15px 15px 15px;
  border-radius: 8px;
  margin-bottom: 50px;
}

.title-container {
  position: absolute;
  left: 16px;
  max-width: 260px;
  background: white;
  padding: 0 8px;
  font-family: 'Poppins', sans-serif;
}

.v-btn {
  text-transform: none !important;
  font-family: 'Poppins', sans-serif;
}
</style>
