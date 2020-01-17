<template>
  <div class="absolute bottom-0 left-0 m-5">
    <div class="border px-4 py-3 rounded relative" :class="classes" role="alert">
      <template v-if="connected">
        <i class="fa fa-check-circle"></i>
        <span class="block sm:inline">Live-reload enabled.</span>
      </template>
      <template v-else>
        <i class="fa fa-exclamation-triangle"></i>
        <strong class="font-bold">Not connected!</strong>
        <span class="block sm:inline">Live-reload will not work.</span>
      </template>
    </div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
  computed: {
    ...mapGetters(['connected']),
    classes() {
      return this.connected
        ? 'bg-teal-100 border-teal-500 text-teal-900'
        : 'bg-red-100 border-red-400 text-red-700'
    },
  },
}
</script>
