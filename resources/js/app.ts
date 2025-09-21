import type { DefineComponent } from 'vue'

import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { vMaska } from 'maska/vue'
import { createPinia } from 'pinia'
import { createApp, h } from 'vue'
import { createI18n } from 'vue-i18n'
import { initializeTheme } from './composables/useAppearance'
import '../css/app.css'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

const numberFormats = {
    'en-GB': {
        currency: {
            style: 'currency',
            currency: 'KES',
            notation: 'standard',
        },
        decimal: {
            style: 'decimal',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        },
        percent: {
            style: 'percent',
            useGrouping: false,
        },
    },
}

const i18n = createI18n({
    locale: 'en-GB',
    fallbackLocale: 'en',
    numberFormats,
})

createInertiaApp({
    title: title => (title ? `${title} - ${appName}` : appName),
    resolve: name => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(createPinia())
            .directive('maska', vMaska)
            .use(i18n)
            //   .use(print)
            .mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})

// This will set light / dark mode on page load...
initializeTheme()
