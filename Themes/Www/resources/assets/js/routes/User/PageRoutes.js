import TemplateComponent from '../../components/Template.vue'
import UsersLoginFormComponent from '../../components/User/LoginForm.vue'

export default [
	{
        path: '/',
        component: TemplateComponent,
        props: {},
        children : [
			{
		        path: '/users/login',
		        name: 'users.login',
		        component: UsersLoginFormComponent,
		        props: {
		            pageTitle: 'Login page',
		        },
		    },
        ],
    }
];
