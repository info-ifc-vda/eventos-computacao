const { defineConfig } = require("@vue/cli-service");
const path = require('path');

// Carrega variáveis de ambiente
require('dotenv').config();

module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    host: '0.0.0.0',
    port: 9001,
    allowedHosts: "all",
    proxy: {
      '/api': {
        target: process.env.VUE_APP_API_URL || 'http://localhost:8082',
        changeOrigin: true,
        secure: false,
        pathRewrite: { '^/api': '' },
        onProxyReq: (proxyReq, req, res) => {
          console.log(`Proxying ${req.method} ${req.url} to ${proxyReq.path}`);
        }
      }
    }
  },
  configureWebpack: {
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'src')
      }
    }
  }
});