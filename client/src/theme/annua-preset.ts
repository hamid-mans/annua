/**
 * Preset PrimeVue d'Annua
 *
 * On part d'Aura en variante « compat » (base 14px, plus compacte) et on
 * remplace uniquement ce qui porte la charte : couleurs, rayons, focus.
 * Tout le reste (espacements, composants) reste celui d'Aura.
 *
 * Rappel du fonctionnement des tokens PrimeVue :
 * - primitive : la palette brute (les « tubes de peinture »)
 * - semantic  : le sens donné aux couleurs (primary, surface, texte…)
 * - components : réglages par composant (on n'y touche pas ici)
 *
 * `light-dark(clair, sombre)` choisit la valeur selon le mode actif,
 * piloté par la classe `.annua-dark` sur <html> (voir main.ts).
 */
import { definePreset } from '@primeuix/themes'
import AuraCompat from '@primeuix/themes/aura-compat'

// Bleu Annua (teinte 265). 600 = le bleu principal en clair, 400 = en sombre.
const annua = {
  50: 'oklch(97% 0.015 265)',
  100: 'oklch(95% 0.03 265)', // ancien primary-soft (clair)
  200: 'oklch(89% 0.065 265)',
  300: 'oklch(80% 0.11 265)',
  400: 'oklch(68% 0.16 265)', // primary (sombre)
  500: 'oklch(57% 0.19 265)',
  600: 'oklch(48% 0.19 265)', // primary (clair)
  700: 'oklch(40% 0.17 265)', // ancien primary-soft-content (clair)
  800: 'oklch(34% 0.14 265)',
  900: 'oklch(29% 0.11 265)',
  950: 'oklch(21% 0.06 265)', // texte sur bouton primaire (sombre)
}

// Neutres légèrement bleutés : fonds, bordures, textes
const ink = {
  50: 'oklch(97.5% 0.006 265)', // ancien base-200 (clair)
  100: 'oklch(95.5% 0.009 265)',
  200: 'oklch(91.5% 0.012 265)', // ancien base-300 (clair)
  300: 'oklch(85% 0.016 265)',
  400: 'oklch(71% 0.025 265)', // ancien muted (sombre)
  500: 'oklch(51% 0.03 265)', // ancien muted (clair)
  600: 'oklch(43% 0.03 265)',
  700: 'oklch(35% 0.03 265)',
  800: 'oklch(27% 0.025 265)',
  900: 'oklch(22% 0.02 265)', // ancien base-100 (sombre)
  950: 'oklch(18.5% 0.02 265)', // ancien base-200 (sombre)
}

const AnnuaPreset = definePreset(AuraCompat, {
  primitive: {
    borderRadius: {
      none: '0',
      xs: '2px',
      sm: '4px', // ancien --radius-selector
      md: '6px', // ancien --radius-field
      lg: '8px', // ancien --radius-box
      xl: '12px',
    },

    green: {
      50: 'oklch(97.5% 0.025 155)',
      100: 'oklch(95.5% 0.045 155)', // fond « soft »
      200: 'oklch(91% 0.08 155)',
      300: 'oklch(84% 0.12 155)',
      400: 'oklch(72% 0.14 155)',
      500: 'oklch(58% 0.14 155)', // success
      600: 'oklch(50% 0.12 155)',
      700: 'oklch(40% 0.1 155)', // texte « soft »
      800: 'oklch(34% 0.085 155)',
      900: 'oklch(28% 0.07 155)',
      950: 'oklch(20% 0.05 155)',
    },
    orange: {
      50: 'oklch(98% 0.025 80)',
      100: 'oklch(96% 0.05 85)', // fond « soft »
      200: 'oklch(92% 0.09 80)',
      300: 'oklch(87% 0.13 78)',
      400: 'oklch(82% 0.15 76)',
      500: 'oklch(78% 0.16 75)', // warning
      600: 'oklch(66% 0.15 68)',
      700: 'oklch(45% 0.11 60)', // texte « soft »
      800: 'oklch(38% 0.09 60)',
      900: 'oklch(31% 0.07 60)',
      950: 'oklch(23% 0.05 60)',
    },
    red: {
      50: 'oklch(97.5% 0.015 27)',
      100: 'oklch(95.5% 0.03 27)', // fond « soft »
      200: 'oklch(90% 0.06 27)',
      300: 'oklch(82% 0.1 27)',
      400: 'oklch(70% 0.16 27)',
      500: 'oklch(56% 0.21 27)', // error
      600: 'oklch(51% 0.2 27)',
      700: 'oklch(46% 0.18 27)', // texte « soft »
      800: 'oklch(39% 0.15 27)',
      900: 'oklch(33% 0.12 27)',
      950: 'oklch(24% 0.08 27)',
    },
  },

  semantic: {
    primary: {
      ...annua,
      color: 'light-dark({primary.600}, {primary.400})',
      contrastColor: 'light-dark(oklch(98.5% 0.01 265), {primary.950})',
      hoverColor: 'light-dark({primary.700}, {primary.300})',
      activeColor: 'light-dark({primary.800}, {primary.200})',
    },

    surface: {
      0: '#ffffff',
      ...ink,
    },

    text: {
      color: 'light-dark(oklch(24% 0.03 265), oklch(94% 0.01 265))',
      hoverColor: 'light-dark({surface.900}, {surface.0})',
      mutedColor: 'light-dark({surface.500}, {surface.400})',
      hoverMutedColor: 'light-dark({surface.600}, {surface.300})',
    },

    content: {
      borderRadius: '{border.radius.lg}',
    },

    formField: {
      borderRadius: '{border.radius.md}',
      focusRing: {
        width: '0',
        style: 'none',
        color: 'transparent',
        offset: '0',
        shadow: '0 0 0 3px light-dark({primary.100}, color-mix(in srgb, {primary.400}, transparent 75%))',
      },
    },
  },
})

export default AnnuaPreset