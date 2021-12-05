    <template>
        <v-breadcrumbs :items="items">
            <template v-slot:divider>
                <v-icon>mdi-chevron-right</v-icon>
            </template>
            <template v-slot:item="{ item }">
                <v-breadcrumbs-item :disabled="!item.active" ripple>
                    <v-icon v-if="item.icon">{{ item.icon }}</v-icon>
                    <span v-else> {{ $t(item.label).toUpperCase() }}</span>
                </v-breadcrumbs-item>
            </template>
        </v-breadcrumbs>
    </template>

<script>
export default {
    name: 'Breadcumbs',
    computed: {
        items() {
            const data = [{
                label: 'Home',
                icon: 'mdi-home',
            }]
            data.push(...this.$route.meta.breadcrumb)
            return data
        },
    },
}
</script>
