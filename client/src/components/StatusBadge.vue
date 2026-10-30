<script setup lang="ts">
/**
 * Badge de statut d'échéance (fond doux + point + libellé).
 * Remplace les classes .badge-overdue / .badge-upcoming / .badge-ok / .badge-inactive
 * de la version DaisyUI. Réutilisable tel quel dans l'appli.
 */
export type DeadlineStatus = 'overdue' | 'upcoming' | 'ok' | 'inactive'

defineProps<{ status: DeadlineStatus }>()

// Les classes complètes sont écrites en toutes lettres : Tailwind lit le code
// source, il ne trouverait pas une classe construite par concaténation.
const classes: Record<DeadlineStatus, string> = {
  overdue: 'bg-error-soft text-error-soft-content',
  upcoming: 'bg-warning-soft text-warning-soft-content',
  ok: 'bg-success-soft text-success-soft-content',
  inactive: 'bg-subtle text-muted-color',
}
</script>

<template>
  <span
    class="inline-flex shrink-0 items-center gap-1.5 rounded-sm px-2 py-0.5 text-xs font-medium"
    :class="classes[status]"
  >
    <span class="size-1.5 rounded-full bg-current" aria-hidden="true" />
    <slot />
  </span>
</template>