import Vue from 'vue'
import Vuetify from 'vuetify/lib/framework'
import en from 'vuetify/lib/locale/en'
import id from 'vuetify/lib/locale/id'
import preset from './default-preset/preset'
import { i18n } from '@/plugins/i18n'

Vue.use(Vuetify)

export default new Vuetify({
    preset,
    icons: {
        iconfont: 'mdiSvg',
    },
    theme: {
        options: {
            customProperties: true,
            variations: false,
        },
    },
    lang: {
        locales: { id, en },
        current: i18n.locale,
    },
})
