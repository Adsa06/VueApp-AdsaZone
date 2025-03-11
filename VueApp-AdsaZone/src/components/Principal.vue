<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from 'vue';
import ToolBarPrincipal from './PrefabricadosPrimeVue/ToolBarPrincipal.vue';
import Paypal from './Paypal.vue';

// Variables
const NavBar = ref(true);

// Funciones
function actualizarNavBar() {
    NavBar.value = false; // Actualizas el valor a `false`.
    setTimeout(() => {
        NavBar.value = true; // Lo vuelves a `true` después de 100ms.
    }, 1);
}

</script>

<!-- Parte del HTML-->
<template>
    <header>
       <!-- <ToolBarPrincipal v-if="NavBar"/>--> 
    </header>
    <Paypal></Paypal>
    <main>
        <RouterView @actualizarFoto="actualizarNavBar" />
    </main>
</template>

<!-- Parte del CSS-->
<style scoped>

</style>