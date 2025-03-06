<!-- Parte del Script-->
<script setup>
// Imports
import { ref, computed } from 'vue';
import ToolBarPrincipal from './PrefabricadosPrimeVue/ToolBarPrincipal.vue';
import MenuPrincipal from './MenuPrincipal/MenuPrincipal.vue';
import ListaTareas from './ListaTareas/ListaTareas.vue';
import Perfil from './PerfilConfig/Perfil.vue';
import ConfigCuenta from './PerfilConfig/ConfigCuenta.vue';

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
        <ToolBarPrincipal v-if="NavBar"/>
    </header>

    <main>
        <RouterView />
        <!-- Esto muestra el componente dependiendo de la variable -->
         <!--
        <component :is="ActiveComponent" @actualizarFoto="actualizarNavBar" @toggleView="cambiarA" @CerrarSesion="$emit('CerrarSesion')"/>
        -->
    </main>
</template>

<!-- Parte del CSS-->
<style scoped>

</style>