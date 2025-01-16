<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";
import Login from './Login.vue';
import Register from './Register.vue';
import VerificacionCorreo from './VerificacionCorreo.vue';

import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';

import Button from "primevue/button";


// Variables
const valor = ref("1");

// Funciones
function ChangeRegLog() {
    valor.value.toString() == '0' ? valor.value = '1' : valor.value = '0';
}
</script>

<!-- Parte del HTML -->
<template>
    <div class="card ">
        <Tabs v-model:value="valor" class="Panel">
            <TabList>
                <Tab value="0">Iniciar Sesion</Tab>
                <Tab value="1">Registrarse</Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="0">
                    <Login />
                </TabPanel>
                <TabPanel value="1">
                    <Register />
                </TabPanel>
            </TabPanels>
            <Button style="margin-bottom: 0.25rem;" @click="ChangeRegLog" >Ir a {{ valor.toString() == '0' ? 'Registrarse' : 'Iniciar Sesion'}}</Button> 
        </Tabs> 
    </div>
</template>

<!-- Parte del CSS -->
<style scoped>
.Panel {
    margin: 8rem auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 25rem;
    background-color: #18181b;
    
    border: 1px solid #ccc;
    border-radius: 1rem;
}

</style>

