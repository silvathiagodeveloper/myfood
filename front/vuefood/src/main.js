require('@/bootstrap')

import { createApp } from 'vue'
import BaseTemplate from './layouts/BaseTemplate'
import router from './routes'
import store from './store'

createApp(BaseTemplate)
    .use(router)
    .use(store)
    .mount('#app')

store.dispatch('getMe')