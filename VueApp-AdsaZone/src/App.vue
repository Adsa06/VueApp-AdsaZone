<!-- Parte del Script-->
<script setup>
// Imports
import { ref, onMounted } from "vue";
import { useRouter } from 'vue-router';
import { onAuthStateChanged } from 'firebase/auth'
import { useFirebaseAuth } from 'vuefire'

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
  </main>
</template>

<!-- Parte del CSS-->
<style scoped>

</style>
