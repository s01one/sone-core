<template>
    <div>
        <h1 v-if="action === 'index'">Список {{ modelLabel }}</h1>
        <h1 v-else-if="action === 'create'">Создать {{ modelLabel }}</h1>
        <h1 v-else-if="action === 'edit'">Редактировать {{ modelLabel }}</h1>
        <h1 v-else-if="action === 'show'">{{ modelLabel }} Детали</h1>

        <!-- Таблица для индекса -->
        <CrudTable
            v-if="action === 'index'"
            :model="model"
            :fields="fields"
            :data="data"
            @delete="handleDelete"
        />

        <!-- Форма для создания и редактирования -->
        <CrudForm
            v-else-if="['create', 'edit'].includes(action)"
            :model="model"
            :fields="fields"
            :data="formData"
            @submit="handleSubmit"
        />

        <!-- Детали записи -->
        <CrudView
            v-else-if="action === 'show'"
            :model="model"
            :fields="fields"
            :data="data"
        />
    </div>
</template>

<script>
import axios from 'axios';
import CrudTable from '@/components/Crud/Table.vue';
import CrudForm from '@/components/Crud/Form.vue';
import CrudView from '@/components/Crud/View.vue';
import { useRouter } from 'vue-router';

export default {
    components: {
        CrudTable,
        CrudForm,
        CrudView,
    },
    props: {
        model: {
            type: String,
            required: true,
        },
        action: {
            type: String,
            required: true,
            validator: value => ['index', 'create', 'edit', 'show'].includes(value),
        },
        id: {
            type: [Number, String],
            default: null,
        },
    },
    data() {
        return {
            fields: [],
            data: [],
            formData: {},
        };
    },
    methods: {
        fetchData() {
            let url = `/api/${this.model}`;
            if (this.action === 'show' || this.action === 'edit') {
                url += `/${this.id}`;
            }

            axios.get(url)
                .then(response => {
                    if (this.action === 'index') {
                        this.data = response.data.data;
                        this.fields = response.data.fields;
                    } else if (['show'].includes(this.action)) {
                        this.data = response.data.data;
                        this.fields = response.data.fields;
                    } else if (['create', 'edit'].includes(this.action)) {
                        this.fields = response.data.fields;
                        if (this.action === 'edit') {
                            this.formData = response.data.data;
                        }
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.$router.push({ name: 'NotFound' });
                });
        },
        handleDelete(id) {
            axios.delete(`/api/${this.model}/${id}`)
                .then(() => {
                    this.fetchData();
                })
                .catch(error => {
                    console.error(error);
                });
        },
        handleSubmit(data) {
            if (this.action === 'create') {
                axios.post(`/api/${this.model}`, data)
                    .then(() => {
                        this.$router.push({ name: 'index', params: { model: this.model } });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else if (this.action === 'edit') {
                axios.put(`/api/${this.model}/${this.id}`, data)
                    .then(() => {
                        this.$router.push({ name: 'show', params: { model: this.model, id: this.id } });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },
    },
    mounted() {
        this.fetchData();
    },
};
</script>

<style scoped>

</style>
