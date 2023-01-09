import axios from "axios"
import router from "@/routes"
import { TOKEN_NAME } from "@/configs/api"

const RESOURCE = 'tenants'

export default {
    getTenants ({ commit }) {
        commit('SET_PRELOADER', true)
        const token = localStorage.getItem(TOKEN_NAME)
        if(!token) router.push({name: 'login'});
        return axios.get(`/${RESOURCE}`, {
            headers: {
                'Authorization': `Bearer ${ token }` 
            }
        })
        .then(response => commit('SET_TENANTS', response.data))
        .finally(() => commit('SET_PRELOADER', false))
    },

    getCategories ({ commit }, token_company) {
        commit('SET_PRELOADER', true)
        const token = localStorage.getItem(TOKEN_NAME)
        if(!token) router.push({name: 'login'});
        return axios.get(`/categories`, {
            headers: {
                'Authorization': `Bearer ${ token }` 
            },
            params: {
                token_company: token_company
            }
        })
        .then(response => commit('SET_CATEGORIES', response.data))
        .finally(() => commit('SET_PRELOADER', false))
    },

    getProducts ({ commit }, token_company) {
        commit('SET_PRELOADER', true)
        const token = localStorage.getItem(TOKEN_NAME)
        if(!token) router.push({name: 'login'});
        return axios.get(`/products`, {
            headers: {
                'Authorization': `Bearer ${ token }` 
            },
            params: {
                token_company: token_company
            }
        })
        .then(response => commit('SET_PRODUCTS', response.data))
        .finally(() => commit('SET_PRELOADER', false))
    },

    getProductsByCategory ({ commit }, token_company, id_category) {
        commit('SET_PRELOADER', true)
        const token = localStorage.getItem(TOKEN_NAME)
        if(!token) router.push({name: 'login'});
        return axios.get(`/${id_category}/products`, {
            headers: {
                'Authorization': `Bearer ${ token }` 
            },
            params: {
                token_company: token_company
            }
        })
        .then(response => commit('SET_PRODUCTS', response.data))
        .finally(() => commit('SET_PRELOADER', false))
    }
}