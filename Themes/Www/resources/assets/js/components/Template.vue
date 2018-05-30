<template>
    <div>
    	<notifications position="top right" />
    	<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<router-link :to="{ name: 'home'}" class="nav-link">Home</router-link>
					</li>
					<li class="nav-item">
						<router-link :to="{ name: 'coins.index'}" class="nav-link">Coins</router-link>
					</li>
					<template v-if="!this.$auth.isAuthenticated()">
						<li class="nav-item">
							<router-link :to="{ name: 'users.login'}" class="nav-link">Login</router-link>
						</li>
					</template>
					<template v-if="this.$auth.isAuthenticated()">
						<li class="nav-item">
							<router-link :to="{ name: 'portfolio.index'}" class="nav-link">Portfolio</router-link>
						</li>
					</template>
				</ul>
				<span class="navbar-text" v-if="this.$auth.isAuthenticated()">
					<a @click="logout" class="logout-link">Logout</a>
			    </span>
			</div>
		</nav>
		<div class="container">
        	<router-view></router-view>
		</div>
    </div>
</template>

<script>
	export default {
    	methods: {
			logout: function () {
				this.$auth.removeTokenData();
				this.$router.go(0);
			}
		}
    };
</script>

<style>
	.container {
		padding-top: 30px;
		padding-bottom: 30px;
	}
	a.logout-link {
		cursor: pointer;
		color: rgba(0,0,0,.5);
	}
</style>