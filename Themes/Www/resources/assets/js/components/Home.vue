<template>
	<div>
		<p>Welcome to the creativehothouse test.</p>
		<p>The application consists on:</p>
		<ul class="list-group">
			<li class="list-group-item">List of coins</li>
			<li class="list-group-item">Detail of coins</li>
			<li class="list-group-item">Coin price history</li>
			<li class="list-group-item">User portfolio</li>
		</ul>
	</div>
</template>

<script>
    export default {
    	props: {
            pageTitle: { default: null, String },
        },
    	mounted: function mounted() {
            $('head title').html(this.pageTitle + " - " + siteName);
        },
    };
</script>