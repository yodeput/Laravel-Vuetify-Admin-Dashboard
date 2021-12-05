import Vue from 'vue'
import { getCurrentInstance } from '@vue/composition-api'
import VueI18n from 'vue-i18n'
import messages from './locales'

Vue.use(VueI18n)

const t = key => {
    const vm = getCurrentInstance().proxy
    return vm.$t ? vm.$t(key) : key
}

export const useUtils = () => ({
    ...t,
})

export const i18n = new VueI18n({
    locale: 'id',
    fallbackLocale: 'id',
    messages,
})
