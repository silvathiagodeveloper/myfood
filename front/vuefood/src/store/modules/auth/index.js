import axios from "axios"
import router from "@/routes"
import { TOKEN_NAME } from "@/configs/api"

export default {
    state: {
        me: {
            name: '',
            email: '',
        },
        authenticated: false,
    },
    mutations: {
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
        },

        login ({ commit, dispatch }, params) {
            return axios.post('/clients/auth', params)
                        .then( response => {
                            localStorage.setItem(TOKEN_NAME,response.data.token)

                            dispatch('getMe')
                        })
        },

        getMe ({ commit }) {
            const token = localStorage.getItem(TOKEN_NAME)
            if(!token) return;
            return axios.get('/clients/auth', {
                headers: {
                    'Authorization': `Bearer ${ token }` 
                }
            })
            .then(response => {
                commit('SET_ME', response.data.data)
            })
            .catch(error => localStorage.removeItem(TOKEN_NAME))
        },

        logout ({ commit }) {
            const token = localStorage.getItem(TOKEN_NAME)
            if(!token) return;
            return axios.get('/clients/logout', {
                headers: {
                    'Authorization': `Bearer ${ token }` 
                }
            })
            .then(response => {
                commit('LOGOUT')

                localStorage.removeItem(TOKEN_NAME)

                router.push({name:'login'})
            })
            .catch(error => localStorage.removeItem(TOKEN_NAME))
        }
    }
}