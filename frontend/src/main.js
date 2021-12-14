import Vue from 'vue'
import App from './App.vue'
import VueFormGenerator from 'vue-form-generator'
import { mapActions, mapGetters } from 'vuex';
import Toasted from 'vue-toasted'
import moment from 'moment'

import router from './router'
import store from './store'
import http from './libs/http'


import 'vue-form-generator/dist/vfg.css'
import './assets/css/main.css'

Vue.config.productionTip = false

Vue.use(VueFormGenerator);
Vue.use(Toasted, {
  theme: "bubble",
  duration: 5000
})

Vue.prototype.$http = http;

Vue.mixin({
  computed: {
    ...mapGetters([
      'auth',
      'isLoggedIn',
      'user'
    ])
  },
  methods: {
    ...mapActions([
      'setData',
      'logout'
    ]),
    parseDate(date){
      return moment(date).format('DD-MM-YYYY');
    },
    beautifyDate(date) {
      return moment(date).format('LL');
    },
    buildQueryString(data) {
      data = Object.fromEntries(Object.entries(data).filter((v) => v[1] != null));
      const params = new URLSearchParams(data);
      return params.toString()
    }
  }
})

new Vue({
  router,
  store,
  render: h => h(App),
  mounted() {
    this.$store.commit('initStore');
  }
}).$mount('#app')
