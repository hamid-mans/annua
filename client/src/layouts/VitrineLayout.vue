<script setup lang="ts">
import Button from 'primevue/button'
import ColorModeToggle from '@/components/ColorModeToggle.vue'

// Les liens du menu sont des données : on boucle dessus au lieu de répéter le HTML
const navLinks = [
  { hash: '#fonctionnalites', label: 'Fonctionnalités' },
  { hash: '#fonctionnement', label: 'Fonctionnement' },
  { hash: '#tarifs', label: 'Tarifs' },
  { hash: '#faq', label: 'FAQ' },
]

const legalLinks = ['Mentions légales', 'Politique de confidentialité', 'CGU']

const year = new Date().getFullYear()
</script>

<template>
  <div class="flex min-h-screen flex-col">
    <header
      class="sticky top-0 z-40 border-b border-surface bg-surface-0/80 backdrop-blur dark:bg-surface-900/80"
    >
      <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-6 px-4 sm:px-6">
        <RouterLink :to="{ name: 'home', hash: '#top' }" class="text-lg font-bold tracking-tight">
          <img src="/annua.svg" class="dark:hidden w-25" alt="">
          <img src="/annua-dark.svg" class="hidden dark:block w-25" alt="">
        </RouterLink>

        <nav class="hidden items-center gap-6 md:flex" aria-label="Navigation principale">
          <RouterLink
            v-for="link in navLinks"
            :key="link.hash"
            :to="{ name: 'home', hash: link.hash }"
            class="text-sm text-muted-color transition-colors hover:text-color"
          >
            {{ link.label }}
          </RouterLink>
        </nav>

        <div class="flex items-center gap-1">
          <ColorModeToggle />
          <!-- TODO : remplacer par un RouterLink quand la route de connexion existera -->
          <Button size="small" severity="secondary" text>
            <RouterLink to="/se-connecter">Se connecter</RouterLink>
          </Button>
          <Button as="a" href="#contact" label="Demander un accès" size="small" class="hidden sm:inline-flex" />
        </div>
      </div>
    </header>

    <main id="top" class="flex-1">
      <RouterView />
    </main>

    <footer class="border-t border-surface bg-subtle">
      <div
        class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-4 py-8 text-sm text-muted-color sm:flex-row sm:px-6"
      >
        <p>© {{ year }} Annua. Tous droits réservés.</p>
        <nav class="flex flex-wrap items-center justify-center gap-5" aria-label="Liens légaux">
          <a v-for="label in legalLinks" :key="label" href="#" class="hover:text-color">{{ label }}</a>
        </nav>
      </div>
    </footer>
  </div>
</template>