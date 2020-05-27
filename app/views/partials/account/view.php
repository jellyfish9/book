    <template id="accountView">
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
                        <div  class="col-md-12 comp-grid" :class="setGridSize">
                            <div  class=" animated fadeIn">
                                <div class="profile-bg mb-2">
                                    <div class="profile">
                                        <div class="d-flex flex-row">
                                            <img src="<?php print_link("assets/images/avatar.png") ?>" /> 
                                            </div>
                                            <h2 class="title">{{data.account_name}}</h2>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <b-tabs vertical pills card class="" >
                                        <b-tab title='<i class="material-icons">account_circle</i> 我的帐户'>
                                        <div>
                                            <div>
                                                <h5 class="text-bold">帐户明细</h5>
                                                <hr />
                                                <table class="table table-hover table-borderless table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th class="title"> Uid :</th>
                                                            <td class="value"> {{ data.uid }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="title"> User Name :</th>
                                                            <td class="value"> {{ data.account_name }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="title"> Email :</th>
                                                            <td class="value"><router-link :to="'/account/view/' +  data.uid">{{data.email}}</router-link></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div v-show="loading" class="load-indicator static-center">
                                                <span class="animator">
                                                    <clip-loader :loading="loading" color="gray" size="20px">
                                                    </clip-loader>
                                                </span>
                                                <h4 style="color:gray" class="loading-text">载入中...</h4>
                                            </div>
                                            <div class="text-muted" v-if="!data && emptyrecordmsg != '' && !loading">
                                                <h4><i class="material-icons">block</i> 没有找到记录</h4>
                                            </div>
                                        </div>
                                        </b-tab>
                                        <b-tab title='<i class="material-icons">edit</i> 编辑帐户'>
                                        <account-edit :resetgrid="true" v-if="ready"></account-edit>
                                        </b-tab>
                                        <b-tab title='<i class="material-icons">lock</i> 重设密码'>
                                        <?php $this->load_view('passwordmanager/index.php') ?>
                                        </b-tab>
                                        <b-tab title='<i class="material-icons">email</i> 更改电子邮件'>
                                        <?php $this->load_view('account/change_email.php') ?>
                                        </b-tab>
                                        </b-tabs>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </template>
        <script>
	var AccountViewComponent = Vue.component('accountView', {
		template : '#accountView',
		mixins: [ViewPageMixin],
		props: {
			pagename: {
				type : String,
				default : 'account',
			},
			routename : {
				type : String,
				default : 'accountaccountview',
			},
			apipath: {
				type : String,
				default : 'account',
			},
		},
		data: function() {
			return {
				data : {
					default :{
						uid: '',account_name: '',email: '',
					},
				},
			}
		},
		computed: {
			pageTitle: function(){
				return '我的帐户';
			},
		},
		methods :{
			resetData : function(){
				this.data = {
					uid: '',account_name: '',email: '',
				}
			},
		},
	});
	</script>
