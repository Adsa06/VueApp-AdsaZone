<!-- Parte del Script-->
<script setup>
// Imports
import { ref, onMounted } from "vue";
import { useRouter } from 'vue-router';
import { onAuthStateChanged } from 'firebase/auth'
import { useFirebaseAuth } from 'vuefire'

import Principal from './components/Principal.vue';
import ControladorRegistroLogin from './components/SistemaRegistroLogin/ControladorRegistroLogin.vue';

// Variables
const auth = useFirebaseAuth();

const router = useRouter();

// Funciones
function estadoUsuario(user) {
    if (user != null) 
        router.push('/home');
    else
        router.push('/');
}

onMounted(() => {
    onAuthStateChanged(auth, estadoUsuario);
})
</script>

<!-- Parte del HTML-->
<template>
  <main>
    <RouterView />
    <!-- 
    <div>
      <ControladorRegistroLogin @logSuccess="logged = true" v-if="!logged" />
      <Principal @cerrarSesion="logged = false" v-else/>
    </div>-->
  </main>
</template>

<!-- Parte del CSS-->
<style scoped>

</style>
