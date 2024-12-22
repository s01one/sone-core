<template>
    <div>
        <form @submit.prevent="submitForm">
            <div v-for="field in fields" :key="field.name" class="form-group">
                <label :for="field.name">{{ field.label }}</label>
                <component
                    :is="getComponent(field.type)"
                    :id="field.name"
                    v-model="formData[field.name]"
                    v-bind="field.attributes || {}"
                >
                    <template v-if="field.type === 'select'" v-slot:default>
                        <option v-for="option in field.options" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </template>
                </component>
                <span v-if="errors[field.name]" class="error">{{ errors[field.name][0] }}</span>
            </div>
            <button type="submit">Сохранить</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';
import SelectField from '@/components/Crud/Fields/Select.vue';

export default {
    components: {
        'select-field': SelectField,
    },
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
            default: () => ({}),
        },
        action: {
            type: String,
            required: true,
        },
        id: {
            type: [Number, String],
            default: null,
        },
    },
    setup(props, { emit }) {
        const formData = ref({ ...props.data });
        const errors = ref({});

        const getComponent = (type) => {
            switch (type) {
                case 'text':
                case 'email':
                case 'number':
                case 'date':
                    return 'input';
                case 'textarea':
                    return 'textarea';
                case 'select':
                    return 'select-field';
                default:
                    return 'input';
            }
        };

        const submitForm = () => {
            errors.value = {};

            let url = `/api/${props.model}`;
            let method = 'post';

            if (props.action === 'edit' && props.id) {
                url += `/${props.id}`;
                method = 'put';
            }

            axios[method](url, formData.value)
                .then(() => {
                    emit('submit');
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        errors.value = error.response.data.errors;
                    } else {
                        console.error(error);
                    }
                });
        };

        return {
            formData,
            errors,
            getComponent,
            submitForm,
        };
    },
};
</script>

<style scoped>
.form-group {
    margin-bottom: 15px;
}

.error {
    color: red;
    font-size: 0.9em;
}
</style>
