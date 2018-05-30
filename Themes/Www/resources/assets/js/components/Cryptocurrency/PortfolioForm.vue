<template>
    <div>
        <h1>{{ this.pageTitle }}</h1>
        <form @submit.prevent="submit">
            <div class="row form-group">
                <div class="col-lg-12">
                    <select v-model="trade.cryptocurrency_id" class="coin-id-select form-control"></select>
                    <template v-for="error in this.form.errors.get('cryptocurrency_id')">
                        <div class="text-danger"><small>{{ error }}</small></div>
                    </template>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div v-bind:class="{ 'has-error': this.form.errors.has('amount') }" class="form-group has-feedback">
                        <label>Amount</label>
                        <input v-model="trade.amount" 
                            type="number"
                            class="form-control" 
                            required="required" />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <template v-for="error in this.form.errors.get('amount')">
                            <div class="text-danger"><small>{{ error }}</small></div>
                        </template>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div v-bind:class="{ 'has-error': this.form.errors.has('price_usd') }" class="form-group has-feedback">
                        <label>Price USD</label>
                        <input v-model="trade.price_usd" 
                            type="number"
                            class="form-control" 
                            min="0"
                            required="required" />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <template v-for="error in this.form.errors.get('price_usd')">
                            <div class="text-danger"><small>{{ error }}</small></div>
                        </template>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div v-bind:class="{ 'has-error': this.form.errors.has('traded_at') }" class="form-group has-feedback">
                        <label>Traded at</label>
                        <div class="form-row">
                            <div class="col">
                                <input v-model="traded_at_date" 
                                    type="date"
                                    class="form-control" 
                                    placeholder="Traded at date" 
                                    required="required" />
                            </div>
                            <div class="col">
                                <input v-model="traded_at_time" 
                                    type="time"
                                    class="form-control" 
                                    placeholder="Traded at time" 
                                    required="required" />
                            </div>
                        </div>
                        <template v-for="error in this.form.errors.get('traded_at')">
                            <div class="text-danger"><small>{{ error }}</small></div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div v-bind:class="{ 'has-error': this.form.errors.has('notes') }" class="form-group has-feedback">
                        <label>Notes (optional)</label>
                        <textarea v-model="trade.notes" 
                            class="form-control"></textarea>
                        <template v-for="error in this.form.errors.get('notes')">
                            <div class="text-danger"><small>{{ error }}</small></div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Add trade</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    import Form from 'form-backend-validation';

    function formatCoin(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__coin'>" + repo.name + "</div>" + 
        "</div></div>";

        return markup;
    }

    function formatCoinSelection(repo) {
        if (typeof repo.text !== "undefined" && repo.text != "") {
            return repo.text;
        }
        return repo.name;
    }

    export default {
        props: {
            pageTitle: { default: null, String },
        },
        data() {
            return {
                traded_at_date: '',
                traded_at_time: '',
                trade: {
                    cryptocurrency_id: null,
                    amount: 0,
                    price_usd: 0,
                    traded_at: '',
                    notes: '',
                },
                form: new Form(),
            };
        },
        methods: {
            submit() {
                this.trade.traded_at = `${this.traded_at_date} ${this.traded_at_time}:00`;
                this.form = new Form(this.trade);
                this.form.errors.clear();
                this.form.post(route('api.portfolio.store'))
                    .then((response) => {
                        this.$notify({
                            type: 'success',
                            title: 'Traded added',
                            text: 'Traded added correctly.'
                        });
                        this.$router.replace({ name: 'portfolio.index'});
                    });
            },
            startCoinsSelect() {
                var self = this;
                $('.coin-id-select').select2({
                    placeholder: 'Select a coin',
                    ajax: {
                        url: route('api.coins.index'),
                        dataType: "json",
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term, // search term
                                page: params.page
                            };
                        },
                        processResults: function (data, params) {
                            // parse the results into the format expected by Select2
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data, except to indicate that infinite
                            // scrolling can be used
                            params.page = params.page || 1;

                            return {
                                results: data.data,
                                pagination: {
                                    more: (params.page * 15) < data.total
                                }
                            };
                        },
                        cache: false
                    },
                    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                    minimumInputLength: 0,
                    templateResult: formatCoin, // omitted for brevity, see the source of this page
                    templateSelection: formatCoinSelection, // omitted for brevity, see the source of this page
                }).on("select2:selecting", function(e) { 
                   // what you would like to happen
                   self.trade.cryptocurrency_id = e.params.args.data.id;
                });
            },
        },
        mounted: function mounted() {
            $('head title').html(this.pageTitle + " - " + siteName);
            this.startCoinsSelect();
        },
    };
</script>

<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 35px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 35px;
    }
</style>
