<script setup>
    import { ref } from 'vue';
    import Form from './components/Form.vue';
    var isSubmitted = ref(false);
</script>


<template>
    <Form @submit="(value) => isSubmitted = value" :isSubmitted="isSubmitted" />
    
</template>