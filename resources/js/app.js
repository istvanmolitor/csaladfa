import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';

// Import routes from packages
import adminRoutes from '@vue-admin/router';
import mediaRoutes from '@vue-media/router';
import userRoutes from '@vue-user/router';

// Combine routes
const routes = [
    ...adminRoutes,
    ...mediaRoutes,
    ...userRoutes,
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);
app.use(router);
app.mount('#app');

console.log('Admin SPA inicializálva.');
