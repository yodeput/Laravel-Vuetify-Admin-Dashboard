import api from '@/api'

export default {
    namespaced: true,
    actions: {
        async GET_ALL({ dispatch }, payload = {}) {
            return new Promise((resolve, reject) => {
                api
                    .GET_ALL_LOG(payload)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
    },
}
