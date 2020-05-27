        <template id="Index">
            <div>
                <div  class="pb-2 mb-3 border-bottom my-4">
                    <div class="container">
                        <div class="row ">
                            <div  class="col-sm-8 comp-grid" :class="setGridSize">
                                <div class="">
                                    <div class="fadeIn animated mb-4">
                                        <div class="text-capitalize">
                                            <h2 class="text-capitalize">欢迎来到 <?php echo SITE_NAME ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  class="col-sm-4 comp-grid" :class="setGridSize">
                                <div  class="bg-light card card-body animated fadeIn">
                                    <h4><i class="material-icons">lock_open</i> 用户登录</h4>
                                    <hr />
                                    <form name="loginForm" action="<?php print_link('index/login'); ?>" @submit.prevent="login()" method="post">
                                        <b-alert class="animated shake" variant="danger" :show="showError" @dismissed="showError=false" dismissible>
                                        {{errorMsg}}
                                        </b-alert>
                                        <div class="input-group form-group">
                                            <input placeholder="用户名或电子邮件" v-model="user.username" name="username"  required="required" class="form-control" type="text"  />
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="form-control-feedback material-icons">account_circle</i></span>
                                            </div>
                                        </div>
                                        <div class="input-group form-group">
                                            <input  placeholder="密码" required="required" v-model="user.password" name="password" class="form-control" type="password" />
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="form-control-feedback material-icons">lock</i></span>
                                            </div>
                                        </div>
                                        <div class="row clearfix mt-3 mb-3">
                                            <div class="col-6">
                                                <label class="">
                                                    <input value="true" type="checkbox" name="rememberme" />
                                                    记住我
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <a href="<?php print_link('passwordmanager') ?>" class="text-danger">忘记密码？ </a>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button class="btn btn-primary btn-block btn-md" type="submit">
                                                <i class="load-indicator">
                                                    <clip-loader :loading="loading" color="#fff" size="14px"></clip-loader>
                                                </i>
                                                登录 <i class="material-icons">lock_open</i>
                                            </button>
                                        </div>
                                        <hr />
                                        <div class="text-center">
                                            没有账户？ <router-link to="/register" class="btn btn-success">寄存器
                                            <i class="material-icons">account_box</i></router-link>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <script>
			var IndexComponent = Vue.component('IndexComponent', {
				template : '#Index',
				data : function() {
					return {
						user : {
							username : '',
							password : '',
						},
						loading : false,
						ready: false,
						errorMsg : '',
						showError : false,
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
					login : function(e){
						var payload = this.user;
						this.loading = true;
						var self = this;
						var apiurl = setApiUrl('index/login');
						this.$http.post( apiurl , payload , {emulateJSON:true} ).then(function (response) {
							self.loading = false;
							window.location = response.body;
						},
						function (response) {
							this.loading = false;
							this.showError = false
							this.errorMsg = response.statusText;
							//Flashes messages
							setTimeout(function(){
								self.showError = true;
							}, 100);
						});
					}
				},
				mounted : function() {
					this.ready = true;
				},
			});
		</script>
