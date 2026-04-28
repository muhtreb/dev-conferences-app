<script setup>
import {useMainStore} from "@/store"
import {computed, defineProps, inject} from 'vue'
const i18n = inject('i18n')

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
  },
  focusable: {
    type: Boolean,
    default: true
  }
})

const store = useMainStore()

const isFavorite = () => {
  return store.isUserFavorite(props.type, props.id)
}

const toggleFavorite = () => {
  store.toggleUserFavorite(props.type, props.id)
}

const title = computed(() => {
  return isFavorite() ? i18n.trans('like.remove') : i18n.trans('like.add')
})
</script>

<template>
  <button
      type="button"
      class="py-2 px-3 bg-gray-800 bg-opacity-70 rounded hover:bg-opacity-100 transition duration-200 ease-in-out"
      @click="toggleFavorite"
      :title="title"
      :tabindex="!focusable ? -1 : null"
  >
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :fill="isFavorite() ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block w-4 h-4">
      <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
    </svg>
  </button>
</template>
