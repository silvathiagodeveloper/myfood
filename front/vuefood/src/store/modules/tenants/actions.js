import axios from "axios"

const RESOURCE = 'tenants'

export default {
    getTenants ({ commit }) {
        commit('SET_TENANTS', {teste : 'teste'}) //somente para testes
        axios.get(`/${RESOURCE}`)
        .then(response => 
            {
                commit('SET_TENANTS', response.data)
            })
    }
}