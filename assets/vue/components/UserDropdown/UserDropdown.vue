<template>
  <div class="relative inline-block">
    <button class="flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-medium text-ink-muted hover:text-ink hover:bg-surface-subtle transition-colors duration-200 ease-out" @click="toggleDropdown" :aria-expanded="showDropdown" aria-controls="user-dropdown">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block w-5 h-5">
        <path d="M19 21a7 7 0 0 0-14 0"/><circle cx="12" cy="8" r="5"/>
      </svg>
      <span class="hidden md:inline-block">{{ email }}</span>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block w-4 h-4">
        <path d="m6 9 6 6 6-6"/>
      </svg>
    </button>
    <div v-if="showDropdown" id="user-dropdown" class="absolute top-full mt-2 right-0 w-64 bg-surface ring-1 ring-edge rounded-xl shadow-card-hover py-1 z-40">
      <ul>
        <li>
          <a href="/user/favorite" class="flex items-center gap-2 px-4 py-2.5 text-sm text-ink-muted hover:text-ink hover:bg-surface-subtle transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block w-4 h-4">
              <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
            </svg>{{ $t('menu.user.favorites') }}
          </a>
        </li>
        <li class="border-t border-edge">
          <a href="/logout" class="flex items-center gap-2 px-4 py-2.5 text-sm text-ink-muted hover:text-ink hover:bg-surface-subtle transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block w-4 h-4">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>
            </svg>{{ $t('menu.logout') }}
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
