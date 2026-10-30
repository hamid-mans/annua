import { computed, readonly, ref } from 'vue'

export type ColorMode = 'light' | 'dark'

const STORAGE_KEY = 'annua-color-mode'
const DARK_CLASS = 'annua-dark'

/**
 * L'état est déclaré EN DEHORS de la fonction : il est créé une seule fois
 * et partagé par tous les composants qui appellent useColorMode().
 * C'est un mini « store » sans Pinia, suffisant pour une seule valeur.
 *
 * Valeur de départ : on lit la classe déjà posée par le script de
 * index.html (qui s'exécute avant Vue pour éviter un flash blanc).
 */
const mode = ref<ColorMode>(
  typeof document !== 'undefined' && document.documentElement.classList.contains(DARK_CLASS)
    ? 'dark'
    : 'light',
)

function apply(next: ColorMode) {
  mode.value = next
  document.documentElement.classList.toggle(DARK_CLASS, next === 'dark')
  try {
    localStorage.setItem(STORAGE_KEY, next)
  } catch {
    // Navigation privée ou stockage bloqué : le choix ne sera juste pas retenu
  }
}

export function useColorMode() {
  return {
    mode: readonly(mode),
    isDark: computed(() => mode.value === 'dark'),
    toggle: () => apply(mode.value === 'dark' ? 'light' : 'dark'),
    set: apply,
  }
}