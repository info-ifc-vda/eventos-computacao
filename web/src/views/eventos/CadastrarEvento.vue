<template>
  <a-container>
    <v-form ref="form" v-model="valid" lazy-validation>
      <h2 style="margin-left: 0;">Cadastro de Evento</h2>
      <h3 style="text-align: left; margin-top: 20px;">Sobre o evento</h3>
      <v-row>
        <v-col cols="12" md="6">
          <v-text-field 
            v-model="evento.title" 
            label="Nome do Produto" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="3">
          <v-file-input
            v-model="evento.banner.data"
            label="Banner"
            accept="image/*"
            :rules="[v => !!v || 'Selecione uma imagem!']"
            append-icon="mdi-tray-arrow-up"  
            prepend-icon=""
            required
          />
        </v-col>
        <v-col cols="12" md="3">
          <v-select
            v-model="evento.public_event"
            :items="tipoOptions"
            label="Tipo"
            :rules="[v => !!v || 'Selecione o tipo do evento']"
            required
          />
        </v-col>
      </v-row>
      <div v-for="(periodo, i) in evento.event_periods" :key="i">
  <v-row>
    <v-col cols="12" md="4">
      <v-text-field 
        v-model="periodo.date" 
        label="Data" 
        type="date"
        :rules="[v => !!v || 'Este campo é obrigatório']" 
        required
      />
    </v-col>
   <v-col cols="12" md="3">
    <v-text-field 
      v-model="periodo.opening_time" 
      label="Horário de início"
      type="text"
      placeholder="00:00:00"
      v-mask="'##:##:##'"
      :rules="[
        v => !!v || 'Este campo é obrigatório',
        v => /^\d{2}:\d{2}:\d{2}$/.test(v) || 'Formato inválido (HH:mm:ss)'
      ]"
      required
    />
  </v-col>
  <v-col cols="12" md="3">
    <v-text-field 
      v-model="periodo.closing_time" 
      label="Horário de fim"
      type="text"
      placeholder="00:00:00"
      v-mask="'##:##:##'"
      :rules="[
        v => !!v || 'Este campo é obrigatório',
        v => /^\d{2}:\d{2}:\d{2}$/.test(v) || 'Formato inválido (HH:mm:ss)'
      ]"
      required
    />
  </v-col>
    <v-col cols="12" md="2" class="d-flex align-center align-items-center">
      <v-btn icon @click="addSessao" v-if="i === evento.event_periods.length - 1" style="margin: 0 auto;">
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </v-col>
  </v-row>
</div>
      <v-row>
        <v-col cols="12" md="12">
          <v-textarea 
            v-model="evento.description" 
            label="Descrição" 
            :rows="1" 
            auto-grow
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
      </v-row>
      <h3 style="text-align: left; margin-top: 20px;">Localização</h3>
      <v-row>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.location.address.city" 
            label="Cidade" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="2">
          <v-select
            v-model="evento.location.address.state"
            :items="localizacaoEstadoOptions"
            label="Estado"
            :rules="[v => !!v || 'Este campo é obrigatório']"
            required
          />
        </v-col>
        <v-col cols="12" md="3">
          <v-text-field
            v-model="evento.location.address.zip_code"
            label="CEP"
            maxlength="9"
            placeholder="00000-000"
            v-mask="'#####-###'"
            :rules="[
              v => !!v || 'Este campo é obrigatório',
              v => /^\d{5}-?\d{3}$/.test(v) || 'CEP inválido'
            ]"
            required
          />
        </v-col>
        <v-col cols="12" md="3">
          <v-text-field 
            v-model="evento.location.address.neighborhood" 
            label="Bairro" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="6">
          <v-text-field 
            v-model="evento.location.address.street" 
            label="Rua" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="2">
          <v-text-field 
            v-model="evento.location.address.number" 
            label="Número"
            type="number" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.location.address.complement" 
            label="Complemento" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="12">
          <v-text-field 
            v-model="evento.location.maps_link" 
            label="Link do Google Maps" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
      </v-row>
      <h3 style="text-align: left; margin-top: 20px;">Detalhes</h3>
      <v-row>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.subscription_deadline" 
            label="Data limite para inscrições" 
            type="date"
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.payment_deadline" 
            label="Data limite para pagamento (após o evento)" 
            type="date"
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.estimated_value" 
            label="Valor estimado de gastos" 
            type="number"
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.bank_details.bank" 
            label="Banco para pagamento" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.bank_details.holder" 
            label="Titular da conta" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.bank_details.pix_key" 
            label="Chave PIX" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
      </v-row>
    </v-form>
    <a-container>
      <v-row justify="center">
        <v-col cols="auto">
          <v-btn
            @click="adicionarEvento"
            :loading="buttonLoading"
            color="#388E3C"
            class="white--text"
          >
            Cadastrar
          </v-btn>
        </v-col>
      </v-row>
    </a-container>
    <v-snackbar v-model="snackbarErro" color="red">
      {{ mensagemErro }}
    </v-snackbar>
    <v-snackbar v-model="snackbarSucesso" color="green">
      {{ mensagemSucesso }}
    </v-snackbar>
  </a-container>
