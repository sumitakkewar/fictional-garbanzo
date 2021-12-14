import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)


const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('./../components/NonAuth/Login.vue')
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('./../components/NonAuth/Register.vue')
    },
    {
        path: '/services',
        name: 'services',
        component: () => import('./../components/Auth/Services.vue'),
        meta: {
            authRequired: true
        }
    },
    {
        path: '/service/:id',
        name: 'service',
        component: () => import('./../components/Auth/Service.vue'),
        meta: {
            authRequired: true
        }
    },
    {
        path: '/appointments',
        name: 'appointments',
        component: () => import('./../components/Auth/Appointments.vue'),
        meta: {
            authRequired: true
        }
    },
    {
        path: '/jobs',
        name: 'jobs',
        component: () => import('./../components/Auth/Jobs.vue'),
        meta: {
            authRequired: true
        }
    }
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

// GOOD
router.beforeEach((to, from, next) => {
    // console.log({ to, from, next });
    const isAuthenticated = localStorage.getItem('Auth');
    if (to.meta !== undefined && to.meta.authRequired) {
        if (!isAuthenticated) {
            next({ name: 'home' });
        } else {
            next()
        }
    } else {
        if (isAuthenticated) {
            next({ name: 'services' });
        } else if (to.matched.length == 0) {
            next({ name: 'home' });
        } else {
            next();
        }
    }
    // if ((to.name !== 'home' || to.name !== 'register') && !isAuthenticated) next({ name: 'home' })
    // else if ((to.name === 'home' || to.name === 'register') && isAuthenticated) next({ name: 'services' })
    // else next()
})

export default router
