import {
    ValidationProvider,
    ValidationObserver,
    localize,
    setInteractionMode,
    extend,
} from 'vee-validate'
import id from 'vee-validate/dist/locale/id.json'
import moment from 'moment'
import Vue from 'vue'
import {
    email, required, max, min, numeric,
} from 'vee-validate/dist/rules'
import Toast from 'vue-toastification'
import '@resources/sass/styles/toastification.scss'
import Confirm from './plugins/confirm'

Vue.use(Toast, {
    hideProgressBar: false,
    closeOnClick: false,
    closeButton: false,
    icon: false,
    timeout: 3000,
    transition: 'Vue-Toastification__fade',
})

moment.locale('id')
Vue.use(require('vue-moment'), { moment })

Vue.component('ValidationProvider', ValidationProvider)
Vue.component('ValidationObserver', ValidationObserver)
setInteractionMode('eager')
extend('required', { ...required })
extend('email', { ...email })
extend('max', { ...required })
extend('min', { ...email })
extend('numeric', { ...required })
localize('id', id)

Vue.use(Confirm)
