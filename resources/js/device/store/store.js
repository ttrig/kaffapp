import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    data: {},
    connected: false,
  },
  getters: {
    latestData: state => state.data.latest || null,
    fullData: state => state.data.latestFull || null,
    chartData: state => state.data.chart || null,
    connected: state => state.connected,
  },
  mutations: {
    setData(state, value) {
      state.data = value
    },
    setConnected(state, bool) {
      state.connected = bool
    },
  },
  actions: {
    getData({commit}, deviceId) {
      axios.get('/api/device/' + deviceId)
           .then(result => commit('setData', result.data))
           .catch(() => commit('setData', null))
    },
  },
})
