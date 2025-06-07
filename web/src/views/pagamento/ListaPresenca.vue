<template>
  <div class="container">
    <main class="content">
      <div class="card">
        <h2>Lista de Presença</h2>
        <p class="instruction">Escaneie o código do evento para registrar sua presença:</p>
        <div class="qr-code-container">
          <img :src="require('@/assets/qrcode-exemplo.png')" alt="QR Code do Evento" />
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: 'ListaPresenca'
};
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: auto;
  padding: 20px;
}
.title {
  text-align: center;
}
.qr-code-container img {
  width: 50vh;
  height: 50vh;
  padding: 20px;
}
</style>
