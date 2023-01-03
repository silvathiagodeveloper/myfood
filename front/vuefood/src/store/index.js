import { createStore } from 'vuex'
import tenants from './modules/tenants'

export default createStore({
    modules: {
        tenants
    }
})