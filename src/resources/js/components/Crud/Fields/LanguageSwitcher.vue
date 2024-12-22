<template>
    <div class="language-switcher">
        <select v-model="currentLocale" @change="changeLanguage">
            <option v-for="(label, locale) in languages" :key="locale" :value="locale">
                {{ label }}
            </option>
        </select>
    </div>
</template>

<script>
import axios from 'axios';
import { loadLocaleMessages } from '../../config/i18n';

export default {
    data() {
        return {
            currentLocale: this.$i18n.locale,
            languages: {},
        };
    },
    methods: {
        /**
         * Change the application language
         */
        async changeLanguage() {
            if (this.currentLocale !== this.$i18n.locale) {
                const messages = await loadLocaleMessages(this.currentLocale);
                this.$i18n.global.setLocaleMessage(this.currentLocale, messages[this.currentLocale] || {});
                this.$i18n.locale = this.currentLocale;
                // Persist the selected language
                localStorage.setItem('locale', this.currentLocale);
            }
        },
        /**
         * Fetch language labels from the backend
         */
        async fetchLanguageLabels() {
            try {
                const response = await axios.get('/api/language-labels');
                this.languages = response.data;
            } catch (error) {
                console.error('Failed to fetch language labels:', error);
                // Fallback to predefined labels
                const languageNames = {
                    en: 'English',
                    ru: 'Русский',
                    de: 'Deutsch',
                    // Add other language labels here
                };
                this.languages = (window.app.languages || ['en']).reduce((acc, locale) => {
                    acc[locale] = languageNames[locale] || locale.toUpperCase();
                    return acc;
                }, {});
            }
        },
    },
    mounted() {
        // Load persisted language preference
        const savedLocale = localStorage.getItem('locale');
        if (savedLocale && this.languages[savedLocale]) {
            this.currentLocale = savedLocale;
            this.$i18n.locale = savedLocale;
        }

        // Fetch language labels
        this.fetchLanguageLabels();
    },
};
</script>

<style scoped>
.language-switcher {
    margin: 10px;
}
</style>
