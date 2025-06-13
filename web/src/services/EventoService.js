import api from './api';

const API_URL = '/api/v1';
const PER_PAGE = 100;


import DespesaService from './DespesaService';

export default {

  async inscreverEvento(eventId, userId) {
    try {
      const response = await api.post(`${API_URL}/events/join`, {
        event_id: eventId,
        user_id: userId
      });

      return response.data;
    } catch (error) {
      console.error('Erro ao inscrever no evento:', error);
      throw error;
    }
  },

  async criarEvento(evento) {
    try {
      const response = await api.post(`${API_URL}/events`, evento);
      return response.data;
    } catch (error) {
      console.error('Erro ao criar evento:', error);
      throw error;
    }
  },

  async listarEventos() {
    try {
      const response = await api.get(`${API_URL}/events`);

      if (!response.data || !response.data.data) {
        throw new Error('Resposta inválida da API: dados ausentes');
      }

      // console.log('Eventos recebidos:', response.data.data);

      const eventoId = response.data.data[0]?.id;
      if (eventoId) {
        // Listar despesas do primeiro evento
        const despesas = await DespesaService.listarDespesas(eventoId);
        console.log('Despesas do primeiro evento:', despesas);
      } else {
        console.warn('Nenhum evento encontrado na resposta.');
      }

      return response.data.data;
    } catch (error) {
      console.error('Erro ao listar eventos:', error);
      return []; // Retorna um array vazio em caso de erro
    }
  },
  async cancelarEvento(id, data) {
    try {
      const response = await api.post(`${API_URL}/events/${id}/cancel`, data);
      return response.data;
    } catch (error) {
      console.error(`Erro ao cancelar evento (ID: ${id}):`, error);
      throw error;
    }
  },

  async deletarEvento(id) {
    try {
      const response = await api.delete(`${API_URL}/events/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao deletar evento (ID: ${id}):`, error);
      throw error;
    }
  },

  async listarEventosDoUsuario() {
    try {
      const response = await api.get(`${API_URL}/events`, {
        params: { meus_eventos: true }
      });
      return response.data.data;
    } catch (error) {
      console.error('Erro ao listar eventos do usuário:', error);
      return [];
    }
  },

  async listarEventosPorFiltro(nome, preco) {
    try {
      const params = {};
      if (nome) params.nome = nome;
      if (preco) params.preco = preco;

      const response = await api.get(`${API_URL}/filtro`, { params });
      return response.data;
    } catch (error) {
      console.error('Erro ao listar eventos por filtro:', error);
      return [];
    }
  },

  async obterEventoPorId(id) {
    try {
      const response = await api.get(`${API_URL}/events/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao obter evento (ID: ${id}):`, error);
      throw error;
    }
  },

  async atualizarEvento(id, evento) {
    try {
      const response = await api.put(`${API_URL}/events/${id}`, evento);
      return response.data;
    } catch (error) {
      console.error(`Erro ao atualizar evento (ID: ${id}):`, error);
      throw error;
    }
  },

  async isParticipante(eventId, userId) {
    try {
      const response = await api.get(`${API_URL}/events/is-participant`, {
        params: {
          event_id: eventId,
          user_id: userId
        }
      });

      return response.data.is_participant;
    } catch (error) {
      console.error(`Erro ao verificar participação no evento (ID: ${eventId}):`, error);
      throw error;
    }
  },

  async getEventLocation(eventId) {
    try {
      const response = await api.get(`${API_URL}/events/${eventId}/location`);
      return response.data.location;
    } catch (error) {
      console.error(`Erro ao obter localização do evento (ID: ${eventId}):`, error);
      throw error;
    }
  },

  async getEventParticipants(eventId) {
    try {
      const response = await api.get(`${API_URL}/events/${eventId}/participants?per_page=${PER_PAGE}`);

      const evento = await this.obterEventoPorId(eventId);
      const participants = response.data.data || [];

      // retornar o evento e seus participantes
      return {
        evento: evento.data,
        participantes: participants
      };

    } catch (error) {
      console.error(`Erro ao obter participantes do evento (ID: ${eventId}):`, error);
      throw error;
    }
  },

  async cancelarInscricaoNoEvento(eventId, userId) {
    try {
      const response = await api.post(`${API_URL}/events/${eventId}/leave`, {
        event_id: eventId,
        user_id: userId
      });

      return response.data;
    } catch (error) {
      console.error('Erro ao cancelar inscrição no evento:', error);
      throw error;
    }
  }

};
