    <template id="Register">
        <section class="page-component">
            <div v-if="showheader" class="bg-light p-3 mb-3">
                <div class="container">
                    <div class="row ">
                        <div  class="col-md-6 comp-grid" :class="setGridSize">
                            <h3 class="record-title">用户注册</h3>
                        </div>
                        <div  class="col-md-6 comp-grid" :class="setGridSize">
                            <div class="">
                                <div class="text-right">
                                    已经有账号？  <router-link class="btn btn-primary" to="/"> 登录 </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="pb-2 mb-3 border-bottom">
                <div class="container">
                    <div class="row ">
                        <div  class="col-md-7 comp-grid" :class="setGridSize">
                            <div  class=" animated fadeIn">
                                <form enctype="multipart/form-data" @submit="save" class="form form-default" action="" method="post">
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
                                    <div class="form-group " :class="{'has-error' : errors.has('password')}">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="password">Password <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input v-model="data.password"
                                                    v-validate="{required:true}"
                                                    data-vv-as="Password"
                                                    class="form-control "
                                                    type="password"
                                                    name="password"
                                                    placeholder="Enter Password"
                                                    />
                                                    <small v-show="errors.has('password')" class="form-text text-danger">
                                                        {{ errors.first('password') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group " :class="{'has-error' : errors.has('confirm_password')}">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input
                                                    v-model="data.confirm_password"
                                                    v-validate="{ required:true, confirmed:'password' }"
                                                    data-vv-as="Confirm Password"
                                                    class="form-control "
                                                    type="password"
                                                    name="confirm_password"
                                                    placeholder="Confirm Password"
                                                    />
                                                    <small v-show="errors.has('confirm_password')" class="form-text text-danger">{{ errors.first('confirm_password') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group " :class="{'has-error' : errors.has('email')}">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="email">Email <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input v-model="data.email"
                                                    v-validate="{required:true,  email:true}"
                                                    data-vv-as="Email"
                                                    class="form-control "
                                                    type="email"
                                                    name="email"
                                                    placeholder="Enter Email"
                                                    />
                                                    <small v-show="errors.has('email')" class="form-text text-danger">
                                                        {{ errors.first('email') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="text-center">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="load-indicator"><clip-loader :loading="saving" color="#fff" size="14px"></clip-loader> </i>
                                            {{submitbuttontext}}
                                            <i class="material-icons">send</i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </template>
    <script>
	var RegisterComponent = Vue.component('Register', {
		template : '#Register',
		mixins: [AddPageMixin],
		props:{
			pagename : {
				type : String,
				default : 'user',
			},
			routename : {
				type : String,
				default : 'useruserregister',
			},
			apipath : {
				type : String,
				default : 'index/register',
			},
		},
		data : function() {
			return {
				id : {
					type : String,
					default : '',
				},
				data : {
					user_name: '',password: '',confirm_password: '',email: '',
				},
			}
		},
		computed: {
			pageTitle: function(){
				return '添新';
			},
		},
		methods: {
			actionAfterSave : function(response){
				this.$root.$emit('requestCompleted' , this.msgaftersave);
				window.location = response.body;
			},
			resetForm : function(){
				this.data = {user_name: '',password: '',confirm_password: '',email: '',};
				this.$validator.reset();
			},
		},
		mounted : function() {
		},
	});
	</script>
