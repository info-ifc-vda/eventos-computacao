const { defineConfig } = require("@vue/cli-service");
const path = require('path');

module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    allowedHosts: "all",  // Permite hosts de qualquer origem
    proxy: {
      '/api': {  // Substitua '/api' pela URL do seu endpoint
        target: 'http://localhost:8082',  // URL do seu servidor backend
        changeOrigin: true,  // Altera a origem da requisição para o target
        secure: false,  // Desativa a verificação SSL para requisições HTTP
        pathRewrite: {
          '^/api': '',  // Opcional: Reescreve a URL, por exemplo, removendo "/api"
        },
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
