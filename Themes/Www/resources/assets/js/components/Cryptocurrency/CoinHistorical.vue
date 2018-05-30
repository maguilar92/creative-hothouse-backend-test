<template>
    <div>
        <h1>{{ this.pageTitle }}</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Snapshot at</th>
                    <th>Price USD</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="historical in this.historical">
                    <td>{{ historical.snapshot_at }}</td>
                    <td>{{ historical.price_usd }}</td>
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
                historical: null
            };
        },
        mounted: function mounted() {
            $('head title').html(this.pageTitle + " - " + siteName);
            axios.get(route('api.coin.historical', {'id': this.$route.params.id}))
                .then(response => {
                    this.historical = response.data;
                })
                .catch(e => {
                    this.$notify({
                        type: 'error',
                        title: 'Error occurs',
                        text: 'There was an error getting coin historical',
                    });
                });
        },
    };
</script>
