<template>
    <div>
        <div class="actions">
            <button v-if="canImport" @click="importData">{{ $t('import') }}</button>
            <button v-if="canExport" @click="exportData">{{ $t('export') }}</button>
            <button v-if="canBulkDelete && selected.length" @click="bulkDelete">{{ $t('bulk_delete') }}</button>
            <router-link :to="createRoute">{{ $t('create_user') }}</router-link>
        </div>

        <table>
            <thead>
            <tr>
                <th v-if="canBulkDelete"><input type="checkbox" @change="toggleSelectAll" /></th>
                <th v-for="field in fields" :key="field.name">{{ $t(field.label) }}</th>
                <th>{{ $t('actions') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in data" :key="item.id">
                <td v-if="canBulkDelete">
                    <input type="checkbox" v-model="selected" :value="item.id" />
                </td>
                <td v-for="field in fields" :key="field.name">{{ item[field.name] }}</td>
                <td>
                    <router-link :to="showRoute(item.id)">{{ $t('view') }}</router-link>
                    <router-link :to="editRoute(item.id)">{{ $t('edit') }}</router-link>
                    <button @click="deleteItem(item.id)">{{ $t('delete') }}</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';
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
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            selected: [],
            canBulkDelete: false,
            canImport: false,
            canExport: false,
        };
    },
    computed: {
        /**
         * Generate the create route URL based on the current model.
         */
        createRoute() {
            return route('create', { model: this.model });
        },
    },
    methods: {
        /**
         * Toggle selection of all records.
         *
         * @param {Event} event
         */
        toggleSelectAll(event) {
            if (event.target.checked) {
                this.selected = this.data.map(item => item.id);
            } else {
                this.selected = [];
            }
        },
        /**
         * Generate the show route URL for a specific record.
         *
         * @param {Number} id
         * @returns {String}
         */
        showRoute(id) {
            return route('show', { model: this.model, id });
        },
        /**
         * Generate the edit route URL for a specific record.
         *
         * @param {Number} id
         * @returns {String}
         */
        editRoute(id) {
            return route('edit', { model: this.model, id });
        },
        /**
         * Delete a specific record after confirmation.
         *
         * @param {Number} id
         */
        deleteItem(id) {
            if (confirm(this.$t('confirm_delete'))) {
                axios.delete(`/api/${this.model}/${id}`)
                    .then(() => {
                        this.$emit('delete', id);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },
        /**
         * Bulk delete selected records after confirmation.
         */
        bulkDelete() {
            if (confirm(this.$t('confirm_bulk_delete'))) {
                axios.post(`/api/${this.model}/bulk-delete`, { ids: this.selected })
                    .then(() => {
                        this.selected = [];
                        this.$emit('delete');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },
        /**
         * Trigger import action by opening a file dialog.
         */
        importData() {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = '.xlsx,.csv';
            fileInput.onchange = (e) => {
                const file = e.target.files[0];
                const formData = new FormData();
                formData.append('import_file', file);

                axios.post(`/api/${this.model}/import`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                    .then(() => {
                        alert(this.$t('import_success'));
                        this.$emit('delete'); // Trigger data refresh
                    })
                    .catch(error => {
                        console.error(error);
                        alert(this.$t('import_error'));
                    });
            };
            fileInput.click();
        },
        /**
         * Trigger export action by navigating to the export URL.
         */
        exportData() {
            window.location.href = `/api/${this.model}/export`;
        },
        /**
         * Fetch available operations for the current model.
         */
        fetchModelOperations() {
            axios.get(`/api/model-operations/${this.model}`)
                .then(response => {
                    this.canBulkDelete = response.data.canBulkDelete;
                    this.canImport = response.data.canImport;
                    this.canExport = response.data.canExport;
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
    mounted() {
        this.fetchModelOperations();
    },
};
</script>

<style scoped>
/* Add styles for table and buttons */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
}

.actions {
    margin-bottom: 10px;
}

button {
    margin-right: 5px;
}
</style>
