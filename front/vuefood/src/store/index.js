import { createStore } from 'vuex'
import tenants from './modules/tenants'
import auth from './modules/auth'
import {state, mutations} from './default'

export default createStore({
    modules: {
        tenants,
        auth
    },
    state,
    mutations
})