import axios from "axios"

export default {
    state: {
        me: {
            name: '',
            email: '',
        },
        authenticated: false,
    },
    mutation: {
        SET_ME (state, me) {
            state.me = me
            state.authenticated = true
        },

        SET_AUTHENTICATED (state, status) {
            state.authenticated = status
        },

        LOGOUT (state) {
            state.me = {
                name: '',
                email: '',
            }

            state.authenticated = false
        }
    },

    actions: {
        register ({ commit }, params) {
            return axios.post('/clients', params)
        }
    }
}