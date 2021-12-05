import Vue from 'vue'
import App from './App.vue'
import vuetify from '@/plugins/vuetify'
import router from '@/router'
import store from '@/store'
import { i18n } from '@/plugins/i18n'

import '@/plugins/vue-composition-api'
import '@resources/sass/styles/styles.scss'
import './components'

Vue.config.productionTip = false

new Vue({
    router,
    store,
    i18n,
    vuetify,
    render: h => h(App),
}).$mount('#app')
