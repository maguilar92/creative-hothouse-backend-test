<template>
	<div>
		<h1>Sorry, the page you are looking for could not be found.</h1>
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