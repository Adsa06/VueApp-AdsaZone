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
const activeView = ref('MenuPrincipal');

const NavBar = ref(true);

// Computed para determinar el componente activo
const ActiveComponent = computed(() => {
    switch (activeView.value) {
        case 'MenuPrincipal':
            return MenuPrincipal;
        case 'ListaTareas':
            return ListaTareas;
        case 'Perfil':
            return Perfil;
        case 'ConfigCuenta':
            return ConfigCuenta;
        default:
            return MenuPrincipal;
    }
});

// Funciones
function cambiarA(view) {
    activeView.value = view;
}

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
        <ToolBarPrincipal v-if="NavBar" @CerrarSesion="$emit('CerrarSesion')" @toggleView="cambiarA"/>
    </header>

    <main>
        <!-- Esto muestra el componente dependiendo de la variable -->
        <component :is="ActiveComponent" @actualizarFoto="actualizarNavBar" @toggleView="cambiarA" @CerrarSesion="$emit('CerrarSesion')"/>
    </main>
</template>

<!-- Parte del CSS-->
<style scoped>

</style>