import api from './api'
import { JWT_REFRESH_TOKEN_KEY, JWT_TOKEN_KEY } from '@/constants';

const API_URL = '/api/v1';

export default {

  async validarToken() {
    try {
      const response = await api.get(`${API_URL}/auth/validate`);
      return response.data;
    } catch (error) {
      console.warn("Token inválido ou expirado.");
      return null;
    }
  },

  async logout() {
    try {
      localStorage.removeItem(JWT_TOKEN_KEY);
      localStorage.removeItem(JWT_REFRESH_TOKEN_KEY);

      await api.get(`${API_URL}/auth/logout`);

      return true;
    } catch (error) {
      console.error('Erro ao fazer logout:', error.response?.data || error);
      throw error;
    }
  },

  async refresh() {
    try {
      const response = await api.post(`${API_URL}/auth/refresh`, {
        refresh_token: localStorage.getItem(JWT_REFRESH_TOKEN_KEY),
      })
      console.log('Token atualizado com sucesso:', response.data);

      const { access_token, refresh_token } = response.data

      if (access_token && refresh_token) {
        localStorage.setItem(JWT_TOKEN_KEY, access_token);
        localStorage.setItem(JWT_REFRESH_TOKEN_KEY, refresh_token);
      }
      else {
        console.warn('Tokens não encontrados na resposta de refresh:', response.data);
        throw new Error('Tokens não encontrados na resposta de refresh');
      }

      return response.data;
    } catch (error) {
      console.error('Erro ao atualizar token:', error.response?.data || error);
      throw error;
    }
  },


  async login(email, senha) {
    try {
      const response = await api.post(`${API_URL}/auth/login`, {
        username: email,
        password: senha,
      });

      const { access_token, refresh_token } = response.data;

      if (access_token && refresh_token) {
        localStorage.setItem(JWT_TOKEN_KEY, access_token);
        localStorage.setItem(JWT_REFRESH_TOKEN_KEY, refresh_token);
      } else {
        console.warn('Token não encontrado na resposta de login:', response.data);
        throw new Error('Token não encontrado na resposta de login');
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

async getUsuarioLogado() {
  try {
    const response = await api.get(`${API_URL}/users/me`);
    return response.data;
  } catch (error) {
    console.error("Erro ao buscar usuário logado:", error);
    throw error;
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
