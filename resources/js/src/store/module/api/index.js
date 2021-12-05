const files = require.context('./modules', true, /\.js$/)
const modules = {}

files.keys().forEach(key => {
    let name = key.replace(/(\.\/|\.js)/g, '')
    if (name.includes('/')) {
        const bb = name.split('/')
        name = bb[0] + capitalizeFirstLetter(bb[1])
    }
    modules[name] = files(key).default
})

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1)
}

export default {
    namespaced: true,
    modules,
}
