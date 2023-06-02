import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { fileURLToPath, URL } from "url";

/** @type {import('vite').UserConfig} */
export default defineConfig(({ command, mode }) => {
    // Load env file based on `mode` in the current working directory.
    // Set the third parameter to '' to load all env regardless of the `VITE_` prefix.

    let inputFiles = [
        'resources/css/app.css',
        'resources/js/app.js',

        'resources/js/customization.js',

        'resources/views/admin/bills/assets/js/scripts.js',
        'resources/views/admin/bills/assets/css/styles.css',

        'resources/views/admin/dashboard/assets/js/scripts.js',
        'resources/views/admin/dashboard/assets/css/styles.css',
        'resources/css/blocks/custom-tooltip.scss',
    ];

    inputFiles = inputFiles.map(
        filePath => fileURLToPath(
            new URL(filePath, import.meta.url)
        )
    );

    return {
        // vite config
        plugins: [
            laravel({
                input: inputFiles,
                refresh: true,
            }),
        ],
        resolve: {
            alias: [
                { find: '@base', replacement: fileURLToPath(new URL('./', import.meta.url)) },
                { find: '@resources', replacement: fileURLToPath(new URL('./resources', import.meta.url)) },
                { find: '@public', replacement: fileURLToPath(new URL('./public', import.meta.url)) },
                { find: '@asset', replacement: fileURLToPath(new URL('./public', import.meta.url)) },
            ],
        },
        build: {
            cssCodeSplit: true,
        },
    }
})
