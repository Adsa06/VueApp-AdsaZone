<!-- Parte del Script-->
<script setup>
// Imports
import DrawerPrimeVue from './DrawerPrincipal.vue';
import Toolbar from 'primevue/toolbar';
import Avatar from 'primevue/avatar';


</script>

<!-- Parte del HTML-->
<template>
    <div class="card">
        <Toolbar style="border-radius: 3rem; padding: 1rem 1rem 1rem 1rem; margin: 0.5rem">
            <template #start>
                <div class="flex items-center gap-2 listaObjetos">
                    <DrawerPrimeVue @toggleView="$emit('toggleView', $event)"/>
                    <img alt="logo" src="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" height="40" class="mr-2" />

                    <h2>Adsa Zone</h2>
                </div>
            </template>

            <template #end>
                <div class="flex items-center gap-2 listaObjetos">
                    <Avatar @click="$emit('toggleView', 'Perfil')" image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" style="width: 32px; height: 32px" />
                </div>
            </template>
        </Toolbar>
    </div>
</template>

<!-- Parte del CSS-->
<style scoped>
.listaObjetos {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

</style>