import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import FamilyMemberManager from './components/family/FamilyMemberManager.vue';

// Import routes from packages
import adminRoutes from '@vue-admin/router';
import mediaRoutes from '@vue-media/router';
import themeRoutes from '@vue-theme/router';
import userRoutes from '@vue-user/router';

// Register menu builders from JS packages
import { menuRegistry } from '@menu';
import { AdminMenuBuilder } from '@vue-admin';
import { mediaMenuBuilder } from '@vue-media';
import { themeMenuBuilder } from '@vue-theme';
import { userMenuBuilder } from '@vue-user';

const registerPackageMenus = () => {
    menuRegistry.clear();
    menuRegistry.register(new AdminMenuBuilder());
    menuRegistry.register(mediaMenuBuilder);
    menuRegistry.register(themeMenuBuilder);
    menuRegistry.register(userMenuBuilder);
};

registerPackageMenus();

// Combine routes
const routes = [
    ...adminRoutes,
    ...mediaRoutes,
    ...themeRoutes,
    ...userRoutes,
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const isSPA = window.location.pathname.startsWith('/admin') ||
              window.location.pathname === '/login' ||
              window.location.pathname === '/register' ||
              window.location.pathname === '/dashboard';

if (isSPA) {
    const app = createApp(App);
    app.component('FamilyMemberManager', FamilyMemberManager);
    app.use(router);
    app.mount('#app');
    console.log('Admin SPA inicializálva.');
} else {
    // Csak a komponenseket regisztráljuk a Blade nézetekhez
    const appElement = document.getElementById('app');
    if (appElement) {
        const app = createApp({});
        app.component('FamilyMemberManager', FamilyMemberManager);
        app.mount('#app');
        console.log('Vue komponensek inicializálva a Blade-hez.');
    }
}
