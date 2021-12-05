<template>
    <div>
        <v-data-table
            :loading="loading"
            :headers="rowName"
            :items="data ? data.data : []"
            hide-default-footer
        >
            <template v-slot:item.number="{ index }">
                {{ index + 1 }}
            </template>
            <template v-slot:item.name="{ item }">
                <v-list color="transparent">
                    <v-list-item
                        :class="`d-flex px-0`"
                    >
                        <v-img
                            max-height="50"
                            max-width="50"
                            :src="item.image"
                            class="me-3 rounded-circle"
                        />

                        <div class="d-flex align-center flex-grow-1 flex-wrap">
                            <div class="me-auto pe-2">
                                <h4 class="font-weight-semibold">
                                    {{ item.name }}
                                </h4>
                                <span class="text-xs">{{ item.email }}</span>
                            </div>
                        </div>
                    </v-list-item>
                </v-list>
            </template>
            <template v-slot:item.roles="{ item }">
                <v-chip
                    :color="getColor(item.roles[0].name)"
                    dark
                >
                    {{ item.roles[0].display_name }}
                </v-chip>
            </template>
            <template v-slot:item.status="{ item }">
                <v-chip
                    :color="item.deleted_at ? 'red' : 'green'"
                    dark
                >
                    {{ item.deleted_at ? $t('message.deleted') : $t('message.active') }}
                </v-chip>
            </template>
            <template v-slot:item.updated_at="{ item }">
                {{ item.updated_at | moment('YYYY-MM-DD HH:mm:ss') }}
            </template>
            <template v-slot:item.menu="{ item }">
                <div>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn fab rounded x-small dark color="orange" v-bind="attrs" @click="editData(item)"
                                   v-on="on">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                        </template>
                        <span>Edit Data</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn fab rounded x-small dark color="red" v-bind="attrs" @click="deleteData(item)"
                                   v-on="on">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </template>
                        <span>Delete Data</span>
                    </v-tooltip>
                </div>
            </template>
        </v-data-table>

    </div>
</template>

<script>
export default {
    name: 'UserTable',
    props: ['data', 'filter', 'loading'],
    data() {
        return {}
    },
    computed: {
        rowName() {
            return [
                {
                    text: '#',
                    align: 'start',
                    sortable: false,
                    value: 'number',
                },
                {
                    text: this.$t('table.name'),
                    align: 'start',
                    sortable: true,
                    value: 'name',
                },
                {
                    text: this.$t('table.roles'),
                    align: 'start',
                    sortable: false,
                    value: 'roles',
                },
                {
                    text: this.$t('table.status'),
                    align: 'start',
                    sortable: false,
                    value: 'status',
                },
                {
                    text: this.$t('table.updated_at'),
                    align: 'start',
                    sortable: true,
                    value: 'updated_at',
                },
                {
                    text: 'Menu',
                    align: 'start',
                    sortable: false,
                    value: 'menu',
                },
            ]
        },
    },
    methods: {
        editData(item) {
            this.$store.dispatch('api/settingsUser/SHOW', item.id)
        },
        deleteData(item) {

        },
        getColor(name) {
            switch (name) {
            case 'superadmin':
                return 'cyan'
            case 'administrator':
                return 'purple'
            default:
                return 'yellow'
            }
        },
    },
}
</script>

<style scoped>

</style>
