<script setup lang="ts">
import { Button, InputText, Label } from 'primevue';


</script>

<template>
    <form @submit.prevent>
        <Label>Email</Label>
        <InputText />

        <Label>Mot de passe</Label>
        <InputText />

        <Button type="submit" class="block">Soumettre</Button>
    </form>
</template>