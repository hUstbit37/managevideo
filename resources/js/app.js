
require('./bootstrap');
window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('test-search', require('./components/TestSearch/TestSearch.vue').default);

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// * Import các component (App, home, about, service, contact)

import Header from './layouts/Header'
import App from './views/App'
import Home from './views/Home'

import Login from './Auth/Login'
import Register from './Auth/Register'
import axios from 'axios';

// import VueAuth from '@websanova/vue-auth'
// import VueAxios from 'vue-axios';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },

        {
            path: '/login',
            name: 'login',

            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
    ],
});


const app = new Vue({
    el: '#app',
    components: { App },
    router,

}).$mount('#app');

