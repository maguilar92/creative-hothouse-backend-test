import TemplateComponent from '../../components/Template.vue'
import CoinsIndexComponent from '../../components/Cryptocurrency/CoinsIndex.vue'
import CoinsShowComponent from '../../components/Cryptocurrency/CoinsShow.vue'
import CoinHistoricalComponent from '../../components/Cryptocurrency/CoinHistorical.vue'
import PortfolioIndexComponent from '../../components/Cryptocurrency/PortfolioIndex.vue'
import PortfolioFormComponent from '../../components/Cryptocurrency/PortfolioForm.vue'

export default [
	{
        path: '/',
        component: TemplateComponent,
        props: {},
        children : [
			{
		        path: '/coins',
		        name: 'coins.index',
		        component: CoinsIndexComponent,
		        props: {
		            pageTitle: 'Coins page',
		        },
		    },
		    {
		        path: '/coins/:id',
		        name: 'coins.show',
		        component: CoinsShowComponent,
		        props: {
		            pageTitle: 'Coins page',
		        },
		    },
		    {
		        path: '/coins/:id/historical',
		        name: 'coin.historical',
		        component: CoinHistoricalComponent,
		        props: {
		            pageTitle: 'Coin historical',
		        },
		    },
		    {
		        path: '/portfolio',
		        name: 'portfolio.index',
		        component: PortfolioIndexComponent,
		        props: {
		            pageTitle: 'Portfolio',
		        },
		        meta: { requiresAuth: true }
		    },
		    {
		        path: '/portfolio/add-trade',
		        name: 'portfolio.add_trade',
		        component: PortfolioFormComponent,
		        props: {
		            pageTitle: 'Add trade',
		        },
		        meta: { requiresAuth: true }
		    },
        ],
    }
];
