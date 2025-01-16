<!-- Drawer de prime vue-->

<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";
import Drawer from 'primevue/drawer';
import Button from 'primevue/button';

// Variables
const visible = ref(false);
</script>

<!-- Parte del HTML-->
<template>
    <div class="card flex justify-center">
        <Drawer v-model:visible="visible" header="Menu">
            <p></p>
        </Drawer>
        <Button icon="pi pi-bars" severity="secondary" rounded @click="visible = true" />
    </div>
</template>


<!-- Parte del CSS-->
<style scoped>

</style>