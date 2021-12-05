<template>
    <v-dialog
        v-model="dialog"
        persistent
        max-width="400"
        @keydown.esc="cancel"
    >
        <v-card>
            <v-app-bar flat :color="color"
            >
                <v-icon>
                    {{ this.icon ? this.icon : mdiInformationOutline }}
                </v-icon>
                <v-toolbar-title class="ml-1 text-body-1 font-weight-bold">{{ title.toUpperCase() }}</v-toolbar-title>

                <v-spacer/>

                <v-btn icon class="mr-1" @click="cancel">
                    <v-icon>
                        {{ mdiClose }}
                    </v-icon>
                </v-btn>
            </v-app-bar>

            <v-card-text class="title my-5 mt-8">
                {{
                    message
                }}
            </v-card-text>

            <v-card-actions>
                <v-spacer/>
                <v-btn
                    color="error"
                    text
                    @click="cancel"
                >
                    {{ b_cancel }}
                </v-btn>

                <v-btn
                    color="primary"
                    @click="confirm"
                >
                    {{ b_confirm }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { mdiClose, mdiInformationOutline } from '@mdi/js'
import Confirm from '@/plugins/confirm'

export default {
    name: 'ConfirmationDialog',
    setup() {
        return {
            mdiClose, mdiInformationOutline,
        }
    },
    data() {
        return {
            icon: mdiInformationOutline,
            variant: 'transparent',
            dialog: false,
            title: this.$t('button.delete'),
            message: this.$t('message.delete_confirm'),
            b_cancel: this.$t('button.cancel'),
            b_confirm: this.$t('button.confirm'),
            onConfirm: {},
        }
    },
    computed: {
        color() {
            switch (this.variant) {
            case 'primary': return '#737dff50'
            case 'warning': return '#ffc59250'
            case 'info': return '#c9c9c950'
            case 'danger': return '#ff685d50'
            default: return '#ffffff50'
            }
        },
    },
    beforeMount() {
        Confirm.EventBus.$on('show', params => {
            this.open(params)
        })
    },
    methods: {
        open(data) {
            this.dialog = !this.dialog
            if (data) {
                this.title = data.title
                this.message = data.message
                this.icon = data.icon
                this.variant = data.variant ? data.variant : 'transparent'
                this.onConfirm = data.onConfirm
            }
        },
        cancel() {
            this.$emit('cancel')
            this.dialog = !this.dialog
        },
        confirm() {
            this.$emit('confirm')
            if (typeof this.onConfirm === 'function') {
                this.onConfirm()
                this.dialog = false
            }
        },
    },
}
</script>

<style scoped>

</style>
