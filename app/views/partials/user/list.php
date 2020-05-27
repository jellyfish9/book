    <template id="userList">
        <section class="page-component">
            <div v-if="showheader" class="bg-light p-3 mb-3">
                <div class="container-fluid">
                    <div class="row ">
                        <div  class="col-sm-4 comp-grid" :class="setGridSize">
                            <h3 class="record-title">User</h3>
                        </div>
                        <div  class="col-sm-3 comp-grid" :class="setGridSize">
                            <router-link v-if="addbutton" class="btn btn btn-primary btn-block" :to="'/user/add'">
                            <i class="material-icons">add</i>
                            添新
                            </router-link>
                        </div>
                        <div v-if="searchfield" class="col-sm-5 comp-grid" :class="setGridSize">
                            <input @keyup.enter="dosearch()" v-model="searchtext" class="form-control" type="text" name="search" placeholder="搜索" />
                        </div>
                    </div>
                </div>
            </div>
            <div  class="pb-2 mb-3 border-bottom">
                <div class="container-fluid">
                    <div class="row ">
                        <div  class="col-md-12 comp-grid" :class="setGridSize">
                            <div  class=" animated fadeIn">
                                <div class="">
                                    <nav v-if="fieldname || filterMsgs.length" class="page-header-breadcrumbs mb-3" aria-label="breadcrumb">
                                        <ul class="breadcrumb m-0 p-2">
                                            <li v-if="fieldname" class="breadcrumb-item">
                                                <router-link class="text-capitalize" to="/user">User</router-link>
                                            </li>
                                            <li v-if="fieldvalue" class="breadcrumb-item active"  aria-current="page"> 
                                                <span class="text-capitalize">{{ fieldname|makeRead }} </span> &raquo;
                                                <span class="bold">{{ fieldvalue }}</span>
                                            </li>
                                            <li v-if="filterMsgs.length" v-for="msg in filterMsgs" class="breadcrumb-item active"  aria-current="page"> 
                                                <span>{{ msg.label }} </span> 
                                                &raquo;
                                                <span class="bold">{{ msg.value }}</span> 
                                            </li>
                                        </ul>
                                    </nav>
                                    <div v-if="records.length" ref="datatable" class="table-responsive">
                                        <table class="table" :class="tablestyle">
                                            <thead class="table-header bg-light">
                                                <tr>
                                                    <th v-if="multicheckbox" class="td-sno td-checkbox">
                                                        <label>
                                                            <input type="checkbox" v-model="allSelected" />
                                                        </label>
                                                    </th>
                                                    <th v-if="listsequence" class="td-sno">#</th>
                                                    <th > Uid</th>
                                                    <th > User Name</th>
                                                    <th > Email</th>
                                                    <th class="td-btn"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(data,index) in records">
                                                    <th v-if="multicheckbox" class="td-checkbox">
                                                        <label>
                                                            <input type="checkbox" :value="data.uid" name="selectedid" v-model="selected" />
                                                        </label>
                                                    </th>
                                                    <th v-if="listsequence" class="td-sno">{{index + 1}}</th>
                                                    <td><router-link :to="'/user/view/' +  data.uid">{{data.uid}}</router-link></td>
                                                    <td> {{ data.user_name }} </td>
                                                    <td> {{ data.email }} </td>
                                                    <th class="td-btn">
                                                        <div >
                                                            <router-link v-if="viewbutton" class="btn btn-sm btn-outline-primary" title="View Record" :to="'/user/view/' + data.uid">
                                                            <i class="material-icons">visibility</i> 视图
                                                            </router-link>
                                                            <router-link v-if="editbutton" class="btn btn-sm btn-outline-success" title="Edit This Record" :to="'/user/edit/' + data.uid">
                                                            <i class="material-icons">edit</i> 编辑
                                                            </router-link>
                                                            <button  v-if="deletebutton" class="btn btn-outline-danger btn-sm" @click="deleteRecord(data.uid,index)" title="Delete This Record">
                                                                <span v-show="deleting != data.uid"><i class="material-icons">clear</i></span>
                                                                删除
                                                                <clip-loader :loading="deleting == data.uid" color="#fff" size="14px"></clip-loader>
                                                            </button>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-if="!records.length && emptyrecordmsg != '' && !loading" class="text-muted p-4 text-center">
                                        <h4><i class="material-icons">block</i> {{emptyrecordmsg}}</h4>
                                    </div>
                                    <div v-show="loading" class="load-indicator static-center">
                                        <span class="animator">
                                            <clip-loader :loading="loading" color="gray" size="20px">
                                            </clip-loader>
                                        </span>
                                        <h4 style="color:gray" class="loading-text">载入中...</h4>
                                    </div>
                                    <div v-if="paginate" class="page-header">
                                        <div v-if="paginate">
                                            <pagination
                                                :total-items="totalrecords"
                                                :current-items-count="currentItemsCount"
                                                :items-per-page="limit"
                                                :offset="5"
                                                :show-record-count="true"
                                                :show-page-count="true"
                                                :show-page-limit="true"
                                                @limit-changed="limitChanged"
                                                @changepage="changepage">
                                            </pagination>
                                        </div>
                                    </div>
                                    <div v-if="showfooter" class="page-footer">
                                        <button @click="deleteRecord()" v-if="selected.length" class="btn btn-sm btn-danger">
                                            <i class="material-icons">clear</i> 删除
                                        </button>
                                        <button @click="exportRecord()" v-if="exportbutton" class="btn btn-sm btn-primary"><i class="material-icons">save</i> 出口</button>
                                        <dataimport extensions="" buttontext="导入数据" post-action="user/import_data" v-if="importbutton"></dataimport>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </template>
    <script>
	var UserListComponent = Vue.component('userList', {
		template: '#userList',
		mixins: [ListPageMixin],
		props: {
			limit : {
				type : Number,
				default : defaultPageLimit,
			},
			pagename : {
				type : String,
				default : 'user',
			},
			routename : {
				type : String,
				default : 'userlist',
			},
			apipath : {
				type : String,
				default : 'user/list',
			},
			tablestyle: {
				type: String,
				default: ' table-striped table-sm',
			},
			promptdeletemessage: {
				type: String,
				default: '您确定要删除此记录吗？',
			},
		},
		data: function(){
			return {
				pagelimit : defaultPageLimit,
			}
		},
		computed : {
			pageTitle: function(){
				return 'User';
			},
			filterGroupChange: function(){
				return ;
			},
		},
		watch : {
			allSelected: function(){
				//toggle selected record
				this.selected = [];
				if(this.allSelected == true){
					for (var i in this.records){
						var id = this.records[i].uid;
						this.selected.push(id);
					}
				}
			}
		},
		methods:{
			load:function(){
				this.records = [];
				if (this.loading == false){
					this.ready = false;
					this.loading = true;
					var url = this.apiUrl;
					this.$http.get(url).then(function (response) {
						var data = response.body;
						if(data && data.records){
							this.totalrecords = data.total_records ;
							if(this.pagelimit  > data.records.length){
								this.loadcompleted = true;
							}
							this.records = data.records;
						}
						else{
							this.$root.$emit('requestError' , response);
						}
						this.loading = false
						this.ready = true
					},
					function (response) {
						this.loading = false;
						this.$root.$emit('requestError' , response);
					});
				}
			},	
			filterGroup: function(){
				var filters = {};
				this.filterMsgs = [];
				this.filter(filters);
			},
		}
	});
	</script>
