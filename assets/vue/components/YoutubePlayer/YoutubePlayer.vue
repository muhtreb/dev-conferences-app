<script setup>
  defineProps({
    videoId: {
      type: String,
      required: true
    }
  })
</script>

<template>
  <vue-plyr>
    <div data-plyr-provider="youtube" :data-plyr-embed-id="this.videoId"></div>
  </vue-plyr>
</template>
