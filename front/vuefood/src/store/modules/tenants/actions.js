import axios from "axios"
import router from "@/routes"
import { TOKEN_NAME } from "@/configs/api"

const RESOURCE = 'tenants'

export default {
    getTenants ({ commit }) {
        //commit('SET_TENANTS', {teste : 'teste'}) //somente para testes
        const token = localStorage.getItem(TOKEN_NAME)
        if(!token) router.push({name: 'login'});
        return axios.get(`/${RESOURCE}`, {
            headers: {
                'Authorization': `Bearer ${ token }` 
            }
        })
        .then(response => commit('SET_TENANTS', response.data))
    }
}