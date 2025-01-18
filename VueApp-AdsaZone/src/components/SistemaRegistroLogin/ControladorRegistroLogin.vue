<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";
import Login from './Login.vue';
import Register from './Register.vue';

import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import Button from "primevue/button";
import Divider from 'primevue/divider';

import { GoogleAuthProvider, signInWithPopup } from 'firebase/auth'
import { useFirebaseAuth } from 'vuefire'

// Variables
const auth = useFirebaseAuth();

const emit = defineEmits(['logSuccess']);

const valor = ref("0");

// Funciones
function ChangeRegLog() {
    valor.value.toString() == '0' ? valor.value = '1' : valor.value = '0';
}

function RegistrarseConGoogle() {
    const provider = new GoogleAuthProvider();
    signInWithPopup(auth, provider)
    .then((result) => { // Lo hago de esta forma en vez de llamar a funciones porque con las funciones dan error

        console.log("Usuario creado con éxito.");
        emit('logSuccess');
    })
    .catch((error) => {
        // Handle Errors here.
        const errorCode = error.code;
        const errorMessage = error.message;

        console.log(errorMessage);
        console.log(errorCode);

        const credential = GoogleAuthProvider.credentialFromError(error);
    })
}
</script>

<!-- Parte del HTML -->
<template>
    <div class="">
        <Tabs v-model:value="valor" class="Panel">
            <TabList>
                <Tab value="0">Iniciar Sesion</Tab>
                <Tab value="1">Registrarse</Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="0">
                    <Login @logged="emit('logSuccess')"/>
                </TabPanel>
                <TabPanel value="1">
                    <Register @registered="ChangeRegLog"/>
                </TabPanel>
            </TabPanels>
            <Button @click="ChangeRegLog" >Ir a {{ valor.toString() == '0' ? 'Registrarse' : 'Iniciar Sesion'}}</Button> 
            <Divider align="center" >
                <b>O</b>
            </Divider> 
            <Button style="margin-bottom: 0.25rem;" label="Continuar con Google" icon="pi pi-google" @click="RegistrarseConGoogle"></Button>
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
