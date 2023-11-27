<template>
  <button @click="onClick" id="header_search_button" :aria-label="$t('header.search.title')" :aria-expanded="isSearchOpen ? 'true' : 'false'" aria-controls="#search-form">
    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
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