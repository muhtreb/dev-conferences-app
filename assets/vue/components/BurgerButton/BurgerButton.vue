<template>
  <button class="md:hidden py-1 px-1 z-40" @click="toggleNav" :aria-expanded="isNavOpen ? 'true' : 'false'" aria-controls="#nav" :title="title" ref="burgerButton">
    <svg v-if="!isNavOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block w-5 h-5">
      <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
    </svg>
    <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block w-5 h-5">
      <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
    </svg>
  </button>
</template>

<script setup>
import {computed, inject, onMounted, ref} from "vue"

const i18n = inject('i18n')

const isNavOpen = ref(false)

const burgerButton = ref(null)

const toggleNav = () => {
  const nav = document.getElementById('nav')
  nav.classList.toggle('hidden')
  nav.classList.toggle('flex')
  isNavOpen.value = !isNavOpen.value
  document.body.classList.toggle('overflow-hidden')
  if (isNavOpen.value) {
    nav.querySelector('a').focus()
  }
}

const title = computed(() => {
  return !isNavOpen.value ? i18n.trans('menu.show_navigation') : i18n.trans('menu.hide_navigation')
})

// Handle escape key to close nav
onMounted(() => {
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isNavOpen.value) {
      toggleNav()
      if (isNavOpen.value === false) {
        burgerButton.value.focus()
      }
    }
  })
})
</script>