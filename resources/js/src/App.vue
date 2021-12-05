<template>
    <component :is="resolveLayout">
        <router-view/>
        <confirmation-dialog/>
    </component>

</template>

<script>

import { computed } from '@vue/composition-api'
import { useRouter, isUserLoggedIn } from '@/utils'
import LayoutBlank from '@/layouts/Blank.vue'
import LayoutContent from '@/layouts/Content.vue'
import UpgradeToPro from './components/UpgradeToPro.vue'
import ConfirmationDialog from '@/components/ConfirmationDialog.vue'

export default {
    components: {
        LayoutBlank,
        LayoutContent,
        UpgradeToPro,
        ConfirmationDialog,
    },
    computed: {
        successNotif() {
            return this.$store.state.notif.success
        },
        errorNotif() {
            return this.$store.state.notif.error
        },
    },
    beforeCreate() {
        const isLoggedIn = isUserLoggedIn()
        if (isLoggedIn && isLoggedIn !== 'undefined') {
            this.$store.dispatch('api/auth/me')
            this.$store.dispatch('menu/loadMenu')
            this.$store.dispatch('menu/loadPermissions')
        }
    },
    watch: {
        $route: {
            immediate: true,
            // eslint-disable-next-line no-unused-vars
            handler(to, from) {
                document.title = this.$t(to.meta.pageTitle) ? `MATERIO - ${this.$t(to.meta.pageTitle)}` : 'MATERIO'
            },
        },
        successNotif: {
            immediate: true,
            deep: true,
            // eslint-disable-next-line consistent-return
            handler(val) {
                if (val.show) {
                    this.$toast.info(val.message)
                    return this.$store.commit('SHOW_SUCCESS_NOTIF', { show: false })
                }
            },
        },
        errorNotif: {
            immediate: true,
            deep: true,
            // eslint-disable-next-line consistent-return
            handler(val) {
                if (val.show) {
                    this.$toast.error(val.message)
                    return this.$store.commit('SHOW_ERROR_NOTIF', { show: false })
                }
            },
        },
    },
    setup() {
        const { route } = useRouter()
        const resolveLayout = computed(() => {
            // Handles initial route
            if (route.value.name === null) return null

            if (route.value.meta.layout === 'full') return 'layout-blank'

            return 'layout-content'
        })

        return {
            resolveLayout,
        }
    },
}
</script>
