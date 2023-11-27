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
    <i class="fa-solid fa-heart" v-if="isFavorite()"></i>
    <i class="fa-regular fa-heart" v-else></i>
  </button>
</template>
