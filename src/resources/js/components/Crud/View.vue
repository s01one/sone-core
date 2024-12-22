<template>
    <div>
        <h2>{{ modelLabel }} Детали</h2>
        <ul>
            <li v-for="field in fields" :key="field.name">
                <strong>{{ field.label }}:</strong> {{ data[field.name] }}
            </li>
        </ul>
        <router-link :to="editRoute">Редактировать</router-link>
    </div>
</template>

<script>
import { route } from 'ziggy-js';

export default {
    props: {
        model: {
            type: String,
            required: true,
        },
        fields: {
            type: Array,
            required: true,
        },
        data: {
            type: Object,
            required: true,
        },
    },
    computed: {
        modelLabel() {
            return this.model.charAt(0).toUpperCase() + this.model.slice(1, -1);
        },
        editRoute() {
            return route('edit', { model: this.model, id: this.data.id });
        },
    },
};
</script>

<style scoped>
ul {
    list-style-type: none;
    padding: 0;
}

li {
    margin-bottom: 10px;
}
</style>
