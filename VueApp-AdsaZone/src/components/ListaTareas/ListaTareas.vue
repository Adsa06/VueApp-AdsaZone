<!-- Parte del Script-->
<script setup>
// Imports
import { ref, onMounted } from 'vue';
import { useConfirm } from "primevue/useconfirm";

import {
    collection,
    getDocs,
    doc,
    deleteDoc,
    getDoc, 
    updateDoc,
} from 'firebase/firestore';

import {
    getAuth,
} from 'firebase/auth';

import { useFirestore } from 'vuefire';

import CrearTareas from './CrearTareas.vue';
import EditarTareas from './EditarTareas.vue';

import Card from 'primevue/card';
import ToggleSwitch from 'primevue/toggleswitch';
import Divider from 'primevue/divider';
import Button from 'primevue/button';

import ConfirmPopup from 'primevue/confirmpopup';


// Variables
const bbdd = useFirestore();
const auth = getAuth();

const confirm = useConfirm();

const arrTareas = ref([]);
const idTareaBorrar = ref('');

// Funciones
function confirm1() {
    confirm.require({
        message: '¿Estas seguro de que quieres eliminar esta tarea? ',
        icon: 'pi pi-info-circle',
        rejectProps: {
            label: 'Cancelar',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Eliminar',
            severity: 'danger'
        },

        accept: () => {
            borrarTarea();
        },
        reject: () => {
            console.log('Rejected');
        }
    });
};

function borrarTarea() {
    const tareasRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/Tareas");
    const docRef = doc(tareasRef, idTareaBorrar.value);
    deleteDoc(docRef);
    descargarTareasBD();
}

function alternarTarea(idTarea) {
    const tareasRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/Tareas");
    const docRef = doc(tareasRef, idTarea);

    // Obtener la tarea actual y alternar su estado
    getDoc(docRef)
    .then((snapshot) => {
        const tareaData = snapshot.data();
        updateDoc(docRef, { finished: !tareaData.finished });
    })
    .catch((error) => {
        console.error("Error al alternar el estado de la tarea:", error);
    });
}

function descargarTareasBD() {
    const tareasRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/Tareas");
    getDocs(tareasRef)
    .then(descargarTareasOK)
    .catch(descargarTareasNOTOK);
}

function descargarTareasOK(tareasDescargadas) {
    arrTareas.value.splice(0,arrTareas.value.length)
    for(const tarea of tareasDescargadas.docs) {
        console.log(tarea.id," => ",tarea.data());
        arrTareas.value.push({id: tarea.id, ...tarea.data()});
    }
}

function descargarTareasNOTOK(error) {
    console.log("ERROR--->>>"+error);
}

onMounted(() => {
    descargarTareasBD(); // Esto lo que hara es descargar las tareas
});
</script>

<!-- Parte del HTML-->
<template>
    <ConfirmDialog></ConfirmDialog>
    <CrearTareas @actualizarTareas="descargarTareasBD" />
    <Divider />
    <div class="Panel">
        <div v-for="tarea in arrTareas" :key="tarea.id" >
            <Card class="Card">
                <template #title>
                    <div class="titulo">
                        <p> {{ tarea.title }} </p> 
                        <ToggleSwitch v-model="tarea.finished" @change="alternarTarea(tarea.id)" />
                    </div>
                </template>
                <template #content>
                    <div>
                        <p>{{ tarea.body }}</p>
                    </div>
                    <Divider />
                    <div class="BotonesEliminarEditar">
                        <ConfirmPopup></ConfirmPopup>
                        <div class="card flex flex-wrap gap-2 justify-center">
                            <Button @click="idTareaBorrar = tarea.id; confirm1($event)" label="Eliminar" severity="danger" outlined></Button>
                        </div>
                        <div>
                            <EditarTareas @actualizarTareas="descargarTareasBD" :idTarea = "tarea.id"/>
                        </div>
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>

<!-- Parte del CSS-->
<style scoped>
.titulo {
    display: flex;
    align-items: center;
    text-align: center;
    justify-content: space-between;
    gap: 0.5rem;
}
.Panel {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    gap : 0.5rem;
    margin: 1rem;
    justify-content: center;
}

.Card {
    min-width: 15rem;
    max-width: 20rem; /* Cambia este valor según tus necesidades */
    width: 100%; /* Asegura que se adapten al contenedor */
    box-sizing: border-box;

    word-wrap: break-word; /* Ajusta palabras largas */
    word-break: break-word; /* Alternativa para forzar el corte de palabras */
    overflow-wrap: break-word; /* Propiedad recomendada para textos largos */

}

.BotonesEliminarEditar {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

</style>
