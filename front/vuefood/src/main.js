require('@/bootstrap')

import { createApp } from 'vue'
import BaseTemplate from './layouts/BaseTemplate'
import router from './routes'
import store from './store'

createApp(BaseTemplate)
    .component('preloader-component', () => import('./components/Preloader'))
    .use(router)
    .use(store)
    .mount('#app')

store.dispatch('getMe')