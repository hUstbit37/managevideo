import Vue from "vue";
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import Home from './components/views/Home.vue'
import Upload from './components/views/Upload.vue'
import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
import Admin from './components/admin/Admin.vue'
import Category from './components/admin/Category.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: { requiresAuth: true }
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
            meta: { requiresAuth: true }
        },
        {
            path: '/admin',
            name: 'admin',
            component: Admin,
            // meta: { requiresAuth: true }
            children:[
                {
                    path: '/category',
                    name: 'category',
                    component: Category,
                },
            ]
        },

    ]
});
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!localStorage.getItem("Video4You.jwt")) {
            next({
                path: "/login",
                query: { redirect: to.fullPath }
            });
        } else {
            next();
        }
    } else {
        next(); // make sure to always call next()!
    }
});
export default router;

