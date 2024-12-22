<template>
    <v-select
        :options="languages"
        v-model="selectedLanguage"
        label="text"
        :class="{'custom-dropdown': true}"
        @update:modelValue="changeLanguage"
    >
        <!-- Отображение элемента в списке -->
        <template #option="{ id, text, flag }">
            <div class="custom-option">
                <img :src="flag" class="flag-icon" alt="" />
                {{ text }}
            </div>
        </template>

        <!-- Отображение выбранного элемента -->
        <template #selected-option="{ id, text, flag }">
            <div class="custom-selected-option">
                <img :src="flag" class="flag-icon" alt="" />
                {{ text }}
            </div>
        </template>
    </v-select>
</template>

<script>
import VSelect from "vue3-select";
import "vue3-select/dist/vue3-select.css";
import { useI18n } from 'vue-i18n';

export default {
    name: "SelectLanguages",
    setup() {
        const { locale } = useI18n();
        console.log('Initial locale:', locale.value); // Проверяем начальный язык
        return { locale };
    },
    components: {
        VSelect,
    },
    data() {
        return {
            languages: [
                { id: "en", text: "English", flag: "assets/img/flags/1x1/en.svg" },
                { id: "de", text: "Deutsch", flag: "assets/img/flags/1x1/de.svg" },
                { id: "ru", text: "Русский", flag: "assets/img/flags/1x1/ru.svg" },
            ],
            selectedLanguage: { id: "en", text: "English", flag: "assets/img/flags/1x1/en.svg" },
        };
    },
    methods: {
        changeLanguage(selected) {
            console.log('Selected language:', selected); // Лог выбранного языка
            this.locale = selected.id; // Изменяем текущую локаль напрямую
            console.log('Current locale:', this.locale); // Проверяем текущую локаль
        },
    },
};
</script>

<style scoped>
.flag-icon {
    width: 16px;
    height: 16px;
    margin-right: 8px;
}

/* Стили опций выпадающего списка */
.custom-option {
    display: flex;
    align-items: center;
    cursor: pointer; /* Указатель при наведении */
}

.custom-option:hover {
    cursor: pointer;
}

/* Стили выбранного элемента */
.custom-selected-option {
    display: flex;
    align-items: center;
    cursor: pointer;
}

/* Добавляем скроллбар */
.v-select.custom-dropdown .vs__dropdown-menu {
    max-height: 200px; /* Ограничение высоты */
    overflow-y: auto; /* Добавляем вертикальный скроллбар */
    scrollbar-width: thin; /* Тонкий скроллбар (для Firefox) */
}

/* Стилизация скроллбара для Chrome, Edge */
.v-select.custom-dropdown .vs__dropdown-menu::-webkit-scrollbar {
    width: 8px;
}

.v-select.custom-dropdown .vs__dropdown-menu::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 4px;
}

.v-select.custom-dropdown .vs__dropdown-menu::-webkit-scrollbar-thumb:hover {
    background: #aaa;
}
.vs__actions:hover {
    cursor: pointer;
}
</style>
