import './bootstrap';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin:inertia';
import ReactDOMServer from 'react-dom/server';
import React from 'react';

// Import Alpine for interactivity
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Initialize Inertia app
createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ App, props }) {
        // This creates a React app that can be client-side rendered
        // For SSR, we need ReactDOMServer.renderToString
    },
});
