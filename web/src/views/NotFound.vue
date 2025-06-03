<template>
  <div>
    <h1>404 - Página Não Encontrada</h1>
    <p>A página que você está procurando não existe.</p>
    <router-link to="/">Voltar para a Página Inicial</router-link>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>

<style scoped>
h1 {
  color: #2c3e50;
}

p {
  font-size: 1.2em;
}
</style>