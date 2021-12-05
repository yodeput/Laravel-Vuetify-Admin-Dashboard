<template>
    <div>
        <v-menu
            offset-y
            left
            nudge-bottom="14"
            min-width="230"
            transition="slide-y-reverse-transition"
            content-class="user-profile-menu-content"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-badge
                    bottom
                    color="success"
                    overlap
                    offset-x="12"
                    offset-y="12"
                    dot
                >
                    <v-avatar
                        size="40px"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-img :src="user.image"/>
                    </v-avatar>
                </v-badge>
            </template>
            <v-list>
                <div class="pb-3 pt-2">
                    <v-avatar class="ms-4" size="40px">
                        <v-img :src="user.image"/>
                    </v-avatar>
                    <div
                        class="d-inline-flex flex-column justify-center ms-3"
                        style="vertical-align:middle"
                    >
          <span class="text--primary font-weight-semibold mb-n1">
            {{ user.name }}
          </span>
                        <small class="text--disabled">{{ user.email }}</small>
                    </div>
                </div>

                <v-divider/>

                <!-- Profile -->
                <v-list-item link>
                    <v-list-item-icon class="me-2">
                        <v-icon size="22">
                            {{ icons.mdiAccountOutline }}
                        </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Profile</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <!-- Settings -->
                <v-list-item link>
                    <v-list-item-icon class="me-2">
                        <v-icon size="22">
                            {{ icons.mdiCogOutline }}
                        </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Settings</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-divider class="my-2"/>

                <!-- Logout -->
                <v-list-item link>
                    <v-list-item-icon class="me-2">
                        <v-icon size="22">
                            {{ icons.mdiLogoutVariant }}
                        </v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title @click="logout">Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
import {
    mdiAccountOutline,
    mdiChatOutline,
    mdiCheckboxMarkedOutline,
    mdiCogOutline,
    mdiCurrencyUsd,
    mdiEmailOutline,
    mdiHelpCircleOutline,
    mdiLogoutVariant,
} from '@mdi/js'
import store from '@/store'

export default {
    computed: {
        user() {
            return this.$store.state.user.user
        },
    },
    methods: {
        logout() {
            this.$confirm.show({
                variant: 'warning',
                icon: mdiLogoutVariant,
                title: this.$t('button.logout'),
                message: this.$t('message.confirm_logout'),
                onConfirm: () => {
                    store.dispatch('api/auth/logout')
                },
            })
        },
    },
    setup() {
        return {
            icons: {
                mdiAccountOutline,
                mdiEmailOutline,
                mdiCheckboxMarkedOutline,
                mdiChatOutline,
                mdiCogOutline,
                mdiCurrencyUsd,
                mdiHelpCircleOutline,
                mdiLogoutVariant,
            },
        }
    },
}
</script>

<style lang="scss">
.user-profile-menu-content {
    .v-list-item {
        min-height: 2.5rem !important;
    }
}
</style>
