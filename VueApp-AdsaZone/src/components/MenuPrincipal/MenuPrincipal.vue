<!-- Parte del Script-->
<script setup>
// Imports
import Card from 'primevue/card';
import Button from 'primevue/button';

// Variables
const emit = defineEmits(['toggleView']);

// Funciones
function cambiarA(where) {
    emit('toggleView', where);
}
</script>

<!-- Parte del HTML-->
<template>
    <div class="Panel">
        <Card class="Card">
            <template #title>Perfil</template>
            <template #content>
                <p class="m-0">
                    Perfil del Usuario
                </p>
            </template>
            <template #footer>
                <div class="flex gap-4 mt-1">
                    <Button @click="cambiarA('Perfil')" label="Ir al perfil" outlined class="w-full" ></Button>
                </div>
            </template>
        </Card>
        <Card class="Card">
            <template #title>Configuracion</template>
            <template #content>
                <p class="m-0">
                    Configuracion del perfil
                </p>
            </template>
            <template #footer>
                <div class="flex gap-4 mt-1">
                    <Button @click="cambiarA('ConfigCuenta')" label="Ir a la Configuracion" outlined class="w-full" ></Button>
                </div>
            </template>
        </Card>
        <Card class="Card">
            <template #title>Lista de tareas</template>
            <template #content>
                <p class="m-0">
                    Lista de tareas personalizada
                </p>
            </template>
            <template #footer>
                <div class="flex gap-4 mt-1">
                    <Button @click="cambiarA('ListaTareas')" label="Ir a la lista" outlined class="w-full" ></Button>
                </div>
            </template>
        </Card>
    </div>
</template>

<!-- Parte del CSS-->
<style scoped>
.Panel {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    gap : 0.5rem;
    margin: 1rem;
}

.Card {
    display: flex;
    min-width: 18rem;
    max-width: 18rem;
    height: 10rem;

    align-items: center;
    text-align: center;

}

</style>