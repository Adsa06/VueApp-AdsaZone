<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";

import Principal from './components/Principal.vue';
import ControladorRegistroLogin from './components/SistemaRegistroLogin/ControladorRegistroLogin.vue';

// Variables
const logged = ref(false);
</script>

<!-- Parte del HTML-->
<template>
  <main>
    <div>
      <ControladorRegistroLogin @logSuccess="logged = true" v-if="!logged" />
      <Principal @cerrarSesion="logged = false" v-else/>
    </div>
  </main>
</template>

<!-- Parte del CSS-->
<style scoped>

</style>
