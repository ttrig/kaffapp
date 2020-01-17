<template>
  <div class="my-4">
    <svg id="fill-gauge" class="font-thin my-2" width="100%" height="550"></svg>
  </div>
</template>

<script>
import liquid from '../liquidFillGauge'
import moment from 'moment'
import {mapGetters} from 'vuex'

export default {
  data() {
    return {
      gauge: null,
      config: {
        ...liquid.defaultSettings(),
        circleColor: '#cccccc',
        circleFillGap: 0,
        circleThickness: 0.1,
        textColor: '#fff',
        waveTextColor: '#cccccc',
        waveColor: '#5a190f',
        textVertPosition: 0.2,
        waveAnimateTime: 2000,
      }
    }
  },
  mounted() {
    this.gauge = liquid.load('fill-gauge', 0, this.config);
  },
  computed: {
    ...mapGetters(['latestData']),
  },
  watch: {
    latestData: function (data) {
      this.gauge.update(data.percent)
    }
  }
}
</script>
