<template id="ComponentNotFound">
	<div class="container">
		<div class="text-center jumbotron" style="margin:5% 0">
			<h1 class="text-danger">404</h1>
			<h4 class="text-dark text-bold">Page Not Found</h4>
			<div class="text-muted my-3"><small>The requested component was not found.</small></div>
			<div class="text-center">
				<a href="<?php print_link('') ?>" class="btn btn-primary">Home</a>
			</div>
		</div>
	</div>
</template>

<script>
	var ComponentNotFound = Vue.component('ComponentNotFound', {
		template:'#ComponentNotFound',
		data: function() {
			return {
				currentpath : '',
			}
		},
		watch : {
			'$route' : function(to , from){
				this.currentpath = to.path;
			},
		},
	});
</script>