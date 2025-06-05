// src/services/UsuarioService.js
import axios from 'axios';

const API_URL = 'http://localhost:8080/usuario';

export default {

async login(cpf, senha) {
    try {
      const response = await axios.post(`${API_URL}/login`, { cpf, senha });
      return response.data;
    } catch (error) {
      console.error('Erro ao fazer login:', error);
      throw error;
    }
  },

  async cadastrarUsuario(usuario) {
    try {
      const response = await axios.post(API_URL, usuario);
      return response.data;
    } catch (error) {
      console.error('Erro ao cadastrar usuário:', error);
      throw error;
    }
  },

  async listarUsuarios() {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Erro ao listar usuários:', error);
      return [];
    }
  },

  async obterUsuarioPorId(id) {
    try {
      const response = await axios.get(`${API_URL}/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao obter usuário (ID: ${id}):`, error);
      throw error;
    }
  },

  async atualizarUsuario(id, usuario) {
    try {
      const response = await axios.put(`${API_URL}/${id}`, usuario);
      return response.data;
    } catch (error) {
      console.error(`Erro ao atualizar usuário (ID: ${id}):`, error);
      throw error;
    }
  },

  async deletarUsuario(id) {
    try {
      const response = await axios.delete(`${API_URL}/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Erro ao deletar usuário (ID: ${id}):`, error);
      throw error;
    }
  },
};
