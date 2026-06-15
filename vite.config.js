import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS base
                'resources/css/app.css',
                'resources/css/nav/nav-logo.css',
                'resources/css/nav/nav-auth.css',
                'resources/css/layout/sidebar.css',
                'resources/css/common/typography.css',
                'resources/css/public/catalog.css',

                // JS base
                'resources/js/app.js',

                // Auth
                'resources/js/auth/register.js',
                'resources/js/auth/login.js',
                'resources/js/auth/logout.js',

                // Layout
                'resources/js/layout/sidebar.js',

                // Public
                'resources/js/public/catalog/catalog-page.js',

                // Provider
                'resources/js/provider/profile/update.js',
                'resources/js/provider/product/page/index.js',

                // Admin
                'resources/js/admin/user/index.js',
                'resources/js/admin/user/approve-reject.js',

                // Support
                'resources/js/support/pages/provider.page.js',
                'resources/js/support/pages/admin.page.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
