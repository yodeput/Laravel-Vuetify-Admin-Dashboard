import Vue from 'vue'
import Vuex from 'vuex'

import user from './module/user'
import notif from './module/app-config'
import menu from './module/menu'
import db from './module/db'
import api from './module/api'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        user,
        notif,
        menu,
        db,
        api,
    },
})

export default store
