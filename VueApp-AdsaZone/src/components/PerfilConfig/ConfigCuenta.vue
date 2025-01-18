<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";

import Card from 'primevue/card';

// Variablesconst 
const name = ref('');
const photoPerfil = ref('');
const fechaCreacionCuenta = ref('');
const edad = ref('');
const sobreMi = ref('');


</script>

<!-- Parte del HTML-->
<template>
    <Card>
        <template #title>Configuracion</template>
        <template #content>
            <p class="m-0">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae numquam deserunt quisquam repellat libero asperiores earum nam nobis, culpa ratione quam perferendis esse, cupiditate neque
                quas!
            </p>
        </template>
    </Card>
</template>

<!-- Parte del CSS-->
<style scoped>

</style>