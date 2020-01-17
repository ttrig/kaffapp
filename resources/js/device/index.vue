<template>
  <div :class="backgroundColor" class="h-screen w-full flex flex-col items-center justify-center font-sans">

    <div class="w-full text-center">
      <LatestValue/>
      <div class="m-4">
        <FreshnessPill/>
        <UpdatedAtPill/>
        <VolumePill/>
      </div>
    </div>

    <ConnectedAlert/>
    <Chart/>
  </div>
</template>

<script>
import Chart from './components/Chart.vue'
import LatestValue from './components/LatestValue.vue'
import UpdatedAtPill from './components/UpdatedAtPill.vue'
import VolumePill from './components/VolumePill.vue'
import FreshnessPill from './components/FreshnessPill.vue'
import ConnectedAlert from './components/ConnectedAlert.vue'
import {mapGetters} from 'vuex'

export default {
  props: [
    'id'
  ],
  components: {
    Chart,
    LatestValue,
    UpdatedAtPill,
    VolumePill,
    FreshnessPill,
    ConnectedAlert,
  },
  created() {
    this.getData()
    setInterval(this.getData, 60000)
  },
  mounted() {
    Echo.connector.pusher.connection.bind('connected', () => {
      this.$store.commit('setConnected', true)
    })
    Echo.channel('messages').listen('.dataWasReceived', (data) => {
      this.getData()
    })
  },
  computed: {
    ...mapGetters([
      'connected',
      'latestData',
      'fullData',
      'chartData',
    ]),
    backgroundColor() {
      if (! this.latestData || ! this.latestData.percent) {
        return 'bg-orange-400'
      }

      return this.latestData.percent <= 10
        ? 'bg-red-400'
        : 'bg-green-600'
    },
  },
  methods: {
    getData() {
      this.$store.dispatch('getData', this.id)
    }
  }
}
</script>
