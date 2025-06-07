import axios from 'axios';

const API_URL = 'http://localhost:/eventos';

export default {
  async criarDespesa(despesa) {
    try {
      const response = await axios.post(API_URL, despesa);
      return response.data;
    } catch (error) {
      console.error('Erro ao criar despesa:', error);
      throw error;
    }
  },

  async listarDespesas() {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Erro ao listar despesas:', error);
      return [];
    }
  },
 
  async listarDespesasPorFiltro(nome, preco) {
    try {
      const params = {};
      if (nome) params.nome = nome;
      if (preco) params.preco = preco;

      const response = await axios.get(`${API_URL}/filtro`, { params });
      return response.data;
    } catch (error) {
      console.error('Erro ao listar despesas por filtro:', error);
      return [];
    }
  },

  async atualizarDespesa(id, despesa) {
    try {
      const response = await axios.put(`${API_URL}/${id}`, despesa);
      return response.data;
    } catch (error) {
      console.error('Erro ao atualizar despesa:', error);
      throw error;
    }
  }

};
