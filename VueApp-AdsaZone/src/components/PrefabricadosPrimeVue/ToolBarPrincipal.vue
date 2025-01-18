<!-- Parte del Script-->
<script setup>
// Imports
import DrawerPrimeVue from './DrawerPrincipal.vue';
import Toolbar from 'primevue/toolbar';
import Avatar from 'primevue/avatar';

import { ref } from "vue";
import { getAuth } from "firebase/auth";

// Variables
const auth = getAuth();
const photoPerfil = ref(auth.currentUser.photoURL);
</script>

<!-- Parte del HTML-->
<template>
    <div class="card">
        <Toolbar style="border-radius: 3rem; padding: 1rem 1rem 1rem 1rem; margin: 0.5rem">
            <template #start>
                <div class="flex items-center gap-2 listaObjetos">
                    <DrawerPrimeVue @CerrarSesion="$emit('CerrarSesion')" @toggleView="$emit('toggleView', $event)"/>
                    <Avatar image="../../../public/AdsaZoneIcono.jpg" size="large" shape="circle" />
                    <h2>Adsa Zone</h2>
                </div>
            </template>

            <template #end>
                <div class="flex items-center gap-2 listaObjetos">
                    <Avatar @click="$emit('toggleView', 'Perfil')" :image="photoPerfil" />
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