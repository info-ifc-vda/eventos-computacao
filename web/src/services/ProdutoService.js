import axios from 'axios';

const API_URL = 'http://localhost:8082/produtos';

export default {
  async criarProduto(produto) {
    try {
      const response = await axios.post(API_URL, produto);
      return response.data;
    } catch (error) {
      console.error('Erro ao criar produto:', error);
      throw error;
    }
  },

  async listarProdutos() {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Erro ao listar produtos:', error);
      return [];
    }
  },

  async deletarProduto(id) {
    try {
      const response = await axios.put(`${API_URL}/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao deletar produto (ID: ${id}):`, error);
      throw error;
    }
  },
  
  async listarProdutosPorFiltro(nome, preco) {
    try {
      const params = {};
      if (nome) params.nome = nome;
      if (preco) params.preco = preco;

      const response = await axios.get(`${API_URL}/filtro`, { params });
      return response.data;
    } catch (error) {
      console.error('Erro ao listar produtos por filtro:', error);
      return [];
    }
  }
};
