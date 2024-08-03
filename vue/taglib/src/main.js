import {createApp} from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import {createI18n} from 'vue-i18n'
import en_US from './locales/en_US'
import zh_CN from './locales/zh_CN'
import App from './App.vue'

const i18n = createI18n({
    legacy: false,
    locale: 'zh_CN',
    fallbackLocale: 'en_US',
    messages: {
        en_US: en_US,
        zh_CN: zh_CN
    }
})

const app = createApp(App)
app.use(ElementPlus)
app.use(i18n)
app.mount('#app')