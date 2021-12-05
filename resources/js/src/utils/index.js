import {
    getCurrentInstance, reactive, toRefs, watch,
} from '@vue/composition-api'
import cookies from './util.cookies'
import db from './util.db'
import log from './util.log'
// eslint-disable-next-line import/no-cycle
import router from '@/router'

export const isUserLoggedIn = () => cookies.get('token')

export const useRouter = () => {
    const vm = getCurrentInstance().proxy

    const state = reactive({
        route: vm.$route,
    })

    watch(
        () => vm.$route,
        r => {
            state.route = r
        },
    )

    return {
        ...toRefs(state),
        router: vm.$router,
    }
}

export const isObject = obj => typeof obj === 'object' && obj !== null

export const isToday = date => {
    const today = new Date()
    return (
    /* eslint-disable operator-linebreak */
        date.getDate() === today.getDate() &&
    date.getMonth() === today.getMonth() &&
    date.getFullYear() === today.getFullYear()
    /* eslint-enable */
    )
}

const getRandomFromArray = array => array[Math.floor(Math.random() * array.length)]

export const getRandomBsVariant = () => getRandomFromArray(['primary', 'secondary', 'success', 'warning', 'danger', 'info'])

export const isDynamicRouteActive = route => {
    const { route: resolvedRoute } = router.resolve(route)
    return resolvedRoute.path === router.currentRoute.path
}

export const utils = {
    cookies,
    db,
    log,
}
