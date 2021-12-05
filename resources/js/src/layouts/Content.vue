<template>
    <v-app>
        <vertical-nav-menu :is-drawer-open.sync="isDrawerOpen"/>
        <app-bar/>
        <v-main>
            <div class="app-content-container pa-6">
                <breadcumbs/>
                <slot/>
            </div>
        </v-main>
        <Footer/>
    </v-app>
</template>

<script>
import { ref } from '@vue/composition-api'
import VerticalNavMenu from './components/vertical-nav-menu/VerticalNavMenu.vue'
import AppBar from './components/app-bar/AppBar.vue'
import Footer from './components/footer/Footer.vue'
import Breadcumbs from './components/breadcumbs/Breadcumbs.vue'

export default {
    components: {
        VerticalNavMenu,
        AppBar,
        Footer,
        Breadcumbs,
    },
    setup() {
        const isDrawerOpen = ref(null)

        return {
            isDrawerOpen,
        }
    },
}
</script>

<style lang="scss" scoped>
.v-app-bar ::v-deep {
    .v-toolbar__content {
        padding: 0;

        .app-bar-search {
            .v-input__slot {
                padding-left: 18px;
            }
        }
    }
}

.boxed-container {
    max-width: 1440px;
    margin-left: auto;
    margin-right: auto;
}
</style>
