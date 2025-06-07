<template>
  <a-container>
    <v-form ref="form" v-model="valid" lazy-validation>
      <h2 style="margin-left: 0;">Cadastro de Evento</h2>
      <h3 style="text-align: left; margin-top: 20px;">Sobre o evento</h3>
      <v-row>
        <v-col cols="12" md="6">
          <v-text-field 
            v-model="evento.nome" 
            label="Nome do Produto" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="3">
          <v-file-input
            v-model="evento.banner"
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
            v-model="evento.tipo"
            :items="tipoOptions"
            label="Tipo"
            :rules="[v => !!v || 'Selecione o tipo do evento']"
            required
          />
        </v-col>
      </v-row>
      <div v-for="(sessao, i) in evento.sessoes" :key="i">
        <v-row>
          <v-col cols="12" md="4">
            <v-text-field 
              v-model="sessao.data" 
              label="Data" 
              type="date"
              :rules="[v => !!v || 'Este campo é obrigatório']" 
              required
            />
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field 
              v-model="sessao.inicio" 
              label="Horário de início" 
              type="time"
              :rules="[v => !!v || 'Este campo é obrigatório']" 
              required
            />
          </v-col>
          <v-col cols="12" md="3">
            <v-text-field 
              v-model="sessao.fim" 
              label="Horário de fim" 
              type="time"
              :rules="[v => !!v || 'Este campo é obrigatório']" 
              required
            />
          </v-col>
          <v-col cols="12" md="2" class="d-flex align-center align-items-center">
            <v-btn icon @click="addSessao" v-if="i === evento.sessoes.length - 1" style="margin: 0 auto;">
              <v-icon>mdi-plus</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </div>
      <v-row>
        <v-col cols="12" md="12">
          <v-textarea 
            v-model="evento.descricao" 
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
            v-model="evento.localizacaoCidade" 
            label="Cidade" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="2">
          <v-select
            v-model="evento.localizacaoEstado"
            :items="localizacaoEstadoOptions"
            label="Estado"
            :rules="[v => !!v || 'Este campo é obrigatório']"
            required
          />
        </v-col>
        <v-col cols="12" md="3">
          <v-text-field
            v-model="evento.localizacaoCep"
            label="CEP"
            maxlength="9"
            placeholder="00000-000"
            :rules="[
              v => !!v || 'Este campo é obrigatório',
              v => /^\d{5}-?\d{3}$/.test(v) || 'CEP inválido'
            ]"
            required
          />
        </v-col>
        <v-col cols="12" md="3">
          <v-text-field 
            v-model="evento.localizacaoBairro" 
            label="Bairro" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="6">
          <v-text-field 
            v-model="evento.localizacaoRua" 
            label="Rua" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="2">
          <v-text-field 
            v-model="evento.localizacaoNumero" 
            label="Número"
            type="number" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.localizacaoComplemento" 
            label="Complemento" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="12">
          <v-text-field 
            v-model="evento.localizacaoMaps" 
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
            v-model="evento.dataInscricoes" 
            label="Data limite para inscrições" 
            type="date"
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.dataPagamento" 
            label="Data limite para pagamento (após o evento)" 
            type="date"
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.valor" 
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
            v-model="evento.pagamentoBanco" 
            label="Banco para pagamento" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.pagamentoTitular" 
            label="Titular da conta" 
            :rules="[v => !!v || 'Este campo é obrigatório']" 
            required
          />
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field 
            v-model="evento.pagamentoPix" 
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
        nome: "Evento de Teste",
        banner: null,
        tipo: null,
        sessoes: [
          { data: null, inicio: null, fim: null }
        ],
        data1: null,
        horarioinicio1: null,
        horariofim1: null,
        descricao: "",
        localizacaoCidade: "",
        localizacaoEstado: null,
        localizacaoCep: "",
        localizacaoBairro: "",
        localizacaoRua: "",
        localizacaoNumero: null,
        localizacaoComplemento: "",
        localizacaoMaps: "",
        dataInscricoes: null,
        dataPagamento: null,
        valor: null,
        pagamentoBanco: "",
        pagamentoTitular: "",
        pagamentoPix: ""
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
      this.evento.sessoes.push({ data: null, inicio: null, fim: null });
    },

    async adicionarEvento() {
      if (!this.$refs.form.validate()) {
        this.mensagemErro = "Preencha todos os campos obrigatórios!";
        this.snackbarErro = true;
        return;
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

    limparFormulario() {
      this.evento = {
        nome: "",
        banner: null,
        tipo: null,
        sessoes: [
          { data: null, inicio: null, fim: null }
        ],
        data1: null,
        horarioinicio1: null,
        horariofim1: null,
        descricao: "",
        localizacaoCidade: "",
        localizacaoEstado: null,
        localizacaoCep: "",
        localizacaoBairro: "",
        localizacaoRua: "",
        localizacaoNumero: null,
        localizacaoComplemento: "",
        localizacaoMaps: "",
        dataInscricoes: null,
        dataPagamento: null,
        valor: null,
        pagamentoBanco: "",
        pagamentoTitular: "",
        pagamentoPix: ""
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
