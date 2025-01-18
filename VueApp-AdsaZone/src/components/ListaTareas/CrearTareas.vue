<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";

import Textarea from 'primevue/textarea';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import FloatLabel from 'primevue/floatlabel';

// Variables
const titulo = ref('');
const descripcion = ref('');

</script>

<!-- Parte del HTML-->
<template>
    <div class="formularioCrearTarea">
        <FloatLabel variant="on" class="espaciadoForm">
            <InputText id="on_label_input" v-model="titulo" size="large"/>
            <label for="on_label_input">Titulo</label>
        </FloatLabel>
        <FloatLabel variant="on" class="espaciadoForm">
            <Textarea id="on_label_textarea" v-model="descripcion" rows="5" cols="30" style="resize: none" />
            <label for="on_label_textarea">Descripcion</label>
        </FloatLabel>
        <Button @click="" label="Crear tarea" outlined class="w-full" ></Button>
    </div>
</template>

<!-- Parte del CSS-->
<style scoped>
.formularioCrearTarea {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.espaciadoForm {
    margin: 0.25rem 0;
}
</style>
