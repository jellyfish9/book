    <template id="accountEdit">
        <section class="page-component">
            <div v-if="showheader" class="bg-light p-3 mb-3">
                <div class="container">
                    <div class="row ">
                        <div  class="col-12 comp-grid" :class="setGridSize">
                            <h3 class="record-title">我的帐户</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="pb-2 mb-3 border-bottom">
                <div class="container">
                    <div class="row ">
                        <div  class="col-md-7 comp-grid" :class="setGridSize">
                            <div  class=" animated fadeIn">
                                <form  v-show="!loading" enctype="multipart/form-data" @submit="update()" class="form form-default" :action="'account/edit/' + data.id" method="post">
                                    <div class="form-group " :class="{'has-error' : errors.has('user_name')}">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="user_name">User Name <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input v-model="data.user_name"
                                                    v-validate="{required:true}"
                                                    data-vv-as="User Name"
                                                    class="form-control "
                                                    type="text"
                                                    name="user_name"
                                                    placeholder="Enter User Name"
                                                    />
                                                    <small v-show="errors.has('user_name')" class="form-text text-danger">
                                                        {{ errors.first('user_name') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button @click="update()" :disabled="errors.any()" class="btn btn-primary" type="button">
                                            <i class="load-indicator"><clip-loader :loading="saving" color="#fff" size="14px"></clip-loader> </i>
                                            {{submitbuttontext}}
                                            <i class="material-icons">send</i>
                                        </button>
                                    </div>
                                </form>
                                <div v-show="loading" class="load-indicator static-center">
                                    <span class="animator">
                                        <clip-loader :loading="loading" color="gray" size="20px">
                                        </clip-loader>
                                    </span>
                                    <h4 style="color:gray" class="loading-text">载入中...</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </template>
    <script>
	var AccountEditComponent = Vue.component('accountEdit', {
		template : '#accountEdit',
		mixins: [EditPageMixin],
		props: {
			pagename : {
				type : String,
				default : 'user',
			},
			routename : {
				type : String,
				default : 'useraccountedit',
			},
			apipath : {
				type : String,
				default : 'account/edit',
			},
		},
		data: function() {
			return {
				data : { user_name: '', },
			}
		},
		computed: {
			pageTitle: function(){
				return '我的帐户';
			},
		},
		methods: {
			actionAfterUpdate : function(response){
				this.$root.$emit('requestCompleted' , this.msgafterupdate);
				if(!this.ismodal){
								window.location.href = '#/account';
								window.location.reload(); 
				}
			},
		},
		watch: {
			id: function(newVal, oldVal) {
				if(this.id){
					this.load();
				}
			},
			modelBind: function(){
				var binds = this.modelBind;
				for(key in binds){
					this.data[key]= binds[key];
				}
			},
			pageTitle: function(){
				this.SetPageTitle( this.pageTitle );
			},
		},
		created: function(){
			this.SetPageTitle(this.pageTitle);
		},
		mounted: function() {
			//this.load();
		},
	});
	</script>
