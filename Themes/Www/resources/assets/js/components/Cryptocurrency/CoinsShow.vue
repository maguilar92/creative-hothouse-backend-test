<template>
    <div>
        <h1>{{ this.coin.name }}</h1>
        <ul>
            <li v-for="value,key in this.coin">
                <b>{{ key }}</b>: {{ value }}
            </li>
        </ul>
        <router-link :to="{ name: 'coin.historical', params: { id: this.$route.params.id }}" class="nav-link">
            Show historical
        </router-link>
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
                coin: null
            };
        },
        mounted: function mounted() {
            axios.get(route('api.coins.show', {'id': this.$route.params.id}))
                .then(response => {
                    this.coin = response.data;
                    $('head title').html(this.coin.name + " - " + siteName);
                })
                .catch(e => {
                    this.$notify({
                        type: 'error',
                        title: 'Error occurs',
                        text: 'There was an error getting coin data',
                    });
                });
        },
    };
</script>
