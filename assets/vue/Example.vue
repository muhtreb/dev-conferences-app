<script>
export default {
  data() {
    return {
      name: '',
      hello: ''
    }
  },
  methods: {
    sayHello() {
      alert('Hello')
    }
  }
}
</script>

<template>
  <div class="bg-red-100">Hello</div>
  <a @click.prevent="sayHello">Say Hello</a>
</template>
