import { createApp } from 'vue'
import BaseTemplate from './layouts/BaseTemplate'
import router from './routes'

createApp(BaseTemplate)
    .use(router)
    .mount('#app')
