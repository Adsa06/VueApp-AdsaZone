<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";
import { useFirestore } from "vuefire";
import { collection, setDoc, doc, serverTimestamp } from "firebase/firestore";
import { getAuth } from "firebase/auth";

import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import FloatLabel from 'primevue/floatlabel';

// Variables
const emit = defineEmits(["actualizarTareas"]);

const props = defineProps({
    idTarea: String,
});    

const bbdd = useFirestore();
const auth = getAuth();

const visible = ref(false);

const titulo = ref('');
const descripcion = ref('');

// Funciones    
function convertirATags(texto) {
    // Eliminar comas y otros caracteres no deseados y dividir en palabras
    return texto.replace(/,/g, '').split(' ').filter(Boolean);
}

function editartareas(){
    const TareasRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/Tareas");
    const docRef = doc(TareasRef, props.idTarea);

    // Convertir titulo y descripcion en arrays de palabras
    const tagsTitulo = convertirATags(titulo.value);
    const tagsDescripcion = convertirATags(descripcion.value);

    // Concatenar ambos arrays para que los tags incluyan las palabras de ambos campos
    const allTags = [...tagsTitulo, ...tagsDescripcion];

    setDoc(docRef, { title: titulo.value, body: descripcion.value, finished: false, date: serverTimestamp(), tags: allTags })
    .then(insertNuevaTareaOk)
    .catch(insertNuevaTareaFAIL);
}
function insertNuevaTareaOk(){
    titulo.value = '';
    descripcion.value = '';
    emit("actualizarTareas");
    visible.value = false;
}
function insertNuevaTareaFAIL(){
    console.log("Error al insertar");
}
</script>

<!-- Parte del HTML-->
<template>
    <div class="card flex justify-center">
        <Button label="Editar" @click="visible = true" ></Button>
        <Dialog v-model:visible="visible" modal header="Actualizar tarea">
            <FloatLabel variant="on" class="espaciadoForm">
                <InputText id="on_label_input" v-model="titulo" size="large"/>
                <label for="on_label_input">Titulo</label>
            </FloatLabel>
            <FloatLabel variant="on" class="espaciadoForm">
                <Textarea id="on_label_textarea" v-model="descripcion" rows="5" cols="30" style="resize: none" ></Textarea>
                <label for="on_label_textarea">Descripcion</label>
            </FloatLabel>
            <div class="BotonCancelarActualizar">
                <Button type="button" label="Cancelar" severity="secondary" @click="visible = false"></Button>
                <Button type="button" label="Guardar" @click="editartareas"></Button>
            </div>
        </Dialog>
    </div>
</template>

<!-- Parte del CSS-->
<style scoped>
.espaciadoForm {
    margin: 0.35rem 0;
}

.BotonCancelarActualizar {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
</style>
