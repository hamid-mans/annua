<script setup lang="ts">
import Button from 'primevue/button'
import Tag from 'primevue/tag'
import Accordion from 'primevue/accordion'
import AccordionPanel from 'primevue/accordionpanel'
import AccordionHeader from 'primevue/accordionheader'
import AccordionContent from 'primevue/accordioncontent'
import StatusBadge, { type DeadlineStatus } from '@/components/StatusBadge.vue'

const contactEmail = 'contact@exemple.fr'
const price = { label: 'XX €', period: 'par mois' }

/*
 * Le contenu répétitif devient des données : le template n'écrit chaque bloc
 * qu'une fois et boucle dessus. Ajouter une fonctionnalité = ajouter un objet.
 */
const exampleDeadlines: { vehicle: string; detail: string; status: DeadlineStatus; due: string }[] = [
  { vehicle: 'Fourgon utilitaire', detail: 'AB-123-CD · Contrôle technique', status: 'overdue', due: 'Dans 6 jours' },
  { vehicle: 'Citadine', detail: 'EF-456-GH · Assurance', status: 'upcoming', due: 'Dans 3 semaines' },
  { vehicle: 'Moto', detail: 'IJ-789-KL · Entretien', status: 'ok', due: 'Dans 2 mois' },
]

const features = [
  {
    title: 'Échéances personnalisables',
    text: "Contrôle technique, assurance, entretien : créez vos propres types d'échéances et suivez-les véhicule par véhicule.",
    icon: 'M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z',
  },
  {
    title: 'Relevés kilométriques',
    text: 'Le kilométrage vient des relevés. La fiche de chaque véhicule affiche toujours le dernier relevé connu.',
    icon: 'M4.93 19.07a10 10 0 1 1 14.14 0M12 13l3.5-3.5',
  },
  {
    title: 'Documents au même endroit',
    text: "Carte grise, attestation d'assurance, contrats : chaque document est rattaché à son véhicule, plus de recherche dans les mails.",
    icon: 'M7 3h7l5 5v13H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm7 0v5h5',
  },
  {
    title: 'Un espace pour les conducteurs',
    text: 'Vos conducteurs font leurs déclarations eux-mêmes depuis leur propre accès, sans passer par le bureau.',
    icon: 'M16 19v-1a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v1M10 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm9 8v-1a4 4 0 0 0-3-3.87M15 5.13a3 3 0 0 1 0 5.74',
  },
  {
    title: "Prévenu avant l'échéance",
    text: 'Annua vous signale ce qui arrive à terme pour que rien ne soit découvert au dernier moment.',
    icon: 'M6 9a6 6 0 1 1 12 0c0 5 2 6 2 6H4s2-1 2-6Zm4 9a2 2 0 0 0 4 0',
  },
  {
    title: 'Gestionnaire, conducteur, ou les deux',
    text: "Une même personne peut cumuler les rôles : le gérant qui conduit aussi n'a qu'un seul compte à utiliser.",
    icon: 'M12 3 5 6v5c0 4.5 3 8 7 10 4-2 7-5.5 7-10V6l-7-3Zm-3 9 2 2 4-4',
  },
]

const steps = [
  { title: 'Ajoutez vos véhicules', text: 'Motos, voitures, petits camions : renseignez votre parc et ses échéances.' },
  { title: 'Invitez vos conducteurs', text: 'Chacun reçoit un lien de connexion et définit son mot de passe en quelques secondes.' },
  {
    title: "Gardez une longueur d'avance",
    text: "Les relevés et déclarations remontent seuls, vous voyez d'un coup d'œil ce qui arrive.",
  },
]

const pricingItems = [
  'Suivi des échéances de tout votre parc',
  'Relevés kilométriques et documents par véhicule',
  'Accès conducteur sans frais supplémentaires',
]

