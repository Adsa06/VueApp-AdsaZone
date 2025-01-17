<!-- Parte del Script-->
<script setup>
// Imports
import Card from 'primevue/card';

// Variables

</script>

<!-- Parte del HTML-->
<template>
    <div class="Panel">
        <div v-for="i in 120" :key="i">
            <Card class="card">
                <template #title>{{ "Tarea: " + i + " de 10" }}</template>
                <template #content>
                    <p>
                        Tarea {{ i }}
                    </p>
                </template>
            </Card>
        </div>
    </div>
</template>

<!-- Parte del CSS-->
<style scoped>
.Panel {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    gap : 0.5rem;
    margin: 1rem;
}

.Card {
    display: flex;
    align-items: center;
    text-align: center;
}

</style>
