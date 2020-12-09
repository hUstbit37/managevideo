require('./bootstrap');
window.Vue = require('vue');

Vue.component('test-search', require('./components/TestSearch/TestSearch.vue').default);

import Vue from 'vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);
import Vuetify from 'vuetify';
Vue.use(Vuetify);

// * Import các component (App, home)

// import Header from './layouts/Header'
import App from './App.vue'
import Home from './components/views/Home.vue'
import Upload from './components/views/Upload.vue'
import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
import axios from 'axios';
import router from './routes.js'

// const router = new VueRouter({
//     mode: 'history',
//     routes
// });


const app = new Vue({
    vuetify: new Vuetify(),
    el: '#app',
    components: { App },
    router,

}).$mount('#app');
