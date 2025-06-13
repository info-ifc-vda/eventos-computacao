import api from './api';

const API_URL = '/api/v1';
const PER_PAGE = 100;

export default {
  async criarDespesa(idEvento, despesa) {
    try {
      const response = await api.post(`${API_URL}/events/${idEvento}/expenses`, despesa);
      return response.data;
    } catch (error) {
      console.error('Erro ao criar despesa:', error.response?.data || error);
      throw error;
    }
  },

  async listarDespesas(idEvento) {
    try {
      const response = await api.get(`${API_URL}/events/${idEvento}/expenses?per_page=${PER_PAGE}`);
      return response.data.data || []; // Garantir que sempre retorne um array
    } catch (error) {
      console.error('Erro ao listar despesas:', error.response?.data || error);
      return [];
    }
  },

  async listarDespesasPorFiltro(idEvento, filtros = {}) {
    try {
      const response = await api.get(`${API_URL}/events/${idEvento}/expenses?per_page=${PER_PAGE}`, {
        params: filtros,
      });
      return response.data;
    } catch (error) {
      console.error('Erro ao filtrar despesas:', error.response?.data || error);
      return [];
    }
  },

  async atualizarDespesa(idEvento, idDespesa, despesa) {
    try {
      const response = await api.put(`${API_URL}/events/${idEvento}/expenses/${idDespesa}`, despesa);
      return response.data;
    } catch (error) {
      console.error('Erro ao atualizar despesa:', error.response?.data || error);
      throw error;
    }
  },

  async deletarDespesa(eventId, despesaId) {
    try {
      const response = await api.delete(`${API_URL}/events/${eventId}/expenses/${despesaId}`);
      return response.data;
    } catch (error) {
      console.error('Erro ao deletar despesa:', error);
      throw error;
    }
  }
};