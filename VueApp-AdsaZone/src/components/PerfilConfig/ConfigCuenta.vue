<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";

import Card from 'primevue/card';
import Button from 'primevue/button';
import Divider from 'primevue/divider';


// Variables
const name = ref('');
const photoPerfil = ref('');
const edad = ref('');
const sobreMi = ref('');


</script>

<!-- Parte del HTML-->
<template>
    <Card style="margin: 0 1rem;">
        <template #title><i class="pi pi-cog"></i> Configuracion</template>
        <template #content>
            <div>
                <!-- Boton para verificar perfil -->
                <Divider/>
                <P>{{ name ? "El correo esta verificado" : "El correo no esta verificado" }}</P>
                <Button v-if="!name" label="Verificar el correo" severity="secondary" ></Button>

                <!-- Boton para cambiar contraseña -->
                <Divider/>
                <Button label="Cambiar contraseña" severity="secondary" ></Button>

                <!-- Boton para cambiar Borrar Cuenta -->
                <Divider/>
                <Button label="Borrar Cuenta" severity="secondary" ></Button>

                <!--
                    Poder cambiar la foto de perfil
                    Poder cambiar el nombre de la cuenta
                    Poder cambiar el edad de la cuenta
                    Poder cambiar el sobre mi
                -->
                    
            </div>
        </template>
    </Card>
</template>

<!-- Parte del CSS-->
<style scoped>

</style>