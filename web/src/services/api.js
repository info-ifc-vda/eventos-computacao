import axios from "axios";
import { JWT_TOKEN_KEY } from "@/constants";

const api = axios.create({
  baseURL: process.env.VUE_APP_API_URL || "http://localhost:8082",
});

api.interceptors.request.use(config => {
  const token = localStorage.getItem(JWT_TOKEN_KEY);

  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// async getToken() {
//     return localStorage.getItem(JWT_TOKEN_KEY);
//   },

//   async setToken(token) {
//     localStorage.setItem(JWT_TOKEN_KEY, token);
//   }
//   ,
//   async removeToken() {
//     localStorage.removeItem(JWT_TOKEN_KEY);
//   },
//   async isAuthenticated() {
//     const token = localStorage.getItem(JWT_TOKEN_KEY);
//     console.log(`Verificando autenticação, token: ${token}`);
//     return !!token;
//   }

export default api


