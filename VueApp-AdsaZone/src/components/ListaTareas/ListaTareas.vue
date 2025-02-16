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
    query, 
    where,
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

import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import Select from 'primevue/select';

import ConfirmPopup from 'primevue/confirmpopup';


// Variables
const bbdd = useFirestore();
const auth = getAuth();

const confirm = useConfirm();

const arrTareas = ref([]);
const idTareaBorrar = ref('');

const activeSearch = ref(false);
const valorFilter = ref('');

// Filtros de quary
const filtroElegida = ref();
const operadorElegida = ref();
const filtroTarea = ref(['title', 'body', 'finished']);
const filtroOperadores = ref(['<', '>', '<=', '>=', '==', '!=', 'array-contains', 'in', 'array-contains-any', 'not-in']);
const textoFiltrado = ref('');
// Funciones
function funcConfirm() {
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

function descargarTareasFiltradas() {
    const tareasRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/Tareas");

    const consulta = query(tareasRef, where('finished', '==',true), where(filtroTarea.value[filtroElegida.value], operadorElegida.value, filtroTareaPor.value));

    getDocs(consulta)
        .then(descargarTareasOK)
        .catch(descargarTareasNOTOK);
}

const opcionElegida = ref();
const opciones = ref([
    { name: 'Nada' },
    { name: 'Tareas completadas' },
    { name: 'Tareas incompletas' },
    { name: 'Fecha' },
    { name: 'Numero' },
]);

function descargarTareasBD() {
    const tareasRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/Tareas");
    getDocs(tareasRef)
        .then(descargarTareasOK)
        .catch(descargarTareasNOTOK);
}

function descargarTareasOK(tareasDescargadas) {
    arrTareas.value.splice(0, arrTareas.value.length)
    for (const tarea of tareasDescargadas.docs) {
        console.log(tarea.id, " => ", tarea.data());
        arrTareas.value.push({ id: tarea.id, ...tarea.data() });
    }
}

function descargarTareasNOTOK(error) {
    console.log("ERROR--->>>" + error);
}

onMounted(() => {
    descargarTareasBD(); // Esto lo que hara es descargar las tareas
});
</script>

<!-- Parte del HTML-->
<template>
    <h1> {{ filtroElegida }}</h1>
    <h1> {{ filtroTarea[filtroElegida] }}</h1>
    <h1> {{ filtroOperadores[operadorElegida] }}</h1>
    <h1> {{ filtroTareaPor }}</h1>
    <ConfirmDialog></ConfirmDialog>
    <CrearTareas @actualizarTareas="descargarTareasBD" />
    <Divider />
    <div class="Filtros">
        <Select v-if="activeSearch" v-model="opcionElegida" :options="opciones" optionLabel="name" placeholder="" />
        <InputText v-if="activeSearch" v-model="filtroElegida" placeholder="Filtro elegido" />
        <InputText v-if="activeSearch" v-model="operadorElegida" placeholder="Filtro operador" />
        <InputText v-if="activeSearch" v-model="filtroTareaPor" placeholder="Filtro operador" />
        <IconField>
            <InputIcon @click="activeSearch = !activeSearch" :class="activeSearch ? 'pi pi-times' : 'pi pi-search'" />
            <InputText v-if="activeSearch" v-model="valorFilter" placeholder="Search" />
        </IconField>
        <Button v-if="activeSearch" icon="pi pi-search" @click="descargarTareasFiltradas"></Button>
        <Button v-if="activeSearch" label="Limpiar busqueda" severity="secondary" @click="descargarTareasBD"></Button>
    </div>
    <Divider />
    <div class="Panel">
        <div v-for="tarea in arrTareas" :key="tarea.id">
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
                            <Button @click="idTareaBorrar = tarea.id; funcConfirm($event)" label="Eliminar"
                                severity="danger" outlined></Button>
                        </div>
                        <div>
                            <EditarTareas @actualizarTareas="descargarTareasBD" :idTarea="tarea.id" />
                        </div>
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>

<!-- Parte del CSS-->
<style scoped>
.Filtros {
    min-height: 2.5rem;
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

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
    /* Permite que los elementos pasen a la siguiente fila si es necesario */
    gap: 0.5rem;
    /* Espacio entre los divs */
    justify-content: center;
    /* Centra los elementos horizontalmente */
}

.Card {
    flex: 1 1 100px;
    /* Crece, encoge, y tiene un tamaño base de 100px */
    min-width: 15rem;
    max-width: 20rem;
    /* Cambia este valor según tus necesidades */
    width: 100%;
    /* Asegura que se adapten al contenedor */
    box-sizing: border-box;

    word-wrap: break-word;
    /* Ajusta palabras largas */
    word-break: break-word;
    /* Alternativa para forzar el corte de palabras */
    overflow-wrap: break-word;
    /* Propiedad recomendada para textos largos */
}

.BotonesEliminarEditar {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
</style>