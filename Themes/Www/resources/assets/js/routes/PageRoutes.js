import TemplateComponent from '../components/Template.vue'
import HomeComponent from '../components/Home.vue';
import NotFoundComponent from '../components/NotFound.vue';

export default [
    {
        path: '/',
        component: TemplateComponent,
        props: {},
        children : [
            {
                path: '/',
                name: 'home',
                component: HomeComponent,
                props: {
                    pageTitle: 'Home',
                },
            },
            {
                path: '*',
                name: '404',
                component: NotFoundComponent,
                props: {
                    pageTitle: '404',
                },
            },
        ],
    },
];
