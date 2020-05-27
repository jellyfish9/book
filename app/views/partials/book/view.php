    <template id="bookView">
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
                                <div v-show="!loading">
                                    <div ref="datatable" id="datatable">
                                        <table class="table table-hover table-borderless table-striped">
                                            <!-- Table Body Start -->
                                            <tbody>
                                                <tr>
                                                    <th class="title"> Id :</th>
                                                    <td class="value"><router-link :to="'/book/view/' +  data.id">{{data.id}}</router-link></td>
                                                </tr>
                                                <tr>
                                                    <th class="title"> Book Id :</th>
                                                    <td class="value"> {{ data.book_id }} </td>
                                                </tr>
                                                <tr>
                                                    <th class="title"> Name :</th>
                                                    <td class="value"> {{ data.name }} </td>
                                                </tr>
                                                <tr>
                                                    <th class="title"> Image :</th>
                                                    <td class="value"><niceimg :path="data.image" width="400" height="400" ></niceimg> </td>
                                                </tr>
                                                <tr>
                                                    <th class="title"> Type :</th>
                                                    <td class="value"> {{ data.type }} </td>
                                                </tr>
                                            </tbody>
                                            <!-- Table Body End -->
                                        </table>
                                    </div>
                                    <div v-if="editbutton || deletebutton || exportbutton" class="py-3">
                                        <span >
                                            <router-link class="btn btn-sm btn-info has-tooltip" v-if="editbutton"  :to="'/book/edit/'  + data.id">
                                            <i class="material-icons">edit</i> 编辑
                                            </router-link>
                                            <button @click="deleteRecord" class="btn btn-sm btn-danger" v-if="deletebutton" :to="'/book/delete/' + data.id">
                                            <i class="material-icons">clear</i> 删除</button>
                                        </span>
                                        <button @click="exportRecord" class="btn btn-sm btn-primary" v-if="exportbutton">
                                            <i class="material-icons">save</i> 出口
                                        </button>
                                    </div>
                                </div>
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
	var BookViewComponent = Vue.component('bookView', {
		template : '#bookView',
		mixins: [ViewPageMixin],
		props: {
			pagename: {
				type : String,
				default : 'book',
			},
			routename : {
				type : String,
				default : 'bookview',
			},
			apipath: {
				type : String,
				default : 'book/view',
			},
		},
		data: function() {
			return {
				data : {
					default :{
						id: '',book_id: '',name: '',image: '',type: '',
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
					id: '',book_id: '',name: '',image: '',type: '',
				}
			},
		},
	});
	</script>
