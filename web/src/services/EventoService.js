import axios from 'axios';

const API_URL = 'http://localhost:8080/evento';

export default {
  async criarEvento(evento) {
    try {
      const response = await axios.post(API_URL, evento);
      return response.data;
    } catch (error) {
      console.error('Erro ao criar evento:', error);
      throw error;
    }
  },

  async listarEventos() {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Erro ao listar eventos:', error);
      return [];
    }
  },

  async deletarEvento(id) {
    try {
      const response = await axios.put(`${API_URL}/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao deletar evento (ID: ${id}):`, error);
      throw error;
    }
  },

  async listarEventosPorFiltro(nome, preco) {
    try {
      const params = {};
      if (nome) params.nome = nome;
      if (preco) params.preco = preco;

      const response = await axios.get(`${API_URL}/filtro`, { params });
      return response.data;
    } catch (error) {
      console.error('Erro ao listar eventos por filtro:', error);
      return [];
    }
  },

  async obterEventoPorId(id) {
    try {
      const response = await axios.get(`${API_URL}/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao obter evento (ID: ${id}):`, error);
      throw error;
    }
  },


  async atualizarEvento(id, evento) {
    try {
      const response = await axios.put(`${API_URL}/${id}`, evento);
      return response.data;
    } catch (error) {
      console.error(`Erro ao atualizar evento (ID: ${id}):`, error);
      throw error;
    }
  }
};
