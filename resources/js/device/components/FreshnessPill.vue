<template>
  <span :class="colorClass" class="pill">
    <abbr v-if="fullAt" :title="fullAt" v-html="text"></abbr>
    <span v-if="! fullAt">No records of a full pot</span>
    <i :class="icon" class="fa ml-2"></i>
  </span>
</template>

<script>
import {get} from 'lodash'
import moment from 'moment'
import {mapGetters} from 'vuex'

export default {
  computed: {
    ...mapGetters(['fullData']),
    isFresh() {
      if (! this.fullData) {
        return false
      }

      let minutesSinceFull = moment().diff(this.fullData.created_at, 'minutes')
      let freshForMinutes = get(this.fullData, 'device.fresh_for_minutes')

      return minutesSinceFull < freshForMinutes
    },
    icon() {
      if (! this.fullData) {
        return 'fa-frown-open'
      }
      return this.isFresh ? 'fa-thumbs-up' : 'fa-thumbs-down'
    },
    text() {
      return this.isFresh ? 'fresh' : 'not fresh'
    },
    colorClass() {
      if (! this.fullData) {
        return 'bg-yellow-600'
      }
      return this.isFresh ? 'bg-green-400' : 'bg-red-400'
    },
    fullAt() {
      return this.fullData ? moment(this.fullData.created_at).fromNow() : false
    },
  },
}
</script>
