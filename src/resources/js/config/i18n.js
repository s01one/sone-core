import { createI18n } from 'vue-i18n';

// Access languages and defaultLocale from the global window.app variable
const locales = window.app.languages || ['en'];
const defaultLocale = window.app.default_locale || 'en';

/**
 * Dynamically load locale messages
 * @returns {Promise<Object>} - A promise that resolves to the messages object
 */
const loadLocaleMessages = async () => {
    const messages = {};
    for (const locale of locales) {
        try {
            const module = await import(`./lang/${locale}.json`);
            messages[locale] = module.default;
        } catch (error) {
            console.error(`Failed to load translations for locale "${locale}":`, error);
        }
    }
    return messages;
};

export { locales, loadLocaleMessages, defaultLocale };
