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
  })
</script>
