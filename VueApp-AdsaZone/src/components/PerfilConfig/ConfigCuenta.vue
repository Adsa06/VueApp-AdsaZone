<!-- Parte del Script-->
<script setup>
// Imports
import { ref } from "vue";
import {
        getAuth,
        sendEmailVerification,
        sendPasswordResetEmail,
        deleteUser,
        updateProfile,
} from 'firebase/auth';

import { useFirestore } from 'vuefire';
import {
        collection,
        deleteDoc,
        getDocs,
        doc, 
        setDoc,
} from 'firebase/firestore';

import Card from 'primevue/card';
import Button from 'primevue/button';
import Divider from 'primevue/divider';
import Avatar from 'primevue/avatar';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Textarea from 'primevue/textarea';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import { useRouter } from 'vue-router';


// Variables
const emit = defineEmits(['actualizarFoto']);
const toast = useToast();

const name = ref('');
const photoPerfil = ref('');
const edad = ref('');
const sobreMi = ref('');

const auth = getAuth();
const bbdd = useFirestore();

const router = useRouter();

// Funciones
function verificarCorreo() {
    sendEmailVerification(auth.currentUser)
    .then(() => {
        toast.add({ severity: 'success', summary: 'Correo enviado', detail: 'El correo de verificacion fue enviado', life: 3000 });
    })
    .catch((error) => {
        console.log(error);
        toast.add({ severity: 'error', summary: 'Error al enviar el correo', detail: 'Error al enviar el correo, intentalo mas tarde', life: 3000 });
    });
}

function restablecerContrasena() {
    sendPasswordResetEmail(auth, auth.currentUser.email)
    .then(() => {
        toast.add({ severity: 'success', summary: 'Correo enviado', detail: 'El correo de restablecimiento de contrasena fue enviado', life: 3000 });
    })
    .catch((error) => {
        console.log(error);
        toast.add({ severity: 'error', summary: 'Error al enviar el correo', detail: 'Error al enviar el correo, intentalo mas tarde', life: 3000 });
    });
}

function borrarCuenta() {    // Borrar los datos personales del usuario
    const DatosRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/DatosPersonales");
    getDocs(DatosRef)
    .then((snapshot) => {
        let deletePromises = [];
        snapshot.forEach((doc) => {
            deletePromises.push(deleteDoc(doc.ref));
        });
        return Promise.all(deletePromises); // Asegurarse de que todas las eliminaciones se completen antes de continuar
    })
    .catch((error) => {
        console.log(error);
    });

    // Borrar las tareas del usuario
    const TareasRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/Tareas");
    getDocs(TareasRef)
    .then((snapshot) => {
        let deletePromises = [];
        snapshot.forEach((doc) => {
            deletePromises.push(deleteDoc(doc.ref));
        });
        return Promise.all(deletePromises);
    })
    .catch((error) => {
        console.log(error);
    });

    // Borrar la cuenta del usuario
    deleteUser(auth.currentUser)
    .then(() => {
        toast.add({ severity: 'success', summary: 'Cuenta eliminada', detail: 'Tu cuenta y la informacion que tenia ha sido eliminada', life: 3000 });
        router.push('/');
    })
    .catch((error) => {
        console.log(error);
        toast.add({ severity: 'error', summary: 'Error al eliminar la cuenta', detail: 'Error al eliminar la cuenta, intentalo mas tarde', life: 3000 });

    });
}

function actualiarFoto() {
    updateProfile(auth.currentUser, {photoURL: photoPerfil.value})
    .then(() => {
        emit('actualizarFoto');
        toast.add({ severity: 'success', summary: 'Foto actualizada', detail: 'La foto de perfil ha sido actualizada', life: 3000 });
    })
    .catch((error) => {
        console.log(error);
        toast.add({ severity: 'error', summary: 'Error al actualizar la foto', detail: 'Error al actualizar la foto, intentalo mas tarde', life: 3000 });
    });
}

function actualizarNombre() {
    updateProfile(auth.currentUser, {displayName: name.value})
    .then(() => {
        toast.add({ severity: 'success', summary: 'Nombre actualizado', detail: 'El nombre de la cuenta ha sido actualizado', life: 3000 });
    })
    .catch((error) => {
        console.log(error);
        toast.add({ severity: 'error', summary: 'Error al actualizar el nombre', detail: 'Error al actualizar el nombre, intentalo mas tarde', life: 3000 });
    });
}

function cambiarEdad() {
    const DatosRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/DatosPersonales");
    const docRef = doc(DatosRef, "Edad");
    setDoc(docRef, { edad: edad.value })
    .then(() => {
        toast.add({ severity: 'success', summary: 'Edad actualizada', detail: 'La edad de la cuenta ha sido actualizada', life: 3000 });
    })
    .catch((error) => {
        console.log(error);
        toast.add({ severity: 'error', summary: 'Error al actualizar la edad', detail: 'Error al actualizar la edad, intentalo mas tarde', life: 3000 });
    });
}

function cambiarComentario() {
    const DatosRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/DatosPersonales");
    const docRef = doc(DatosRef, "Comentario");
    setDoc(docRef, { comentario: sobreMi.value })
    .then(() => {
        toast.add({ severity: 'success', summary: 'Comentario actualizado', detail: 'El comentario de la cuenta ha sido actualizado', life: 3000 });
    })
    .catch((error) => {
        console.log(error);
        toast.add({ severity: 'error', summary: 'Error al actualizar el comentario', detail: 'Error al actualizar el comentario, intentalo mas tarde', life: 3000 });
    });
}
</script>

<!-- Parte del HTML-->
<template>
    <Toast />
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
                <Button label="Cambiar contraseña" severity="secondary" @click="restablecerContrasena"></Button>

                <!-- Boton para cambiar Borrar Cuenta -->
                <Divider/>
                <Button label="Borrar Cuenta" severity="danger" @click="borrarCuenta"></Button>

                <!-- Poder cambiar la foto de perfil -->
                <Divider/>
                <div>
                    <div class="ParteTitulo">
                        <p>Previsualizacion de la foto</p>
                        <Button icon="pi pi-check" severity="success" @click="actualiarFoto"></Button>
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
                    <Button icon="pi pi-check" severity="success" @click="actualizarNombre"></Button>
                </div>

                <!-- Poder cambiar la edad de la cuenta -->
                <Divider/>
                <p>Cambair la edad de la cuenta</p>
                <div class="DivEdad">
                    <InputNumber style="width: 5rem;" :max="200" v-model="edad" :useGrouping="false" fluid/>
                    <Button icon="pi pi-check" severity="success" @click="cambiarEdad"></Button>
                </div>

                <!-- Poder cambiar el sobre mi -->
                <Divider/>
                <p>Cambair el sobre mi</p>
                <div class="DivEdad">
                    <Textarea v-model="sobreMi" autoResize rows="5" cols="60" />
                    <Button icon="pi pi-check" severity="success" @click="cambiarComentario"></Button>
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