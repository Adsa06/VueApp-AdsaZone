<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";    
import { createUserWithEmailAndPassword } from 'firebase/auth'
import { useFirebaseAuth } from 'vuefire'
import { getAuth, updateProfile } from "firebase/auth";
import { useRouter } from 'vue-router';

import Button from "primevue/button";
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel';

// Variables
const router = useRouter();

const errorMenssageRePassword = ref(false);
const errorMenssageLongPassword = ref(false);
const errorMenssageEmail = ref(false);
const errorMenssageUserName = ref(false);

const auth = useFirebaseAuth();
const getAuthActual = getAuth();

const password = ref('');
const repassword = ref('');
const email = ref('');
const userName = ref('');

// Funciones
function register(){
    errorMenssageRePassword.value = false;
    errorMenssageLongPassword.value = false;
    errorMenssageEmail.value = false;
    errorMenssageUserName.value = false;
    
    // Me creo 2 variables booleanas que comprueban si la contraseña esta bien o no y el email respectivamente
    const passwordsMatch = password.value === repassword.value && password.value !== '' && password.value.length >= 6;
    const emailValid = email.value !== '';
    const userNameValid = userName.value !== '';

    // Los mensajes apareceran dependiendo de los booleanos
    errorMenssageRePassword.value = !passwordsMatch;
    errorMenssageEmail.value = !emailValid;
    errorMenssageLongPassword.value = password.value.length < 6;
    errorMenssageUserName.value = !userNameValid;

    // Y con las condiciones comprobadas se registra
    if (passwordsMatch && emailValid && userNameValid) {
        createUserWithEmailAndPassword(auth, email.value, password.value)
        .then((userCredential) => { // Lo hago de esta forma en vez de llamar a funciones porque con las funciones dan error
            console.log("Usuario creado con éxito.");
            updateProfile(getAuthActual.currentUser, {displayName: userName.value})
            .then(() => {
                router.push('/home');
            })
            .catch((error) => {
                console.log("Error al actualizar el perfil: " + error);
            });
        })
        .catch((error) => {
            const errorCode = error.code
            const errorMessage = error.message
            alert("Si ves esto es que ha surguido un error pongase en contacto con el desarrollador");
        });
    }
}

</script>

<!-- Parte del HTML-->
<template>
    <div class="formularioReg">
        <p>Registrate!</p>

        <div class="camposReg">
            <!-- Nombre de usuario-->
            <FloatLabel variant="on" class="espaciadoForm Inputs">
                <InputText id="on_label_user" variant="filled" size="large" v-model="userName" />
                <label for="on_label_user">Nombre de Usuario</label>
            </FloatLabel>
            <p v-if="errorMenssageUserName">El nombre de usuario no es valido</p>

            <!-- Correo electronico-->
            <FloatLabel variant="on" class="espaciadoForm Inputs">
                <InputText id="on_label_Email" variant="filled" size="large" v-model="email" />
                <label for="on_label_Email">Correo Electronico</label>
            </FloatLabel>
            <p v-if="errorMenssageEmail">El email no es valido</p>

            <!-- Contraseña-->
            <FloatLabel variant="on" class="espaciadoForm">
                <Password v-model="password" variant="filled" inputId="on_label_Password" toggleMask :feedback="false"/>
                <label for="on_label_Password">Contraseña</label>
            </FloatLabel>     
            <p v-if="errorMenssageLongPassword">La contraseña debe tener al menos 6 caracteres</p>

            <!-- Repetir Contraseña-->
            <FloatLabel variant="on" class="espaciadoForm">
                <Password v-model="repassword" variant="filled" inputId="on_label_Repassword" toggleMask :feedback="false"/>
                <label for="on_label_Repassword">Repite la Contraseña</label>
            </FloatLabel>
            <p v-if="errorMenssageRePassword">Las contraseñas no coinciden o no son validas</p>

        </div>
        <Button @click="register">Registrarse</Button>
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
 