import { createStore } from 'vuex'
import tenants from './modules/tenants'
import auth from './modules/auth'

export default createStore({
    modules: {
        tenants,
        auth
    }
})