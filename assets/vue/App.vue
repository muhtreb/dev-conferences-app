<script setup>
  import {onMounted} from "vue";
  import {useMainStore} from "@/store";

  const store = useMainStore()

  import {getUserFavorites} from "@/ts/like";

  onMounted(async () => {
    const favorites = await getUserFavorites()
    if (null !== favorites) {
      store.setUserFavorite(favorites)
    }

    const videoContainer = document.getElementById('video-container')
    if (null !== videoContainer) {
      const playlistContainer = document.getElementById('playlist-container')
      if (null !== playlistContainer) {
        playlistContainer.style.height = videoContainer.offsetHeight + 'px'

        const currentTalkId = videoContainer.getAttribute('data-talk-id')

        if (null !== currentTalkId) {
          const currentVideo = document.querySelector('[data-playlist-talk-id="' + currentTalkId + '"]')
          if (window.innerWidth >= 768) {
            if (null !== currentVideo) {
              currentVideo.scrollIntoView()
            }
          }
        }
      }
    }
  })
</script>
