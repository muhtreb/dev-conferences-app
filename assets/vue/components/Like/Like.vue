<script setup>
import {useMainStore} from "@/store"
import {defineProps, inject} from 'vue'
inject('i18n')

const props = defineProps({
  type: {
    type: String,
    required: true
  },
  id: {
    type: String,
    required: true
  },
  name: {
    type: String,
    required: true
  }
})

const store = useMainStore()

const isFavorite = () => {
  return store.isUserFavorite(props.type, props.id)
}

const toggleFavorite = () => {
  store.toggleUserFavorite(props.type, props.id)
}

const title = () => {
  return isFavorite() ? `Remove ${props.name} from favorites` : `Add ${props.name} to favorites`
}
</script>

<template>
  <button
      type="button"
      class="py-2 px-3 bg-gray-800 bg-opacity-70 rounded"
      @click="toggleFavorite"
      :title="title"
  >
    <i class="fa-solid fa-heart" v-if="isFavorite()"></i>
    <i class="fa-regular fa-heart" v-else></i>
  </button>
</template>
