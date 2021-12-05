<template>
    <v-dialog v-model="dialog" width="70%"
              persistent
              content-class="dialog-on-top"
    >
        <v-card>
            <v-app-bar flat :color="form.id ? 'light-blue lighten-4' : 'light-green lighten-4'">
                <v-icon>
                    {{
                        form.id ? icon.mdiBookEdit : icon.mdiPencil
                    }}
                </v-icon>
                <v-toolbar-title class="ml-1 text-body-1 font-weight-bold">
                    {{
                        form.id ? 'Edit' : 'New'
                    }}
                </v-toolbar-title>
                <v-spacer/>

                <v-btn icon class="mr-1" @click="closeDialog">
                    <v-icon>
                        {{ icon.mdiClose }}
                    </v-icon>
                </v-btn>
            </v-app-bar>
            <v-card-text class="mt-5">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </v-card-text>

            <v-divider/>

            <v-card-actions>
                <v-spacer/>
                <v-btn
                    color="warning"
                    text
                    @click="closeDialog"
                >
                    {{ $t('button.cancel') }}
                </v-btn>
                <v-btn
                    color="primary"
                    text
                    @click="dialog = false"
                >
                    {{ $t('button.save') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
import { mapState } from 'vuex'
import {
    mdiClose, mdiBookEdit, mdiPencil, mdiLogoutVariant,
} from '@mdi/js'

export default {
    name: 'UserForm',
    computed: {
        ...mapState('api/settingsUser', ['form', 'isFormBusy']),
        dialog: {
            get() {
                return this.$store.state.api.settingsUser.formDialogState
            },
            set(params) {
                this.$store.commit('api/settingsUser/FORM_DIALOG_STATE', params)
            },
        },
    },
    setup() {
        function closeDialog() {
            this.$confirm.show({
                variant: 'warning',
                icon: mdiLogoutVariant,
                title: this.$t('button.logout'),
                message: this.$t('message.confirm_logout'),
                onConfirm: () => {
                    this.$store.commit('api/settingsUser/RESET_FORM')
                    this.dialog = false
                },
            })
        }
        return {
            closeDialog,
            icon: {
                mdiClose, mdiBookEdit, mdiPencil,
            },
        }
    },
}
</script>

<style scoped>
.dialog-on-top {
    top: 0 !important;
    left: 0;
    position: absolute !important;
}
</style>
