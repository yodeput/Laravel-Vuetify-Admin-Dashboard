<template>
    <div>
        <v-divider class="my-2"/>
        <div class="d-flex px-5 mt-5">
            <v-select class="mt-1"
                      v-model="filter.per_page"
                      :items="perPageItems"
                      label="per Page"
                      outlined
                      dense
                      style="max-width: 100px;"
            />
            <v-spacer/>
            <v-pagination
                v-model="filter.page"
                :length="last"
            />
            <v-spacer/>
            <div class="align-center mt-3">
                <span class="font-weight-bold text-sm">Total Data: </span>{{ total }}
            </div>

        </div>
    </div>

</template>

<script>
export default {
    name: 'PaginationComponent',
    props: ['filter', 'last', 'total'],
    data() {
        return {
            perPageItems: [5, 10, 15, 20, 50],
        }
    },
}
</script>

<style scoped>

</style>
