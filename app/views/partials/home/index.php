        <template id="Home">
            <div>
                <div  class="pb-2 mb-3 border-bottom">
                    <div class="container">
                        <div class="row ">
                            <div  class="col-md-12 comp-grid" :class="setGridSize">
                            </div>
                        </div>
                    </div>
                </div>
                <div  class="bg-light p-3 mb-3">
                    <div class="container">
                        <div class="row ">
                            <div  class="col-md-12 comp-grid" :class="setGridSize">
                                <h3 >仪表板</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <script>
			var HomeComponent = Vue.component('HomeComponent', {
				template : '#Home',
				props: {
					resetgrid : {
						type : Boolean,
						default : false,
					},
				},
				data : function() {
					return {
						loading : false,
						ready: false,
					}
				},
				computed: {
					setGridSize: function(){
						if(this.resetgrid){
							return 'col-sm-12 col-md-12 col-lg-12';
						}
					}
				},
				methods : {

				},
				mounted : function() {
					this.ready = true;
				},
			});
		</script>
	