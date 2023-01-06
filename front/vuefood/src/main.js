require('@/bootstrap')

import { createApp } from 'vue'
import BaseTemplate from './layouts/BaseTemplate'
import router from './routes'
import store from './store'
import preloader-component from './components/preloader'

const app = createApp(BaseTemplate)
    .use(router)
    .use(store)
    .mount('#app')

    app.component('preloader-component', () => import('@/components/Preloader'))
store.dispatch('getMe')