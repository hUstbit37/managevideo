require('./bootstrap');
window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('test-search', require('./components/TestSearch/TestSearch.vue').default);

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// * Import các component (App, home)

// import Header from './layouts/Header'
import App from './App.vue'
import Home from './components/views/Home.vue'
import Upload from './components/views/Upload.vue'
import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
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
        {
            path: '/upload',
            name: 'upload',
            component: Upload,
        },
    ],
});


const app = new Vue({
    el: '#app',
    components: { App },
    router,

}).$mount('#app');