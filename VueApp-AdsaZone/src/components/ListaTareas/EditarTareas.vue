<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";

import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import FloatLabel from 'primevue/floatlabel';

// Variables
const visible = ref(false);

const titulo = ref('');
const descripcion = ref('');

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
                <Button type="button" label="Guardar" @click="visible = false"></Button>
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
