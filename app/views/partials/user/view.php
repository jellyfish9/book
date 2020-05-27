    <template id="userView">
        <section class="page-component">
            <div v-if="showheader" class="bg-light p-3 mb-3">
                <div class="container">
                    <div class="row ">
                        <div  class="col-12 comp-grid" :class="setGridSize">
                            <h3 class="record-title">视图</h3>
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
                                        <div class="">
                                            <div class="avatar"><img src="<?php print_link("assets/images/avatar.png") ?>" /> </div>
                                            </div>
                                            <h2 class="title">{{data.user_name}}</h2>
                                        </div>
                                    </div>
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
                                                    <td class="value"> {{ data.user_name }} </td>
                                                </tr>
                                                <tr>
                                                    <th class="title"> Email :</th>
                                                    <td class="value"> {{ data.email }} </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-if="editbutton || deletebutton || exportbutton" class="mt-2">
                                        <span >
                                            <router-link class="btn btn-sm btn-info has-tooltip" v-if="editbutton"  :to="'/user/edit/'  + data.uid">
                                            <i class="material-icons">edit</i> 编辑
                                            </router-link>
                                            <button @click="deleteRecord" class="btn btn-sm btn-danger" v-if="deletebutton" :to="'/user/delete/' + data.uid">
                                            <i class="material-icons">clear</i> 删除</button>
                                        </span>
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
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </template>
        <script>
	var UserViewComponent = Vue.component('userView', {
		template : '#userView',
		mixins: [ViewPageMixin],
		props: {
			pagename: {
				type : String,
				default : 'user',
			},
			routename : {
				type : String,
				default : 'userview',
			},
			apipath: {
				type : String,
				default : 'user/view',
			},
		},
		data: function() {
			return {
				data : {
					default :{
						uid: '',user_name: '',email: '',
					},
				},
			}
		},
		computed: {
			pageTitle: function(){
				return '视图';
			},
		},
		methods :{
			resetData : function(){
				this.data = {
					uid: '',user_name: '',email: '',
				}
			},
		},
	});
	</script>
