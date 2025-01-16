<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";

import Button from "primevue/button";
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import FloatLabel from 'primevue/floatlabel';

// Variables
const password = ref('');
const email = ref('');
const userName = ref('');

</script>

<!-- Parte del HTML-->
<template>
    <div class="formularioReg">
        <p>Inicia Sesion!</p>

        <div class="camposReg">
            <!-- Nombre de usuario-->
            <FloatLabel variant="on" class="espaciadoForm Inputs">
                <InputText id="on_label_user" variant="filled" size="large" v-model="userName" />
                <label for="on_label_user">Nombre de Usuario</label>
            </FloatLabel>

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
        </div>
        <Button>Iniciar sesion</Button>
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