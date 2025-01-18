<!-- Drawer de prime vue-->

<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";
import { getAuth, signOut } from 'firebase/auth';

import Drawer from 'primevue/drawer';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';
import Menu from 'primevue/menu';

// Variables
const emit = defineEmits(['toggleView', 'CerrarSesion']);

const auth = getAuth();

const visible = ref(false);

const items = ref([
    {
        label: 'Menu principal',
        icon: 'pi pi-home',
        command: () => {
            emit('toggleView', 'MenuPrincipal');
            visible.value = false;
        }
    },
    {
        label: 'Perfil',
        icon: 'pi pi-user',
        command: () => {
            emit('toggleView', 'Perfil');
            visible.value = false;
        }
    },
    {
        label: 'Configuracion',
        icon: 'pi pi-cog',
        command: () => {
            emit('toggleView', 'ConfigCuenta');
            visible.value = false;
        }
    },
    {
        label: 'Lista de tareas',
        icon: 'pi pi-list',
        command: () => {
            emit('toggleView', 'ListaTareas');
            visible.value = false;
        }
    }
]);

// Funciones
function cerrarSesion() {
    signOut(auth)
        .then(() => {
            emit('CerrarSesion');
        })
        .catch((error) => {
            console.log(error)
        });
}
</script>

<!-- Parte del HTML-->
<template>
    <div class="card flex justify-center">
        <Drawer v-model:visible="visible">
            <template #header>
                <div class="flex items-center gap-2 contenidoDrawer">
                    <Avatar image="
https://yt3.googleusercontent.com/ytc/AIdro_ksG0d07eSdW47NTrhyuI3qgm_npiUoLvqUKcM1WYQLEQ=s120-c-k-c0x00ffffff-no-rj" shape="circle" />
                    <span class="font-bold">Menu</span>
                </div>
            </template>

            <template #default>                  
                <div class="card flex justify-center">
                    <Menu :model="items">

                    </Menu>
                </div>
            </template>

            <template #footer>
                <div class="flex items-center gap-2">
                    <Button @click="cerrarSesion" label="Logout" icon="pi pi-sign-out" class="flex-auto" severity="danger" text></Button>
                </div>
            </template>
        </Drawer>
        <Button icon="pi pi-bars" severity="secondary" rounded @click="visible = true" ></Button>
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