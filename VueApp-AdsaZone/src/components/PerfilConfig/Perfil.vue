<!-- Parte del Script-->
<script setup>
// Imports
import { ref, onMounted } from "vue";
import { getAuth } from "firebase/auth";

import { useFirestore } from "vuefire";
import { collection, getDoc, doc } from "firebase/firestore";

import Fieldset from 'primevue/fieldset';
import ScrollPanel from 'primevue/scrollpanel';
import Avatar from 'primevue/avatar';
import Card from 'primevue/card';


// Variables

const auth = getAuth();
const bbdd = useFirestore();

const name = ref(auth.currentUser.displayName);;
const photoPerfil = ref(auth.currentUser.photoURL);
const fechaCreacionCuenta = ref(auth.currentUser.metadata.creationTime);
const edad = ref('');
const sobreMi = ref('');

// Funciones
function descargarDatosPersonales() {
    const DatosRef = collection(bbdd, "/Perfiles/" + auth.currentUser.uid + "/DatosPersonales");
    const docRef = doc(DatosRef, "Edad");
    getDoc(docRef)
    .then((snapshot) => {
        if (snapshot.exists()) edad.value = snapshot.data().edad;
    })
    .catch((error) => {
        console.error("Error al descargar los datos personales:", error);
    });
    const docRef2 = doc(DatosRef, "Comentario");
    getDoc(docRef2)
    .then((snapshot) => {
        if (snapshot.exists()) sobreMi.value = snapshot.data().comentario;
    })
    .catch((error) => {
        console.error("Error al descargar los datos personales:", error);
    });
}

onMounted(() => {
    descargarDatosPersonales();
})
</script>

<!-- Parte del HTML-->
<template>
    <div class="Perfil">
        <div class="card">    
            <Card>
                <template #content>
                    <div class="ParteSuperior">
                        <Avatar :image="photoPerfil" class="mr-2" size="xlarge" shape="circle" />
                        <div class="NameAgeDate">
                            <h1>{{ name }}</h1>
                            <h2>Edad del usuario: {{ edad }}</h2>
                            <h3>Fecha de creacion de la cuenta: {{ fechaCreacionCuenta }}</h3>
                        </div>
                    </div>
                </template>
            </Card>
        </div>
        <div >
            <Fieldset legend="Sobre Mi" class="SobreMi">
                <div >
                    <ScrollPanel style="width: 100%; min-height: 3.5rem; max-height: 25rem">
                        <p>
                            {{ sobreMi }}
                        </p>
                    </ScrollPanel>
                </div>
            </Fieldset>
        </div>
    </div>
</template>

<!-- Parte del CSS-->
<style scoped>
.SobreMi {
    width: 50rem;
}
.card {
    width: 50rem;
}
.ParteSuperior {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 2rem;
}
.Perfil {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
}

</style>