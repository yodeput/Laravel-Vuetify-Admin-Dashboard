import ConfirmationDialog from '@/components/ConfirmationDialog.vue'

const Confirm = {
    install(Vue, options) {
        this.EventBus = new Vue()
        Vue.component('comfirmation-dialog', ConfirmationDialog)
        Vue.prototype.$confirm = {
            show(params) {
                Confirm.EventBus.$emit('show', params)
            },
        }
    },
}

export default Confirm
