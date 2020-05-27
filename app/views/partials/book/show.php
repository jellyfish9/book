    <template id="bookShow">
        <section class="page-component">
            <div v-if="showheader" class="bg-light p-3 mb-3">
                <div class="container-fluid">
                    <div class="row ">
                        <div  class="col-sm-4 comp-grid" :class="setGridSize">
                            <h3 class="record-title">Book</h3>
                        </div>
                        <div  class="col-sm-3 comp-grid" :class="setGridSize">
                            <div class="card mb-3">
                                <h5 class="card-header"></h5>
                                <div class="p-2">
                                    <flat-pickr   placeholder=""
                                    :config="{
                                    enableTime: false,
                                    dateFormat: 'Y-m-d',
                                    altFormat: 'M j, Y',
                                    altInput: true,
                                    allowInput:true,
                                    inline:false,
                                    noCalendar: false,
                                    mode: 'single'
                                    }"
                                    >
                                    </flat-pickr>
                                </div>
                            </div>
                        </div>
                        <div v-if="searchfield" class="col-sm-5 comp-grid" :class="setGridSize">
                            <input @keyup.enter="dosearch()" v-model="searchtext" class="form-control" type="text" name="search" placeholder="搜索" />
                        </div>
                        <div  class="col-md-6 comp-grid" :class="setGridSize">
                            <div class="card mb-3">
                                <h5 class="card-header"></h5>
                                <div class="p-2">
                                    <datacheck  :isbutton="false"  :btnvertical="false"  checkclass="btn btn-light btn-sm m-1" btnvariant="primary" :datasource='[""]'  ></datacheck>
                                </div>
                            </div>
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
                                                <router-link class="text-capitalize" to="/book">Book</router-link>
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
                                                    <th > Id</th>
                                                    <th > Book Id</th>
                                                    <th > Name</th>
                                                    <th > Image</th>
                                                    <th class="td-btn"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(data,index) in records">
                                                    <th v-if="multicheckbox" class="td-checkbox">
                                                        <label>
                                                            <input type="checkbox" :value="data.id" name="selectedid" v-model="selected" />
                                                        </label>
                                                    </th>
                                                    <th v-if="listsequence" class="td-sno">{{index + 1}}</th>
                                                    <td><router-link :to="'/book/view/' +  data.id">{{data.id}}</router-link></td>
                                                    <td> {{ data.book_id }} </td>
                                                    <td> {{ data.name }} </td>
                                                    <td> {{ data.image }} </td>
                                                    <th class="td-btn">
                                                        <div >
                                                            <router-link v-if="viewbutton" class="btn btn-sm btn-outline-primary" title="View Record" :to="'/book/view/' + data.id">
                                                            <i class="material-icons">visibility</i> 查看
                                                            </router-link>
                                                            <router-link v-if="editbutton" class="btn btn-sm btn-outline-success" title="Edit This Record" :to="'/book/edit/' + data.id">
                                                            <i class="material-icons">edit</i> 编辑
                                                            </router-link>
                                                            <button  v-if="deletebutton" class="btn btn-outline-danger btn-sm" @click="deleteRecord(data.id,index)" title="Delete This Record">
                                                                <span v-show="deleting != data.id"><i class="material-icons">clear</i></span>
                                                                删除
                                                                <clip-loader :loading="deleting == data.id" color="#fff" size="14px"></clip-loader>
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
                                        <button @click="exportRecord()" v-if="exportbutton" class="btn btn-sm btn-primary"><i class="material-icons">save</i> 导出</button>
                                        <dataimport extensions="" buttontext="导入数据" post-action="book/import_data" v-if="importbutton"></dataimport>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="pb-2 mb-3 border-bottom">
                <div class="container">
                    <div class="row ">
                        <div  class="col-md-12 comp-grid" :class="setGridSize">
                            <div class="card mb-3">
                                <div class="p-2">
                                    <select  class="form-control custom">
                                        <option value="">Select ...</option>
                                        <option  value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div  class="col-md-6 comp-grid" :class="setGridSize">
                            <div class="mb-2">
                                <datadropmenu  defaultitem=""  variant="primary" size="sm"   :datasource='[""]'>
                                    Drop Down
                                </datadropmenu>
                            </div>
                        </div>
                        <div  class="col-md-6 comp-grid" :class="setGridSize">
                            <div class="card mb-3">
                                <h5 class="card-header"></h5>
                                <div class="p-2">
                                    <vue-slider  :interval="10" :fixed="false"  :piecewise-label="true" :piecewise="true" :piecewise-style="{backgroundColor: '#ccc', width: '12px', height: '12px'}" :min="0" :max="100" :bg-style="{backgroundColor: 'WhiteSmoke'}" :height="6"  :piecewise-active-style="{backgroundColor: '#3498db'}" :label-active-style="{color: '#3498db'}" ></vue-slider>
                                </div>
                            </div>
                        </div>
                        <div  class="col-md-6 comp-grid" :class="setGridSize">
                        </div>
                        <div  class="col-md-6 comp-grid" :class="setGridSize">
                            <niceformwizard shape="square" color="royalblue" step-size="md">
                                <template slot="header">
                                    <div class="text-left">
                                        <h4></h4>
                                        <p class="text-muted"></p>
                                    </div>
                                </template>
                                <tab-content icon=" "  title="Step 1">
                                <div class="">
                                    <div class="text-center">
                                        <div class="card-body mb-3 card">
                                            <p><i class="material-icons">account_box</i></p>
                                            <h3>Welcome To Vue Form Wizard</h3>
                                            <hr />
                                            <p class="text-muted">You can drag components onto the form wizard steps</p>
                                        </div>
                                    <wizardbtn icon='<i class="material-icons">navigate_next</i>' text="Getting Started"></wizardbtn>
                                </div>
                            </div><div class="card-body text-center"></div>
                            </tab-content>
                            <tab-content icon=" "  title="Step 2">
                            </tab-content>
                            <tab-content icon=" "  title="Step 3">
                            </tab-content>
                            <tab-content icon=" "  title="Step 4">
                            </tab-content>
                            <tab-content icon=" "  title="Step 5">
                            <div class="">
                                <div class="text-center">
                                    <div class="card-body mb-3 card">
                                        <p><i class="material-icons">check_circle</i></p>
                                        <h3>Form Wizard Completed</h3>
                                        <hr />
                                        <p class="text-muted">Thank you for your time</p>
                                        <br />
                                    </div>
                                    <b-button href="#/home" variant="outline-success"><i class="material-icons">home</i> Home</b-button>
                                </div>
                            </div><div class="card-body text-center"></div>
                            </tab-content>
                        </niceformwizard>
                    </div>
                    <div  class="col-md-6 comp-grid" :class="setGridSize">
                        <button v-b-modal="'Modal1'" class="btn btn-primary">  Open Modal</button>
                        <b-modal id="Modal1" title="Modal Contents" centered :hide-backdrop="false" size="lg" ok-title="Okay" cancel-title="Cancel">
                        </b-modal>
                    </div>
                    <div  class="col-md-6 comp-grid" :class="setGridSize">
                    </div>
                    <div  class="col-md-6 comp-grid" :class="setGridSize">
                        <div class=""><div>You can render differnt pages or other component</div>
                        </div>
                    </div>
                    <div  class="col-md-6 comp-grid" :class="setGridSize">
                        <div role="tablist" class="accordion-group">
                            <div class="card">
                                <div  v-b-toggle="'accordion1'" class="card-header accordion-header" role="tab">
                                    Title 1 <span class="expand"><i class="material-icons">arrow_drop_down</i></span>
                                </div>
                                <b-collapse id="accordion1" accordion="accordion">
                                </b-collapse>
                            </div>
                            <div class="card">
                                <div  v-b-toggle="'accordion2'" class="card-header accordion-header" role="tab">
                                    Title 2 <span class="expand"><i class="material-icons">arrow_drop_down</i></span>
                                </div>
                                <b-collapse id="accordion2" accordion="accordion">
                                </b-collapse>
                            </div>
                            <div class="card">
                                <div  v-b-toggle="'accordion3'" class="card-header accordion-header" role="tab">
                                    Title 3 <span class="expand"><i class="material-icons">arrow_drop_down</i></span>
                                </div>
                                <b-collapse id="accordion3" accordion="accordion">
                                </b-collapse>
                            </div>
                            <div class="card">
                                <div  v-b-toggle="'accordion4'" class="card-header accordion-header" role="tab">
                                    Title 4 <span class="expand"><i class="material-icons">arrow_drop_down</i></span>
                                </div>
                                <b-collapse id="accordion4" accordion="accordion">
                                </b-collapse>
                            </div>
                        </div>
                    </div>
                    <div  class="col-md-6 comp-grid" :class="setGridSize">
                        <div class="card">
                            <b-tabs horizontal  card class="" >
                            <b-tab title=" Tab 1">
                            </b-tab>
                            <b-tab title=" Tab 2">
                            </b-tab>
                            </b-tabs>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </template>
    <script>
	var BookShowComponent = Vue.component('bookShow', {
		template: '#bookShow',
		mixins: [ListPageMixin],
		props: {
			limit : {
				type : Number,
				default : defaultPageLimit,
			},
			pagename : {
				type : String,
				default : 'book',
			},
			routename : {
				type : String,
				default : 'bookshow',
			},
			apipath : {
				type : String,
				default : 'book/show',
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
				return 'Book';
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
						var id = this.records[i].id;
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
