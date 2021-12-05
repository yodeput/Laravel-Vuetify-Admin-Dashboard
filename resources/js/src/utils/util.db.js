import low from 'lowdb'
import LocalStorage from 'lowdb/adapters/LocalStorage'
import { cloneDeep } from 'lodash'

const adapter = new LocalStorage('B20AE9DC79DE58A8AF8F50CF95A46C2C')
const db = low(adapter)

db.defaults({
    sys: {},
    database: {},
})
    .write()

export default db

export function pathInit({
    dbName = 'database',
    path = '',
    validator = () => true,
    defaultValue = '',
}) {
    const currentPath = `${dbName}.data${
        path ? `.${path}` : ''
    }`
    const value = db.get(currentPath)
        .value()
    if (!(value !== undefined && validator(value))) {
        db.set(currentPath, defaultValue)
            .write()
    }

    return currentPath
}

export function dbSet({
    dbName = 'database',
    path = '',
    value = '',
    user = false,
}) {
    db.set(
        pathInit({
            dbName,
            path,
            user,
        }),
        value,
    )
        .write()
}

export function dbGet({
    dbName = 'database',
    path = '',
    defaultValue = '',
    user = false,
}) {
    return cloneDeep(
        db
            .get(
                pathInit({
                    dbName,
                    path,
                    user,
                    defaultValue,
                }),
            )
            .value(),
    )
}

export function database({
    dbName = 'database',
    path = '',
    user = false,
    validator = () => true,
    defaultValue = '',
} = {}) {
    return db.get(
        pathInit({
            dbName,
            path,
            user,
            validator,
            defaultValue,
        }),
    )
}
