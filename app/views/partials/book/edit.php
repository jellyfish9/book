    <template id="bookEdit">
        <section class="page-component">
            <div v-if="showheader" class="bg-light p-3 mb-3">
                <div class="container">
                    <div class="row ">
                        <div  class="col-12 comp-grid" :class="setGridSize">
                            <h3 class="record-title">编辑</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="pb-2 mb-3 border-bottom">
                <div class="container">
                    <div class="row ">
                        <div  class="col-md-7 comp-grid" :class="setGridSize">
                            <div  class=" animated fadeIn">
                                <form  v-show="!loading" enctype="multipart/form-data" @submit="update()" class="form form-default" :action="'book/edit/' + data.id" method="post">
                                    <div class="form-group " :class="{'has-error' : errors.has('book_id')}">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="book_id">Book Id <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input v-model="data.book_id"
                                                    v-validate="{required:true,  numeric:true}"
                                                    data-vv-as="Book Id"
                                                    class="form-control "
                                                    type="number"
                                                    name="book_id"
                                                    placeholder="Enter Book Id"
                                                    step="1" 
                                                    />
                                                    <small v-show="errors.has('book_id')" class="form-text text-danger">
                                                        {{ errors.first('book_id') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group " :class="{'has-error' : errors.has('name')}">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="name">Name <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input v-model="data.name"
                                                    v-validate="{required:true}"
                                                    data-vv-as="Name"
                                                    class="form-control "
                                                    type="text"
                                                    name="name"
                                                    placeholder="Enter Name"
                                                    />
                                                    <small v-show="errors.has('name')" class="form-text text-danger">
                                                        {{ errors.first('name') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group " :class="{'has-error' : errors.has('image')}">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="image">Image <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <niceupload
                                                        fieldname="image"
                                                        control-class="upload-control"
                                                        dropmsg="Drop files here to upload"
                                                        uploadpath="uploads/files/"
                                                        filenameformat="random" 
                                                        extensions="jpg , png , gif , jpeg"  
                                                        :filesize="3" 
                                                        :maximum="1" 
                                                        name="image"
                                                        v-model="data.image"
                                                        v-validate="{required:true}"
                                                        data-vv-as="Image"
                                                        >
                                                    </niceupload>
                                                    <small v-show="errors.has('image')" class="form-text text-danger">{{ errors.first('image') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group " :class="{'has-error' : errors.has('type')}">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="type">Type <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <select v-model="data.type"
                                                    v-validate="{required:true,  numeric:true}"
                                                    data-vv-as="Type"
                                                    class="form-control "
                                                    type="number"
                                                    name="type"
                                                    placeholder="Enter Type"
                                                    step="1">
													<option value="0">最近</option>
													<option value="1">IT</option>
													</select>
                                                    <small v-show="errors.has('type')" class="form-text text-danger">
                                                        {{ errors.first('type') }}
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
	var BookEditComponent = Vue.component('bookEdit', {
		template : '#bookEdit',
		mixins: [EditPageMixin],
		props: {
			pagename : {
				type : String,
				default : 'book',
			},
			routename : {
				type : String,
				default : 'bookedit',
			},
			apipath : {
				type : String,
				default : 'book/edit',
			},
		},
		data: function() {
			return {
				data : { book_id: '',name: '',image: '',type: '', },
			}
		},
		computed: {
			pageTitle: function(){
				return '编辑';
			},
		},
		methods: {
			actionAfterUpdate : function(response){
				this.$root.$emit('requestCompleted' , this.msgafterupdate);
				if(!this.ismodal){
					this.$router.push('/book');
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
