<template>
    <div>
        <h1>{{ this.pageTitle }}</h1>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Price USD</th>
                    <th>Price BTC</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="coin in this.coins.data">
                    <td>{{ coin.id }}</td>
                    <td>{{ coin.name }}</td>
                    <td>{{ coin.rank }}</td>
                    <td>{{ coin.price_usd }}</td>
                    <td>{{ coin.price_btc }}</td>
                    <td>
                        <router-link :to="{ name: 'coins.show', params: { id: coin.id }}" class="nav-link">
                            <i class="fa fa-eye"></i>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
        <nav v-if="this.coins.data">
            <ul class="pagination">
                <li class="page-item" v-if="this.coins.current_page != 1">
                    <router-link :to="{ name: 'coins.index', query: { page: this.coins.current_page - 1 }}" class="nav-link">
                        Previous
                    </router-link>
                </li>
                <li class="page-item" v-if="this.coins.current_page != this.coins.last_page">
                    <router-link :to="{ name: 'coins.index', query: { page: this.coins.current_page + 1 }}" class="nav-link">
                        Next
                    </router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: {
            pageTitle: { default: null, String },
        },
        data() {
            return {
                prevPage: 3,
                nextPages: 3,
                coins: [],
                errors: []
            };
        },
        methods: {
            getCoins(page) {
                page = typeof page === 'undefined' ? 1 : page;
                axios.get(route('api.coins.index', {'page': page}))
                    .then(response => {
                        this.coins = response.data;
                    })
                    .catch(e => {
                        this.$notify({
                            type: 'error',
                            title: 'Error occurs',
                            text: 'There was an error getting coins data',
                        });
                    });
            }
        },
        watch: {
            '$route' (to, from) {
                this.getCoins(to.query.page);
            }
        },
        mounted: function mounted() {
            $('head title').html(this.pageTitle + " - " + siteName);
            this.getCoins(this.$route.query.page);
        },
    };
</script>
