// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */

// import './bootstrap';
// import { createApp } from 'vue';

// /**
//  * Next, we will create a fresh Vue application instance. You may then begin
//  * registering components with the application instance so they are ready
//  * to use in your application's views. An example is included for you.
//  */

// const app = createApp({});

// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);

// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */

// // Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
// //     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// // });

// /**
//  * Finally, we will attach the application instance to a HTML element with
//  * an "id" attribute of "app". This element is included with the "auth"
//  * scaffolding. Otherwise, you will need to add an element yourself.
//  */

// app.mount('#app');

/**
 * plugins/vuetify.js
 *
 * Framework documentation: https://vuetifyjs.com`
 */

import { createApp } from "vue";
import App from "./components/App.vue";
import router from "../js/router";
import pinia from "../js/store";

// Vuetify
import '@mdi/font/css/materialdesignicons.css'
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { useLoginStore } from "../../resources/js/store/Login/login";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const vuetify = createVuetify({
    components,
    directives,
});

const app = createApp(App);
app.use(router);
app.use(vuetify);
app.use(pinia);
app.component('Datepicker', Datepicker);
// Initialize the store to retrieve the initial isLoggedIn state from the persistent storage mechanism
useLoginStore().initialize();
app.mount("#app");
