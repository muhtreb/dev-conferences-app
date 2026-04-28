<template>
  <button @click="onClick" id="header_search_button" :aria-label="$t('header.search.title')" :aria-expanded="isSearchOpen ? 'true' : 'false'" aria-controls="#search-form">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block w-5 h-5">
      <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
    </svg>
  </button>
</template>

<script setup>
import {inject, onMounted, ref} from "vue"

inject('i18n')

const isSearchOpen = ref(false)

const toggleSearch = () => {
  document.getElementById('search-form').classList.toggle('hidden');
  isSearchOpen.value = !isSearchOpen.value
  if (!document.getElementById('search-form').classList.contains('hidden')) {
    document.getElementById('search-form').querySelector('input').focus();
  }
}

const onClick = () => {
  toggleSearch()
}

onMounted(() => {
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isSearchOpen.value) {
      toggleSearch()
    }
  })

  document.getElementById('search-form-close-button').addEventListener('click', (e) => {
    if (isSearchOpen.value) {
      toggleSearch()
    }
  })
})
</script>