<template>
  <button @click="onClick" id="header_search_button" :title="title">
    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
  </button>
</template>

<script setup>
import {inject, onMounted, ref} from "vue"

inject('i18n')

const title = () => {
  return this.$t('header.search.title')
}

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
    console.log(e)
    if (e.key === 'Escape' && isSearchOpen.value) {
      toggleSearch()
    }
  })
})
</script>