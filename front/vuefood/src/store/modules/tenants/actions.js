import axios from "axios"

const RESOURCE = 'tenants'

export default {
    getTenants ({ commit }) {
        axios.get(`/${RESOURCE}`)
        .then(response => 
            {
                commit('SET_TENANTS', response.data)
            })
    }
}