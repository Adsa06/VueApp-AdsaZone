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


// Variables
const bRegLog = ref(false);

// Funciones
function ChangeRegLog() {
    bRegLog.value = !bRegLog.value;
}
</script>

<!-- Parte del HTML-->
<template>
    <div class="card">
        <Tabs value="0">
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
        </Tabs>
    </div>
</template>

<!-- Parte del CSS-->
<style scoped>

</style>
