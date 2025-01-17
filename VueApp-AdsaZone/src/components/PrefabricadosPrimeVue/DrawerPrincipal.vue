<!-- Drawer de prime vue-->

<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";
import Drawer from 'primevue/drawer';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';

// Variables
const visible = ref(false);
</script>

<!-- Parte del HTML-->
<template>
    <div class="card flex justify-center">
        <Drawer v-model:visible="visible">
            <template #header>
                <div class="flex items-center gap-2 contenidoDrawer">
                    <Avatar image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" shape="circle" />
                    <span class="font-bold">Menu</span>
                </div>
            </template>

            <template #default>

                <p>Content</p>
                <Button type="button" @click="visible = false" label="Close" severity="secondary"></Button>
            </template>

            <template #footer>
                <div class="flex items-center gap-2">
                    <Button label="Logout" icon="pi pi-sign-out" class="flex-auto" severity="danger" text></Button>
                </div>
            </template>
        </Drawer>
        <Button icon="pi pi-bars" severity="secondary" rounded @click="visible = true" />
    </div>
</template>


<!-- Parte del CSS -->
<style scoped>
.contenidoDrawer {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
</style>