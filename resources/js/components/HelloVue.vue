<script>
import { ref } from "vue";

const name = ref("Student");
</script>

<template>
    <div class="card">
        <h1>Hello, {{ name }}!</h1>

        <input v-model="name" placeholder="Enter your name" />

        <p class="text-red-700">Welcome to Laravel + Vue.</p>
    </div>
</template>

<style scoped>
.card {
    max-width: 500px;
    margin: 50px auto;
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 12px;
    font-family: Arial, sans-serif;
}

input {
    padding: 10px;
    border: 1px solid #aaa;
    border-radius: 6px;
}
</style>
