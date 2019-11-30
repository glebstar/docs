import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './views/App';
import Home from './views/Home';
import DocumentsEdit from './views/DocumentsEdit';
import DocumentsCreate from './views/DocumentsCreate';
import NotFound from './views/NotFound';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/documents/:id/edit',
            name: 'documents.edit',
            component: DocumentsEdit
        },
        {
            path: '/documents/create',
            name: 'documents.create',
            component: DocumentsCreate
        },
        { path: '/404', name: '404', component: NotFound },
        { path: '*', redirect: '/404' },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
