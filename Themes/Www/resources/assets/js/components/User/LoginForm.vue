<template>
    <div class="login-box">
        <form @submit.prevent="login">
            <div v-bind:class="{ 'has-error': this.form.errors.has('email') }"  class="form-group has-feedback">
                <input v-model="auth.email" 
                    type="email" 
                    class="form-control" 
                    placeholder="Email" 
                    required="required" />
                <template v-for="error in this.form.errors.get('email')">
                    <div class="text-danger"><small>{{ error }}</small></div>
                </template>
            </div>
            <div v-bind:class="{ 'has-error': this.form.errors.has('password') }" class="form-group has-feedback">
                <input v-model="auth.password" 
                    type="password" 
                    class="form-control" 
                    placeholder="Password" 
                    required="required" />
                <template v-for="error in this.form.errors.get('password')">
                    <div class="text-danger"><small>{{ error }}</small></div>
                </template>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" v-model="auth.remember"> Remember me
                        </label>
                    </div>
                </div>
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    import select2 from 'select2'
    import Form from 'form-backend-validation';

    export default {
        props: {
            pageTitle: { default: null, String },
        },
        data() {
            return {
                auth: {
                    email : '',
                    password : '',
                    remember: false,
                },
                form: new Form(),
            };
        },
        methods: {
            login() {
                this.form = new Form(this.auth);
                this.form.errors.clear();
                this.form.post(route('api.users.login'))
                    .then((response) => {
                        this.$auth.setTokenData(response, this.auth.remember);
                        this.$notify({
                            type: 'success',
                            title: 'Login correct',
                            text: 'Logged in correct.'
                        });
                        this.$router.replace({ name: 'portfolio.index'});
                    });
            }
        },
        mounted: function mounted() {
            $('head title').html(this.pageTitle + " - " + siteName);
        },
    };
</script>
