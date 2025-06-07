import api, { JWT_TOKEN_KEY } from './api'

const API_URL = '/api/v1';

export default {

  async login(email, senha) {
    try {
      const response = await api.post(`${API_URL}/auth/login`, {
        username: email,
        password: senha,
      });

      const token = response.data.access_token;

      if (token) {
        localStorage.setItem(JWT_TOKEN_KEY, token);
      } else {
        console.warn('Token não encontrado na resposta de login:', response.data);
      }

      return response.data;
    } catch (error) {
      console.error('Erro ao fazer login:', error.response?.data || error);
      throw error;
    }
  },

  async cadastrarUsuario(usuario) {
    try {
      const response = await api.post(`${API_URL}/users`, {
        'name': usuario.nome,
        'email': usuario.email,
        'phone': usuario.telefone,
        'password': usuario.senha,
      });
      return response.data;
    } catch (error) {
      console.error('Erro ao cadastrar usuário:', error);
      throw error;
    }
  },

  async listarUsuarios() {
    try {
      const response = await api.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Erro ao listar usuários:', error);
      return [];
    }
  },

  async obterUsuarioPorId(id) {
    try {
      const response = await api.get(`${API_URL}/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao obter usuário (ID: ${id}):`, error);
      throw error;
    }
  },

  async atualizarUsuario(id, usuario) {
    try {
      const response = await api.put(`${API_URL}/${id}`, usuario);
      return response.data;
    } catch (error) {
      console.error(`Erro ao atualizar usuário (ID: ${id}):`, error);
      throw error;
    }
  },

  async deletarUsuario(id) {
    try {
      const response = await api.delete(`${API_URL}/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao deletar usuário (ID: ${id}):`, error);
      throw error;
    }
  },
};
