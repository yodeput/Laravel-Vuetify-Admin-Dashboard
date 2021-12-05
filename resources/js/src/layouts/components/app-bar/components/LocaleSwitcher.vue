<template>
    <v-menu transition="slide-y-reverse-transition"
            left offset-y open-on-hover>
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon
                   small v-bind="attrs"
                   v-on="on">
                <v-icon>mdi-google-translate</v-icon>
            </v-btn>
<!--
            <v-img
                :src="currentLocale.img"
                max-height="18px"
                max-width="26px"
                v-bind="attrs"
                v-on="on"
            />-->
        </template>
        <v-list>
            <v-list-item-group>
                <v-list-item
                    v-for="(item, index) in locales" @click="setLang(index)" :class="currentLocale.id === item.id ? 'v-list-item--active' : null"
                    :key="index"
                >
                    <v-list-item-icon>
                        <v-img
                            class="mt-1"
                            max-width="26px"
                            :src="item.img"
                        />
                    </v-list-item-icon>
                    <v-list-item-title class="ml-2">
                        {{ item.label }}
                    </v-list-item-title>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-menu>
</template>

<script>
import { localize } from 'vee-validate'
import idLang from 'vee-validate/dist/locale/id.json'
import enLang from 'vee-validate/dist/locale/en.json'

import moment from 'moment'

export default {
    name: 'LocaleSwitcher',
    data() {
        return {
            locales: [
                {
                    id: 'id',
                    img: './assets/images/flags/id.png',
                    label: 'Indonesia',
                },
                {
                    id: 'en',
                    img: './assets/images/flags/en.png',
                    label: 'English',
                },
            ],
        }
    },
    computed: {
        currentLocale() {
            return this.locales.find(l => l.id === this.$i18n.locale)
        },
    },
    methods: {
        setLang(index) {
            if (index === 0) {
                localize('id', idLang)
                moment.locale('id')
                this.$vuetify.lang.current = 'id'
                this.$i18n.locale = 'id'
            } else {
                localize('en', enLang)
                moment.locale('en')
                this.$vuetify.lang.current = 'en'
                this.$i18n.locale = 'en'
            }
        },
    },
}
</script>

<style scoped>

</style>
