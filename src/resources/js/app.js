import { createApp } from 'vue';
import { createI18n } from 'vue-i18n';
import App from './App.vue';
import initRouter from './router/index';
import { loadLocaleMessages, defaultLocale, locales } from './config/i18n';

// Create the i18n instance
const i18n = createI18n({
    locale: window.app.locale || defaultLocale, // Set locale from global variable or default
    fallbackLocale: window.app.fallback_locale || defaultLocale,
    messages: {}, // Will be populated after loading
});

// Create the Vue application
const app = createApp(App);

// Function to initialize the app after loading messages
const initApp = async () => {
    const messages = await loadLocaleMessages();
    // Set locale messages
    for (const locale of locales) {
        if (messages[locale]) {
            i18n.global.setLocaleMessage(locale, messages[locale]);
        }
    }

    // Initialize router
    const router = await initRouter();
    app.use(router);

    // Use i18n
    app.use(i18n);

    // Mount the app
    app.mount('#app');
};

// Start the initialization
initApp();
