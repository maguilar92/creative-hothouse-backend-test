require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Notifications from 'vue-notification'
import Auth from './classes/Auth';
import UserRoutes from './routes/User/PageRoutes';
import CryptocurrencyRoutes from './routes/Cryptocurrency/PageRoutes';
import GlobalRoutes from './routes/PageRoutes';

Vue.use(VueRouter);
Vue.use(Notifications);

let $auth = new Auth();

Vue.prototype.$auth = $auth;

Vue.directive('loading', {
    bind: function bind(el, binding) {
        var mask = new Mask({
            el: document.createElement('div'),
            data: {
                text: el.getAttribute('element-loading-text'),
                fullscreen: !!binding.modifiers.fullscreen
            }
        });
        el.instance = mask;
        el.mask = mask.$el;
        el.maskStyle = {};

        toggleLoading(el, binding);
    },

    update: function update(el, binding) {
        el.instance.setText(el.getAttribute('element-loading-text'));
        if (binding.oldValue !== binding.value) {
            toggleLoading(el, binding);
        }
    },

    unbind: function unbind(el, binding) {
        if (el.domInserted) {
            if (binding.modifiers.fullscreen || binding.modifiers.body) {
                document.body.removeChild(el.mask);
            } else {
                el.mask && el.mask.parentNode && el.mask.parentNode.removeChild(el.mask);
            }
        }
    }
});

const router = new VueRouter({
    mode: 'history',
    base: '',
    routes: [
        ...UserRoutes,
        ...CryptocurrencyRoutes,
        ...GlobalRoutes
    ],
});

//Check if url requires authenticatetion
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!$auth.isAuthenticated()) {
            next({
                name: 'users.login'
            })
        } else {
            next()
        }
    } else {
        next() // make sure to always call next()!
    }
});

const app = new Vue({
    el: '#app',
    router,
});


window.axios.interceptors.response.use(null, (error) => {
    if (error.response === undefined) {
        return;
    }
    if (error.response.status === 403) {
        app.$notify({
            type: 'error',
            title: 'Access denied',
            text: 'You do not have the necessary permissions to access this resource.',
        });
        router.go(-1);
    }
    if (error.response.status === 401) {
        app.$notify({
            type: 'error',
            title: 'Wrong login',
            text: 'The data entered does not correspond to any user of the system.',
        });
        router.replace({ name: 'users.login'});
    }
    return Promise.reject(error);
});