/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */



//assets/app.js
import { createInertiaApp } from '@inertiajs/inertia-vue'
import Vue from "vue";
import "../node_modules/@fortawesome/fontawesome-free/css/all.css";
import './styles/app.scss';

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, app, props }) {
        new Vue({
            render: h => h(app, props),
        }).$mount(el)
    },
})




