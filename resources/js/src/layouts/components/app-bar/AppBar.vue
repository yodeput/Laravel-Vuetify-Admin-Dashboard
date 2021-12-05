<template>
    <v-app-bar
        app
        flat
        absolute
        color="transparent"
    >
        <div class=" w-full">
            <div class="d-flex align-center mx-6">
                <div class="mx-2">
                    <theme-switcher/>
                </div>
                <v-spacer/>

                <!-- Right Content -->
                <div class="mx-4">
                    <locale-switcher/>
                </div>
                <div class="mx-4">
                    <v-btn
                        icon
                        small
                    >
                        <v-icon>
                            {{ icons.mdiBellOutline }}
                        </v-icon>
                    </v-btn>
                </div>
                <div class="ml-4">
                    <app-bar-user-menu/>
                </div>
            </div>
        </div>
    </v-app-bar>
</template>

<script>
import {mdiBellOutline, mdiGithub, mdiMagnify} from '@mdi/js'
import ThemeSwitcher from './components/ThemeSwitcher.vue'
import AppBarUserMenu from './components/AppBarUserMenu.vue'
import LocaleSwitcher from './components/LocaleSwitcher.vue'

export default {
    name: 'AppBar',
    components: {
        ThemeSwitcher,
        AppBarUserMenu,
        LocaleSwitcher,
    },
    setup() {
        return {
            icons: {
                mdiMagnify,
                mdiBellOutline,
                mdiGithub,
            },
        }
    },
}
</script>
