<template>
  <span v-if="latestData" class="pill bg-purple-500">
    updated&nbsp;<abbr :title="latestData.created_at" v-html="lastAt"></abbr>
  </span>
</template>

<script>
import moment from 'moment'
import {mapGetters} from 'vuex'

export default {
  computed: {
    ...mapGetters(['latestData']),
    lastAt() {
      return moment(this.latestData.created_at).fromNow()
    },
  },
}
</script>
