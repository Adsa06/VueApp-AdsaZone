<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";
import { getAuth, signInWithEmailAndPassword } from "firebase/auth";
import { useRouter } from 'vue-router';

import Button from "primevue/button";
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel';

// Variables
const auth = getAuth();

const email = ref('');
const password = ref('');

const errorMenssage = ref(false);

const router = useRouter();
// Funciones
function login(){
    signInWithEmailAndPassword(auth, email.value, password.value)
        .then(() => {
            router.push('/home');
        })
        .catch((error) => {
            const errorCode = error.code;
            const errorMessage = error.message;
            errorMenssage.value = true;
        });
}
</script>

<!-- Parte del HTML-->
<template>
    <div class="formularioReg">
        <p>Inicia Sesion!</p>

        <div class="camposReg">
            <!-- Correo electronico-->
            <FloatLabel variant="on" class="espaciadoForm Inputs">
                <InputText id="on_label_Email" variant="filled" size="large" v-model="email" />
                <label for="on_label_Email">Correo Electronico</label>
            </FloatLabel>

            <!-- Contraseña-->
            <FloatLabel variant="on" class="espaciadoForm">
                <Password v-model="password" variant="filled" inputId="on_label_Password" toggleMask :feedback="false"/>
                <label for="on_label_Password">Contraseña</label>
            </FloatLabel>
            <p v-if="errorMenssage">El email o la contraseña no son correctos</p>
        </div>
        <Button @click="login">Iniciar sesion</Button>
    </div>
</template>

<!-- Parte del CSS-->
<style scoped>
.formularioReg {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.camposReg {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.espaciadoForm {
    margin-bottom: 0.5rem;
}
</style>