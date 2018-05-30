<template>
    <div>
        <h1>{{ this.pageTitle }}</h1>
        <router-link :to="{ name: 'portfolio.add_trade'}" tag="button" class="btn btn-primary">
            <i class="fa fa-plush"></i> Add new trade
        </router-link>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Coin identifier</th>
                    <th>Amount</th>
                    <th>Price USD</th>
                    <th>Notes</th>
                    <th>Traded at</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="trade in this.trades">
                    <td>{{ trade.cryptocurrency_id }}</td>
                    <td>{{ trade.amount }}</td>
                    <td>{{ trade.price_usd }}</td>
                    <td>{{ trade.notes }}</td>
                    <td>{{ trade.traded_at }}</td>
                </tr>
            </tbody>
        </table>
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
                trades: null
            };
        },
        mounted: function mounted() {
            $('head title').html(this.pageTitle + " - " + siteName);
            axios.get(route('api.portfolio.index'))
                .then(response => {
                    this.trades = response.data;
                })
                .catch(e => {
                    this.$notify({
                        type: 'error',
                        title: 'Error occurs',
                        text: 'There was an error getting trades',
                    });
                });
        },
    };
</script>