const faq = [
  {
    question: 'Pour quels types de véhicules ?',
    answer: 'Motos, voitures et petits camions. Annua est pensé pour des parcs allant de quelques véhicules à une centaine.',
  },
  {
    question: 'Mes conducteurs doivent-ils payer ?',
    answer: "Non. Seul le gestionnaire est facturé. Les conducteurs disposent d'un accès dédié pour faire leurs déclarations.",
  },
  {
    question: 'Comment mes conducteurs se connectent-ils ?',
    answer:
      "Ils reçoivent un lien de connexion par e-mail, qui les invite à choisir leur mot de passe. Aucune installation n'est nécessaire.",
  },
  {
    question: 'Faut-il installer quelque chose ? Est-ce utilisable hors connexion ?',
    answer: "Annua s'utilise dans le navigateur, sur ordinateur comme sur mobile, et nécessite une connexion internet.",
  },
]
</script>

<template>
  <!-- HERO -->
  <section class="mx-auto grid max-w-6xl items-center gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:py-24">
    <div>
      <Tag value="Gestion de parc automobile" class="mb-5" />
      <h1 class="text-4xl font-bold leading-tight tracking-tight sm:text-5xl">
        Plus de CT oublié. Plus d'info perdue entre le conducteur et le bureau.
      </h1>
      <p class="mt-5 max-w-xl text-lg text-muted-color">
        Annua centralise les échéances, les kilométrages et les documents de vos véhicules, pour les TPE, PME et
        associations qui veulent quitter les tableurs sans passer à une usine à gaz.
      </p>
      <div class="mt-8 flex flex-wrap items-center gap-3">
        <Button as="a" href="#contact">
          Demander un accès
          <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
          </svg>
        </Button>
        <Button as="a" href="#fonctionnalites" label="Découvrir les fonctionnalités" text severity="secondary" />
      </div>
      <p class="mt-5 text-sm text-muted-color">Seul le gestionnaire paie : vos conducteurs accèdent à Annua sans frais.</p>
    </div>

    <!-- Aperçu de l'appli -->
    <div class="rounded-lg border border-surface bg-subtle p-5 shadow-sm">
      <div class="mb-4 flex items-center justify-between">
        <h2 class="text-sm font-semibold">Échéances à venir</h2>
        <span class="text-xs text-muted-color">Exemple</span>
      </div>
      <ul class="panel divide-y divide-(--p-content-border-color)">
        <li v-for="item in exampleDeadlines" :key="item.vehicle" class="flex items-center justify-between gap-3 px-4 py-3">
          <div>
            <p class="text-sm font-medium">{{ item.vehicle }}</p>
            <p class="text-xs text-muted-color">{{ item.detail }}</p>
          </div>
          <StatusBadge :status="item.status">{{ item.due }}</StatusBadge>
        </li>
      </ul>
      <div class="panel mt-4 flex items-center justify-between px-4 py-3">
        <div>
          <p class="text-sm font-medium">Relevé kilométrique</p>
          <p class="text-xs text-muted-color">Déclaré par le conducteur</p>
        </div>
        <p class="text-sm font-semibold">48 320 km</p>
      </div>
    </div>
  </section>

  <!-- PROBLÈME -->
  <section class="border-y border-surface bg-subtle">
    <div class="mx-auto max-w-3xl px-4 py-14 text-center sm:px-6">
      <h2 class="text-2xl font-semibold tracking-tight sm:text-3xl">Votre parc vit encore dans un tableur ?</h2>
      <p class="mt-4 text-muted-color">
        Un fichier Excel, un document partagé que tout le monde peut modifier, une seule personne qui connaît les dates
        par cœur. Tant que tout va bien, ça tient. Le jour où l'information se perd, c'est un contrôle technique dépassé
        ou une assurance qui expire sans que personne ne l'ait vu.
      </p>
    </div>
  </section>

  <!-- FONCTIONNALITÉS -->
  <section id="fonctionnalites" class="mx-auto max-w-6xl scroll-mt-20 px-4 py-16 sm:px-6 lg:py-24">
    <div class="mx-auto max-w-2xl text-center">
      <h2 class="text-3xl font-bold tracking-tight">Tout ce qu'il faut pour suivre votre parc</h2>
      <p class="mt-3 text-muted-color">
        Simple à prendre en main, pensé pour le quotidien d'un gestionnaire et de ses conducteurs.
      </p>
    </div>

    <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <article v-for="feature in features" :key="feature.title" class="panel p-6">
        <div class="mb-4 flex size-10 items-center justify-center rounded-lg bg-primary-soft text-primary">
          <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" :d="feature.icon" />
          </svg>
        </div>
        <h3 class="font-semibold">{{ feature.title }}</h3>
        <p class="mt-2 text-sm text-muted-color">{{ feature.text }}</p>
      </article>
    </div>
  </section>

  <!-- FONCTIONNEMENT -->
  <section id="fonctionnement" class="scroll-mt-20 border-y border-surface bg-subtle">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:py-24">
      <h2 class="text-center text-3xl font-bold tracking-tight">Prêt en trois étapes</h2>

      <ol class="mt-12 grid gap-6 md:grid-cols-3">
        <li v-for="(step, index) in steps" :key="step.title" class="panel p-6">
          <span
            class="flex size-8 items-center justify-center rounded-full bg-primary text-sm font-semibold text-primary-contrast"
          >
            {{ index + 1 }}
          </span>
          <h3 class="mt-4 font-semibold">{{ step.title }}</h3>
          <p class="mt-2 text-sm text-muted-color">{{ step.text }}</p>
        </li>
      </ol>
    </div>
  </section>

  <!-- TARIFS -->
  <section id="tarifs" class="mx-auto max-w-6xl scroll-mt-20 px-4 py-16 sm:px-6 lg:py-24">
    <div class="mx-auto max-w-2xl text-center">
      <h2 class="text-3xl font-bold tracking-tight">Un tarif accessible</h2>
      <p class="mt-3 text-muted-color">Seul le gestionnaire paie. Vos conducteurs utilisent Annua sans frais.</p>
    </div>

    <div class="panel mx-auto mt-12 max-w-md p-8 shadow-sm">
      <h3 class="text-lg font-semibold">Gestionnaire</h3>
      <p class="mt-4 flex items-baseline gap-2">
        <span class="text-4xl font-bold tracking-tight">{{ price.label }}</span>
        <span class="text-sm text-muted-color">{{ price.period }}</span>
      </p>
      <ul class="mt-6 space-y-3 text-sm">
        <li v-for="item in pricingItems" :key="item" class="flex items-start gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 size-4 shrink-0 text-success-soft-content" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 5 5L20 7" />
          </svg>
          <span>{{ item }}</span>
        </li>
      </ul>
      <Button as="a" href="#contact" label="Demander un accès" fluid class="mt-8" />
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq" class="scroll-mt-20 border-y border-surface bg-subtle">
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:py-24">
      <h2 class="text-center text-3xl font-bold tracking-tight">Questions fréquentes</h2>

      <Accordion value="0" class="panel mt-10 overflow-hidden">
        <AccordionPanel v-for="(item, index) in faq" :key="item.question" :value="String(index)">
          <AccordionHeader>{{ item.question }}</AccordionHeader>
          <AccordionContent>
            <p class="text-sm text-muted-color">{{ item.answer }}</p>
          </AccordionContent>
        </AccordionPanel>
      </Accordion>
    </div>
  </section>

  <!-- CONTACT -->
  <section id="contact" class="mx-auto max-w-3xl scroll-mt-20 px-4 py-16 text-center sm:px-6 lg:py-24">
    <h2 class="text-3xl font-bold tracking-tight">Parlons de votre parc</h2>
    <p class="mx-auto mt-3 max-w-xl text-muted-color">
      Annua évolue avec les retours de ses premiers utilisateurs. Écrivez-nous pour demander un accès ou poser une
      question.
    </p>
    <Button as="a" :href="`mailto:${contactEmail}`" :label="contactEmail" class="mt-8" />
  </section>
</template>