</template>

<script>
import EventoService from '@/services/EventoService';

export default {
  name: "CadastroEvento",
  data() {
    return {
      valid: false,
      evento: {
        title: "",
        banner: { 
          data: null,
        },
        tipo: null,
        description: "",
        subscription_deadline: null,
        payment_deadline: null,
        estimated_value: null,
        location: {
          maps_link: null,
          address: {
            state: null,
            city: null,
            neighborhood: null,
            zip_code: null,
            street: null,
            number: null,
            complement: null,
          }
        },
        event_periods: [
          {
            date: null,
            opening_time: null,
            closing_time: null,
          }
        ],
        bank_details: {
            bank: null,
            holder: null,
            pix_key: null,
        },
      },
      tipoOptions: [
        "Público",
        "Privado"
      ],
      localizacaoEstadoOptions: [
        "AC", // Acre
        "AL", // Alagoas
        "AP", // Amapá
        "AM", // Amazonas
        "BA", // Bahia
        "CE", // Ceará
        "DF", // Distrito Federal
        "ES", // Espírito Santo
        "GO", // Goiás
        "MA", // Maranhão
        "MT", // Mato Grosso
        "MS", // Mato Grosso do Sul
        "MG", // Minas Gerais
        "PA", // Pará
        "PB", // Paraíba
        "PR", // Paraná
        "PE", // Pernambuco
        "PI", // Piauí
        "RJ", // Rio de Janeiro
        "RN", // Rio Grande do Norte
        "RS", // Rio Grande do Sul
        "RO", // Rondônia
        "RR", // Roraima
        "SC", // Santa Catarina
        "SP", // São Paulo
        "SE", // Sergipe
        "TO"  // Tocantins
      ],
      buttonLoading: false,
      mensagemErro: "",
      mensagemSucesso: "",
      snackbarErro: false,
      snackbarSucesso: false,
    };
  },
  methods: {
    addSessao() {
      this.evento.event_periods.push({
        date: null,
        opening_time: null,
        closing_time: null
      });
    },

    async adicionarEvento() {
    if (!this.$refs.form.validate()) {
      this.mensagemErro = "Preencha todos os campos obrigatórios!";
      this.snackbarErro = true;
      return;
    }

    if (this.evento.banner) {
      try {
        const bannerBase64 = await this.convertToBase64(this.evento.banner.data);
        this.evento.banner.data = bannerBase64;
        console.log(this.evento.banner);
      } catch (error) {
        console.error("Erro ao converter imagem para Base64", error);
        this.mensagemErro = "Erro ao processar a imagem! Tente novamente.";
        this.snackbarErro = true;
        return;
      }
    }

    this.buttonLoading = true;
    try {
      await EventoService.criarEvento(this.evento);
      this.mensagemSucesso = "Evento cadastrado com sucesso!";
      this.snackbarSucesso = true;
      // this.limparFormulario();
    } catch (error) {
      console.error("Erro ao cadastrar produto", error);
      this.mensagemErro = "Erro ao cadastrar produto! Tente novamente.";
      this.snackbarErro = true;
    } finally {
      this.buttonLoading = false;
    }
  },

  convertToBase64(file) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onload = () => resolve(reader.result);
      reader.onerror = (error) => reject(error);
      reader.readAsDataURL(file);
    });
  },

    limparFormulario() {
      this.evento = {
        title: "",
        banner: { 
          data: null,
        },
        public_event: null,
        description: "",
        subscription_deadline: null,
        payment_deadline: null,
        estimated_value: null,
        bank_details: {
          bank: null,
          holder: null,
          pix_key: null,
        },
        location: {
          maps_link: null,
          address: {
            state: null,
            city: null,
            neighborhood: null,
            zip_code: null,
            street: null,
            number: null,
            complement: null,
          }
        },
         event_periods: [
          {
            date: null,
            opening_time: null,
            closing_time: null,
          }
        ],
      };
      this.$refs.form.resetValidation();
    }
  },
};
</script> 
<style scoped>
  .container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
  }
  .title {
    text-align: center;
  }
</style>
