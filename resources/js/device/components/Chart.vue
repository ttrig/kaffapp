<template>
  <div v-show="chartData" class="chart-container absolute top-0 right-0 m-5">
    <canvas ref="chart"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js'
import {mapGetters} from 'vuex'

export default {
  data() {
    return {
      chart: null,
      config: {
        type: 'line',
        data: {
          datasets: [{
            backgroundColor: 'rgba(0, 0, 0, 0.1)',
            borderColor: '#63b3ed',
            fill: true,
            spanGaps: true,
            data: [],
          }]
        },
        options: {
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              type: 'time',
              time: {
                parser: 'YYYY-MM-DD HH:mm:ss',
                tooltipFormat: 'HH:mm:ss',
                unit: 'second',
                displayFormats: {
                  second: 'HH:mm:ss'
                }
              },
              scaleLabel: {
                display: false,
                labelString: 'Time'
              }
            }],
            yAxes: [{
              min: 0,
              max: 100,
              scaleLabel: {
                display: false,
                labelString: '%'
              }
            }]
          },
        },
      },
    };
  },
  mounted() {
    this.chart = new Chart(this.$refs['chart'], this.config)
  },
  computed: {
    ...mapGetters(['chartData'])
  },
  watch: {
    chartData: function (data) {
      this.chart.data.datasets[0].data = data
      this.chart.update()
    }
  },
}
</script>

<style>
.chart-container {
  height: 6vh;
  width: 22vw;
}
</style>
