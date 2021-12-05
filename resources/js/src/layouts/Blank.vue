<template>
    <v-app>
        <v-app-bar
            app
            flat
            absolute
            color="transparent"
        >
            <div class="w-full">
                <div class="d-flex align-center mx-9">
                    <v-spacer/>
                    <div class="mr-10">
                        <theme-switcher/>
                    </div>
                    <div>
                        <locale-switcher/>
                    </div>
                </div>
            </div>
        </v-app-bar>
        <v-main>
            <router-view/>
        </v-main>
    </v-app>
</template>

<script>
import ThemeSwitcher from '@/layouts/components/app-bar/components/ThemeSwitcher'
import LocaleSwitcher from '@/layouts/components/app-bar/components/LocaleSwitcher'

export default {
    name: 'FullPage',
    components: {
        LocaleSwitcher,
        ThemeSwitcher,
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
