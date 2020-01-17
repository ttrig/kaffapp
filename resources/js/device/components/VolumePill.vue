<template>
  <span v-if="volume" v-html="volume" class="pill bg-blue-400"></span>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
  computed: {
    ...mapGetters(['latestData']),
    volume() {
      if (! this.latestData || ! this.latestData.centiliter) {
        return null
      }
      return this.latestData.centiliter + 'cl'
    },
  },
}
</script>
