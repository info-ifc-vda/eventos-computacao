const { defineConfig } = require("@vue/cli-service");
const path = require('path');

// Carrega variáveis de ambiente
require('dotenv').config();

module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    host: '0.0.0.0',  // Necessário para Docker
    port: 9001,
    allowedHosts: "all",
    proxy: {
      '/api': {
        // Usa variável de ambiente ou fallback para desenvolvimento local
        target: process.env.VUE_APP_API_URL || 'http://localhost:8082',
        changeOrigin: true,
        secure: false,
        pathRewrite: {
          '^/api': '',
        },
        // Logs para debug
        onProxyReq: (proxyReq, req, res) => {
          console.log(`Proxying ${req.method} ${req.url} to ${proxyReq.path}`);
        }
      },
    },
  },
  configureWebpack: {
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'src')
      }
    }
  }
});