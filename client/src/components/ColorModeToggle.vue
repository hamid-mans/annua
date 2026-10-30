<script setup lang="ts">
import Button from 'primevue/button'
import { useColorMode } from '@/composables/useColorMode'

const { isDark, toggle } = useColorMode()
</script>

<template>
  <Button
    text
    rounded
    severity="secondary"
    :aria-label="isDark ? 'Passer en mode clair' : 'Passer en mode sombre'"
    :title="isDark ? 'Mode clair' : 'Mode sombre'"
    @click="toggle"
  >
    <!-- Soleil : affiché en mode sombre (pour revenir au clair) -->
    <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2M5.6 5.6l1.4 1.4m10 10 1.4 1.4M3 12h2m14 0h2M5.6 18.4 7 17m10-10 1.4-1.4M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" />
    </svg>
    <!-- Lune : affichée en mode clair -->
    <svg v-else xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round" d="M20 14.5A8 8 0 0 1 9.5 4a8 8 0 1 0 10.5 10.5Z" />
    </svg>
  </Button>
</template>