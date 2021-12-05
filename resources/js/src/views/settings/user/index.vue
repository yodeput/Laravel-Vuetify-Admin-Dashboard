<template>
    <v-card class="w-full">

        <div class="w-full">
            <div class="d-flex align-center pa-5">
                <v-text-field
                    rounded
                    dense
                    :placeholder="$t('form.search')"
                    outlined
                    v-model="filter.search"
                    :prepend-inner-icon="mdiMagnify"
                    class="app-bar-search flex-grow-1"
                    hide-details
                />
                <v-spacer/>
                <v-btn color="primary" @click="newData">
                    <v-icon left>mdi-plus</v-icon>
                    {{ $t('button.add') }}
                </v-btn>
            </div>
        </div>
        <table-component :data="result" :filter="filter" :loading="isBusy"/>
        <pagination-component :filter="filter" :total="result.total" :last="result.last_page"/>
        <form-component/>
    </v-card>
</template>
<script>
import { mapState } from 'vuex'
import { mdiMagnify } from '@mdi/js'
import FormComponent from './components/form.vue'
import TableComponent from './components/table.vue'
import PaginationComponent from '@/components/PaginationComponent'

export default {
    name: 'UserIndex',
    components: {
        FormComponent,
        TableComponent,
        PaginationComponent,
    },
    computed: {
        ...mapState('api/settingsUser', ['result', 'dataCount', 'isBusy']),
        filter: {
            get() {
                return this.$store.state.api.settingsUser.filter
            },
            set(params) {
                this.$store.commit('api/settingsUser/SET_FILTER', params)
            },
        },
    },
    watch: {
        filter: {
            handler(params) {
                this.getData()
            },
            deep: true,
        },
    },
    mounted() {
        this.getData()
    },
    setup() {
        function getData() {
            this.$store.dispatch('api/settingsUser/GET_ALL')
        }
        function newData() {
            this.$store.commit('api/settingsUser/FORM_DIALOG_STATE', true)
        }
        return {
            newData,
            getData,
            mdiMagnify,
        }
    },
}
</script>

<style scoped>

</style>
