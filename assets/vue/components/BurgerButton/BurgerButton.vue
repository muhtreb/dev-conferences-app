<template>
  <button class="md:hidden py-1 px-1 z-40" @click="toggleNav" :aria-expanded="isNavOpen ? 'true' : 'false'" aria-controls="#nav" :title="title" ref="burgerButton">
    <i class="fa-lg" :class="[!isNavOpen && 'fa-solid fa-bars', isNavOpen && 'fa-solid fa-x']"></i>
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