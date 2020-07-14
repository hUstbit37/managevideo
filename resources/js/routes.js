import Home from './components/views/Home.vue'
import Upload from './components/views/Upload.vue'
import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'

export const routes = [
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
];
