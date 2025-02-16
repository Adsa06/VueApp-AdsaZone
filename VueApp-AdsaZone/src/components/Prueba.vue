<script setup>
import { ref } from 'vue';
import Button from 'primevue/button';

const showSearch = ref(false);
const searchQuery = ref('');

const toggleSearch = () => {
    showSearch.value = !showSearch.value;
};
</script>

<template>
    <h1>Buscador de tareas</h1>
    <div class="search-container">
        <Button @click="toggleSearch" class="search-icon">
            <i class="fas fa-search"></i>
        </Button>
        <input v-if="showSearch" v-model="searchQuery" type="text" placeholder="Buscar..." class="search-input" />
    </div>
    <h1>Buscador de tareas</h1>
</template>

<style scoped>
.search-container {
    display: flex;
    align-items: center;
    position: relative;
}

.search-icon {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.5rem;
}

.search-input {
    position: absolute;
    top: 0;
    left: 2rem;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 150px;
    transition: width 0.3s ease-in-out;
}
</style>