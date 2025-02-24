<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";
import { useFirestore } from "vuefire";
import { collection, addDoc, serverTimestamp } from "firebase/firestore";
import { getAuth } from "firebase/auth";

import Textarea from 'primevue/textarea';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import FloatLabel from 'primevue/floatlabel';

// Variables
const emit = defineEmits(["actualizarTareas"]);

const bbdd = useFirestore();
const auth = getAuth();

const titulo = ref('');
const descripcion = ref('');

// Funciones
function convertirATags(texto) {
    // Eliminar comas y otros caracteres no deseados y dividir en palabras
    return texto.replace(/,/g, '').split(' ').filter(Boolean);
}
function addTarea() {
    const TareasRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/Tareas");

    // Convertir titulo y descripcion en arrays de palabras
    const tagsTitulo = convertirATags(titulo.value);
    const tagsDescripcion = convertirATags(descripcion.value);

    // Concatenar ambos arrays para que los tags incluyan las palabras de ambos campos
    const allTags = [...tagsTitulo, ...tagsDescripcion];

    addDoc(TareasRef,{ title: titulo.value, body: descripcion.value, finished: false, date: serverTimestamp(), tags:  allTags})
    .then(insertNuevaTareaOk)
    .catch(insertNuevaTareaFAIL);
}
function insertNuevaTareaOk(){
    emit('actualizarTareas');
    titulo.value = '';
    descripcion.value = '';
}
function insertNuevaTareaFAIL(){
    alert('Error al insertar la tarea');
}
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
        <Button @click="addTarea" label="Crear tarea" outlined class="w-full" ></Button>
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
