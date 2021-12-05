import { cloneDeep } from 'lodash'
import router from '@/router'
import { database as getDatabase, dbGet, dbSet } from '@/utils/util.db'

export default {
    namespaced: true,
    actions: {
        set(context, {
            dbName = 'database', path = '', value = '', user = false,
        }) {
            dbSet({
                dbName, path, value, user,
            })
        },

        get(
            context,
            {
                dbName = 'database', path = '', defaultValue = '', user = false,
            },
        ) {
            return dbGet({
                dbName, path, defaultValue, user,
            })
        },

        database(context, { user = false } = {}) {
            return getDatabase({
                user,
                defaultValue: {},
            })
        },

        databaseClear(context, { user = false } = {}) {
            return getDatabase({
                user,
                validator: () => false,
                defaultValue: {},
            })
        },

        databasePage(context, { basis = 'fullPath', user = false } = {}) {
            return getDatabase({
                path: `$page.${router.app.$route[basis]}`,
                user,
                defaultValue: {},
            })
        },

        databasePageClear(context, { basis = 'fullPath', user = false } = {}) {
            return getDatabase({
                path: `$page.${router.app.$route[basis]}`,
                user,
                validator: () => false,
                defaultValue: {},
            })
        },

        pageSet(context, { instance, basis = 'fullPath', user = false }) {
            return getDatabase({
                path: `$page.${router.app.$route[basis]}.$data`,
                user,
                validator: () => false,
                defaultValue: cloneDeep(instance.$data),
            })
        },

        pageGet(context, { instance, basis = 'fullPath', user = false }) {
            return dbGet({
                path: `$page.${router.app.$route[basis]}.$data`,
                user,
                defaultValue: cloneDeep(instance.$data),
            })
        },

        pageClear(context, { basis = 'fullPath', user = false }) {
            return getDatabase({
                path: `$page.${router.app.$route[basis]}.$data`,
                user,
                validator: () => false,
                defaultValue: {},
            })
        },
    },
}
