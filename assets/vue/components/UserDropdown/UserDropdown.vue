<template>
  <div class="relative inline-block">
    <button class="rounded px-2 py-1 hover:bg-gray-600 transition-colors duration-200 ease-in-out" @click="toggleDropdown" :aria-expanded="showDropdown" aria-controls="user-dropdown">
      <i class="fa-solid fa-user fa-lg mr-2"></i>
      <span class="hidden md:inline-block mr-2">{{ email }}</span>
      <i class="fa-solid fa-chevron-down"></i>
    </button>
    <div v-if="showDropdown" id="user-dropdown" class="absolute top-full mt-4 right-0 w-64 bg-gray-800 rounded shadow p-4 pt-0 pb-0">
      <ul class="list-reset">
        <li class="border-b-2 border-gray-700">
          <a href="/user" class="hover:underline w-full p-2 inline-block">
            <i class="fa-regular fa-user mr-2"></i>{{ $t('menu.user.profile') }}
          </a>
        </li>
        <li class="border-b-2 border-gray-700">
          <a href="/user/favorite" class="hover:underline p-2 inline-block">
            <i class="fa-regular fa-heart mr-2"></i>{{ $t('menu.user.favorites') }}
          </a>
        </li>
        <li class="border-gray-700">
          <a href="/logout"  class="hover:underline p-2 inline-block">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>{{ $t('menu.logout') }}
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'UserDropdown',
  props: {
    email: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      showDropdown: false
    }
  },
  methods: {
    toggleDropdown() {
      this.showDropdown = !this.showDropdown
    },
    logout() {
      this.$store.dispatch('logout')
    },
    closeDropdown(event) {
      if (!this.$el.contains(event.target)) {
        this.showDropdown = false
      }
      if (event.key === 'Escape') {
        this.showDropdown = false
      }
    }
  },

  // Handle unfocus and Escape key to close dropdown
  mounted() {
    window.addEventListener('click', this.closeDropdown)
    window.addEventListener('keyup', this.closeDropdown)
  },

  // Remove event listeners
  beforeDestroy() {
    window.removeEventListener('click', this.closeDropdown)
    window.removeEventListener('keyup', this.closeDropdown)
  }
}
</script>
