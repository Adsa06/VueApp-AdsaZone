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
import Dialog from 'primevue/dialog';
import DatePicker from 'primevue/datepicker';

import ConfirmPopup from 'primevue/confirmpopup';


// Variables
const bbdd = useFirestore();
const auth = getAuth();

const confirm = useConfirm();

const arrTareas = ref([]);
const idTareaBorrar = ref('');

const opcionElegida = ref({ name: 'Nada' });
const opciones = ref([
    { name: 'Nada', id: 0 },
    { name: 'Tareas completadas', id: 1 },
    { name: 'Tareas incompletas', id: 2 },
    { name: 'Fecha', id: 3 },
    { name: 'Numero', id: 4 },
]);

const opcionFechaElegida = ref({ cuando: 'Antes del' });
const opcionesFecha = ref([
    { cuando: 'Antes del', id: 1 },
    { cuando: 'Despues del', id: 2 },
    { cuando: 'El dia', id: 3 },
]);

const activeSearch = ref(false);
const valorFilter = ref('');
const visible = ref(false);
const date = ref();

const filtradoOpcional = ref('');

// Filtros de quary
const filtroElegida = ref();
const operadorElegida = ref();
const filtroTarea = ref(['title', 'body', 'finished']);
const filtroOperadores = ref(['<', '>', '<=', '>=', '==', '!=', 'array-contains', 'in', 'array-contains-any', 'not-in']);


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
    if (valorFilter.value != '' || opcionElegida.value.id != 0) {
        const tareasRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/Tareas");
        let consulta = null;
        if (opcionElegida.value.id == 0) {
            consulta = query(tareasRef, where('tags', 'array-contains', valorFilter.value));
        } else if (valorFilter.value == '') {
            switch (opcionElegida.value.id) {
                case 1:
                    consulta = query(tareasRef, where('finished', '==', true));
                    break;

                case 2:
                    consulta = query(tareasRef, where('finished', '==', false));
                    break;

                case 3:
                    if (opcionFechaElegida.value.id === 3) {
                        // Convierte date.value a objeto Date (asegúrate de que date.value sea un formato reconocible)
                        const fechaFiltro = new Date(date.value);

                        // Inicio del día (00:00:00)
                        const inicioDia = new Date(fechaFiltro);
                        inicioDia.setHours(0, 0, 0, 0);

                        // Fin del día (23:59:59.999)
                        const finDia = new Date(fechaFiltro);
                        finDia.setHours(23, 59, 59, 999);
                        consulta = query(tareasRef, where('date', ">=", inicioDia), where('date', "<=", finDia));
                    } else {
                        const operadorFecha = (opcionFechaElegida.value.id === 1) ? '<' : '>';
                        consulta = query(tareasRef, where('date', operadorFecha, date.value));
                    }
                    break;

                case 4:
                    consulta = query(tareasRef, where());
                    break;
                default:
                    break;
            }
        } else {
            switch (opcionElegida.value.id) {
                case 1:
                    consulta = query(tareasRef, where('tags', 'array-contains', valorFilter.value), where('finished', '==', true));
                    break;

                case 2:
                    consulta = query(tareasRef, where('tags', 'array-contains', valorFilter.value), where('finished', '==', false));
                    break;

                case 3:
                    if (opcionFechaElegida.value.id === 3) {
                        // Convierte date.value a objeto Date (asegúrate de que date.value sea un formato reconocible)
                        const fechaFiltro = new Date(date.value);

                        // Inicio del día (00:00:00)
                        const inicioDia = new Date(fechaFiltro);
                        inicioDia.setHours(0, 0, 0, 0);

                        // Fin del día (23:59:59.999)
                        const finDia = new Date(fechaFiltro);
                        finDia.setHours(23, 59, 59, 999);
                        consulta = query(tareasRef, where('tags', 'array-contains', valorFilter.value), where('date', ">=", inicioDia), where('date', "<=", finDia));
                    } else {
                        const operadorFecha = (opcionFechaElegida.value.id === 1) ? '<' : '>';
                        consulta = query(tareasRef, where('tags', 'array-contains', valorFilter.value), where('date', operadorFecha, date.value));
                    }
                    break;

                case 4:
                    consulta = query(tareasRef, where('tags', 'array-contains', valorFilter.value), where());
                    break;
                default:
                    break;
            }
        }
        getDocs(consulta)
            .then(descargarTareasOK)
            .catch(descargarTareasNOTOK);
    }
}

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
        arrTareas.value.push({ id: tarea.id, ...tarea.data(), date: tarea.data().date.toDate()?.toLocaleDateString("es-ES") });
    }
}

function descargarTareasNOTOK(error) {
    console.log("ERROR--->>>" + error);
}

function resetDialog() {
    visible.value = false;
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
    <Dialog v-model:visible="visible" modal header="Elige filtros adicionales" :style="{ width: '25rem' }">
        <div class="contenidoFiltrado">
            <Select v-model="opcionElegida" :options="opciones" optionLabel="name" placeholder="" />
            <div v-if="opcionElegida.name == 'Tareas completadas'" class="contenedorFiltrado">
                <p>Solo se mostraran las tareas completadas</p>
            </div>
            <div v-if="opcionElegida.name == 'Tareas incompletas'" class="contenedorFiltrado">
                <p>Solo se mostraran las tareas incompletadas</p>
            </div>
            <div v-if="opcionElegida.name == 'Fecha'" class="contenedorFiltrado">
                <p>Solo se mostraran las fechas que se crearon:</p>
                <Select v-model="opcionFechaElegida" :options="opcionesFecha" optionLabel="cuando" placeholder="" />
                <DatePicker v-model="date" />
            </div>
            <div class="flex justify-end gap-2">
                <Button type="button" label="Guardar" @click="resetDialog"></Button>
            </div>
        </div>
    </Dialog>
    <div class="Filtros"><!-- 
        <InputText v-if="activeSearch" v-model="filtroElegida" placeholder="Filtro elegido" />
        <InputText v-if="activeSearch" v-model="operadorElegida" placeholder="Filtro operador" />
        <InputText v-if="activeSearch" v-model="filtroTareaPor" placeholder="Filtro operador" />-->
        <Button v-if="activeSearch" icon="pi pi-filter" @click="visible = true"></Button>
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
                    <div>
                        <p>{{ tarea.date }}</p>
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
.contenedorFiltrado {
    display: flex;
    flex-direction: column;
}

.contenidoFiltrado {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

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