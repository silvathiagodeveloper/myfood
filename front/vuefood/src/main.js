require('@/bootstrap')

import { createApp } from 'vue'
import BaseTemplate from './layouts/BaseTemplate'
import router from './routes'
import store from './store'
import preloader from './components/Preloader'

createApp(BaseTemplate)
    .component('preloader-component', preloader)
    .use(router)
    .use(store)
    .mount('#app')

store.dispatch('getMe')