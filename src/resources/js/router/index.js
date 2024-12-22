import { createRouter, createWebHistory } from 'vue-router';
import General from '@/layouts/General.vue';
import NotFound from '@/pages/errors/NotFound.vue';
import axios from 'axios';

/**
 * Fetch the prefix from the global window.app variable
 */
const prefixWeb = window.app.prefixWeb || 'admin'; // Default to 'admin' if not set

/**
 * Function to fetch available models from the backend
 * @returns {Promise<Array>} - A promise that resolves to an array of model names
 */
const fetchModels = async () => {
    try {
        const response = await axios.get('/api/models');
        return response.data; // Assuming the response is an array of model names
    } catch (error) {
        console.error('Error fetching models:', error);
        return [];
    }
};

/**
 * Function to dynamically create routes based on fetched models
 * @param {Array} models - Array of model names
 * @returns {Array} - Array of route objects
 */
const createDynamicRoutes = (models) => {
    return models.flatMap(model => ([
        {
            path: `/${prefixWeb}/${model}`,
            name: `${model}.index`,
            component: General,
            props: { model, action: 'index' },
        },
        {
            path: `/${prefixWeb}/${model}/create`,
            name: `${model}.create`,
            component: General,
            props: { model, action: 'create' },
        },
        {
            path: `/${prefixWeb}/${model}/:id`,
            name: `${model}.show`,
            component: General,
            props: route => ({
                model: route.params.model || model,
                action: 'show',
                id: route.params.id
            }),
        },
        {
            path: `/${prefixWeb}/${model}/:id/edit`,
            name: `${model}.edit`,
            component: General,
            props: route => ({
                model: route.params.model || model,
                action: 'edit',
                id: route.params.id
            }),
        },
    ]));
};

/**
 * Initialize and return the router with dynamic routes
 * @returns {Promise<Router>} - A promise that resolves to the router instance
 */
const initRouter = async () => {
    const models = await fetchModels();
    const dynamicRoutes = createDynamicRoutes(models);

    const routes = [
        // Add any static routes here if necessary

        // Add dynamic routes
        ...dynamicRoutes,

        // 404 Not Found route
        {
            path: '/:pathMatch(.*)*',
            name: 'NotFound',
            component: NotFound,
        },
    ];

    return createRouter({
        history: createWebHistory(),
        routes,
    });
};

export default initRouter;
