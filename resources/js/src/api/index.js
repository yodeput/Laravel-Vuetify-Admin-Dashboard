import { assign, map } from 'lodash'
import { request, service } from './service'
import * as tools from './tools'

const files = require.context('./modules', true, /\.api\.js$/)
const generators = files.keys().map(key => files(key).default)

export default assign(
    {},
    ...map(generators, generator => generator({
        service,
        request,
        tools,
    })),
)
