<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from 'vue';
import { useConfirm } from "primevue/useconfirm";

import CrearTareas from './CrearTareas.vue';

import Card from 'primevue/card';
import ToggleSwitch from 'primevue/toggleswitch';
import Divider from 'primevue/divider';
import Button from 'primevue/button';

import ConfirmDialog from 'primevue/confirmdialog';

// Variables
const confirm = useConfirm();

function confirm1() {
    confirm.require({
        message: '¿Estas seguro de que quieres eliminar esta tarea?',
        header: 'Zona peligrosa',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Cancelar',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Eliminar',
            severity: 'danger'
        },
        accept: () => {
            console.log('Accepted');
        },
        reject: () => {
            console.log('Rejected');
        }
    });
};

const checked = ref(false);
</script>

<!-- Parte del HTML-->
<template>
    <CrearTareas />
    <Divider />
    <div class="Panel">
        <div v-for="i in 120" :key="i" >
            <Card class="Card">
                <template #title>
                    <div class="titulo">
                        <p> {{ "Tarea: " + i + " de 10" }} </p> 
                        <ToggleSwitch v-model="checked" />
                    </div>
                </template>
                <template #content>
                    <div>
                        <p>
                            Tarea {{ i }}
                        </p>
                    </div>
                    <Divider />
                    <div>
                        <ConfirmDialog></ConfirmDialog>
                        <div class="card flex flex-wrap gap-2 justify-center">
                            <Button @click="confirm1" label="Eliminar" severity="danger" outlined></Button>
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
    max-width: 20rem; /* Cambia este valor según tus necesidades */
    width: 100%; /* Asegura que se adapten al contenedor */
    box-sizing: border-box;

    word-wrap: break-word; /* Ajusta palabras largas */
    word-break: break-word; /* Alternativa para forzar el corte de palabras */
    overflow-wrap: break-word; /* Propiedad recomendada para textos largos */

}

</style>