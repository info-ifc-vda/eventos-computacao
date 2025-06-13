import axios from "axios";
import { JWT_TOKEN_KEY } from "@/constants";

const api = axios.create({
  baseURL: process.env.VUE_APP_API_URL || "http://eventos.fsw-ifc.brdrive.localhost",
});

api.interceptors.request.use(config => {
  const token = localStorage.getItem(JWT_TOKEN_KEY);

  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api


