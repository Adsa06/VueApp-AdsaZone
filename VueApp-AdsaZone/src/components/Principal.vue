<!-- Parte del Script-->
<script setup>
// Imports
import { ref, computed } from 'vue';
import ToolBarPrincipal from './PrefabricadosPrimeVue/ToolBarPrincipal.vue';
import MenuPrincipal from './MenuPrincipal/MenuPrincipal.vue';
import ListaTareas from './ListaTareas/ListaTareas.vue';

// Variables
const activeView = ref('MenuPrincipal');

// Computed para determinar el componente activo
const ActiveComponent = computed(() => {
    switch (activeView.value) {
        case 'MenuPrincipal':
            return MenuPrincipal;
        case 'ListaTareas':
            return ListaTareas;
        default:
            return MenuPrincipal;
    }
});

// Funciones
function cambiarA(view) {
    activeView.value = view;
}
</script>

<!-- Parte del HTML-->
<template>
    <header>
        <ToolBarPrincipal />
    </header>

    <main>
        <!-- Esto muestra el componente dependiendo de la variable -->
        <component :is="ActiveComponent" @toggleView="cambiarA"/>
    </main>
</template>

<!-- Parte del CSS-->
<style scoped>

</style>