<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";
import {
        getAuth,
        sendEmailVerification,
        sendPasswordResetEmail,
        deleteUser,
} from 'firebase/auth';

import { useFirestore } from 'vuefire';
import {
        collection,
        deleteDoc,
        getDocs,
} from 'firebase/firestore';

import Card from 'primevue/card';
import Button from 'primevue/button';
import Divider from 'primevue/divider';
import Avatar from 'primevue/avatar';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Textarea from 'primevue/textarea';


// Variables
const name = ref('');
const photoPerfil = ref('');
const edad = ref('');
const sobreMi = ref('');

const auth = getAuth();
const bbdd = useFirestore();
// Funciones
function verificarCorreo() {
    sendEmailVerification(auth.currentUser)
    .then(() => {
        alert("Correo para verificacion enviado");
    })
    .catch((error) => {
        console.log(error);
        alert("Error al verificar el correo electronico");
    });
}
</script>

<!-- Parte del HTML-->
<template>
    <Card style="margin: 0 1rem;">
        <template #title><i class="pi pi-cog"></i> Configuracion</template>
        <template #content>
            <div>
                <!-- Boton para verificar perfil -->
                <Divider/>
                <P>{{ auth.currentUser.emailVerified ? "El correo esta verificado" : "El correo no esta verificado" }}</P>
                <Button @click="verificarCorreo" v-if="!auth.currentUser.emailVerified" label="Verificar el correo" severity="secondary" ></Button>

                <!-- Boton para cambiar contraseña -->
                <Divider/>
                <Button label="Cambiar contraseña" severity="secondary" ></Button>

                <!-- Boton para cambiar Borrar Cuenta -->
                <Divider/>
                <Button label="Borrar Cuenta" severity="secondary" ></Button>

                <!-- Poder cambiar la foto de perfil -->
                <Divider/>
                <div>
                    <div class="ParteTitulo">
                        <p>Previsualizacion de la foto</p>
                        <Button icon="pi pi-check" severity="success"></Button>
                    </div>
                    <div class="PreView">
                        <InputText placeholder="URL de la foto" v-model="photoPerfil" />
                        <Avatar :image="photoPerfil" shape="circle" size="xlarge" />
                    </div>
                </div>
                
                <!-- Poder cambiar el nombre de la cuenta -->
                <Divider/>
                <p>Cambair nombre de usuario</p>
                <div class="DivName">
                    <InputText placeholder="Cambair el nombre" v-model="name" />
                    <Button icon="pi pi-check" severity="success"></Button>
                </div>

                <!-- Poder cambiar la edad de la cuenta -->
                <Divider/>
                <p>Cambair la edad de la cuenta</p>
                <div class="DivEdad">
                    <InputNumber style="width: 5rem;" :max="200" v-model="edad" :useGrouping="false" fluid/>
                    <Button icon="pi pi-check" severity="success"></Button>
                </div>

                <!-- Poder cambiar el sobre mi -->
                <Divider/>
                <p>Cambair el sobre mi</p>
                <div class="DivEdad">
                    <Textarea v-model="sobreMi" autoResize rows="5" cols="60" />
                    <Button icon="pi pi-check" severity="success"></Button>
                </div>                    
            </div>
        </template>
    </Card>
</template>

<!-- Parte del CSS-->
<style scoped>
.ParteTitulo {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 3.2rem;
}
.PreView {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 1rem;
}

.DivName {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 0.5rem;
}

.DivEdad {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 0.5rem;
}
</style>