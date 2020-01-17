import Echo from 'laravel-echo'
import Device from './device/index.vue'
import store from './device/store/store'
import Vue from 'vue'

Vue.config.productionTip = false

window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

window.Pusher = require('pusher-js')

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'eccd3ecb3fb818618ac0',
  cluster: 'eu',
  encrypted: true
})

new Vue({
  el: '#app',
  store: store,
  components: {
    Device
  }
})
