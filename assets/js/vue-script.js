var bus = new Vue({});
var routes = [
  
	{ path: '/book', name: 'booklist', component: BookListComponent },
	{ path: '/book/(index|list)', name: 'booklist' , component: BookListComponent },
	{ path: '/book/(index|list)/:fieldname/:fieldvalue', name: 'booklist' , component: BookListComponent , props: true },
	{ path: '/book/view/:id', name: 'bookview' , component: BookViewComponent , props: true},
	{ path: '/book/view/:fieldname/:fieldvalue', name: 'bookview' , component: BookViewComponent , props: true },
	{ path: '/book/add', name: 'bookadd' , component: BookAddComponent },
	{ path: '/book/edit/:id' , name: 'bookedit' , component: BookEditComponent , props: true},
	{ path: '/book/edit', name: 'bookedit' , component: BookEditComponent , props: true},
	{ path: '/book/show', name: 'bookshow' , component: BookShowComponent },

	{ path: '/user', name: 'userlist', component: UserListComponent },
	{ path: '/user/(index|list)', name: 'userlist' , component: UserListComponent },
	{ path: '/user/(index|list)/:fieldname/:fieldvalue', name: 'userlist' , component: UserListComponent , props: true },
	{ path: '/user/view/:id', name: 'userview' , component: UserViewComponent , props: true},
	{ path: '/user/view/:fieldname/:fieldvalue', name: 'userview' , component: UserViewComponent , props: true },
	{ path: '/account/edit', name: 'accountedit' , component: AccountEditComponent },
	{ path: '/account', name: 'accountview' , component: AccountViewComponent },
	{ path: '/user/add', name: 'useradd' , component: UserAddComponent },
	{ path: '/user/edit/:id' , name: 'useredit' , component: UserEditComponent , props: true},
	{ path: '/user/edit', name: 'useredit' , component: UserEditComponent , props: true},

	{ path: '/home', name: 'home' , component: HomeComponent },
	{ path: '*', name: 'pagenotfound' , component: ComponentNotFound }
];

if(ActiveUser){
	routes.push({ path: '/', name: 'home' , component: HomeComponent })
}
else{
	routes.push({ path: '/', name: 'index', component: IndexComponent })
	routes.push({ path: '/register', name: 'register', component: RegisterComponent })
}

var router = new VueRouter({
	routes:routes,
	linkExactActiveClass:'active',
	linkActiveClass:'active',
	//mode:'history'
});
router.beforeEach(function(to, from, next) {
	document.body.className = to.name;
	
	if(to.name !='index' && to.name !='register' && !ActiveUser){
		next(
			{
				path: '/' , 
				query:{
					redirect:to.path 
				}
			}
		);
	}
	else{
		next();	
	}

});
var config = {
	errorBagName: 'errors', // change if property conflicts
	fieldsBagName: 'fields', 
	delay: 0, 
	locale: '', 
	dictionary: null, 
	strict: true, 
	classes: false, 
	classNames: {
		touched: 'touched', // the control has been blurred
		untouched: 'untouched', // the control hasn't been blurred
		valid: 'valid', // model is valid
		invalid: 'invalid', // model is invalid
		pristine: 'pristine', // control has not been interacted with
		dirty: 'dirty' // control has been interacted with
	},
	events: 'input|blur',
	inject: true,
	validity: false,
	aria: true,
	i18n: null, // the vue-i18n plugin instance,
	i18nRootKey: 'validations', // the nested key under which the validation messsages will be located
};

Vue.use(VeeValidate,config);
Vue.http.interceptors.push(function(request, next) {
	next(function(response){
		if(response.status == 401 ) {
			if(this.$route.name != 'index'){
				window.location = "/"
				//this.$router.push('index');
			}
		}
		else if(response.status == 403 ) {
			alert(response.statusText);
			window.location = 'errors/forbidden';
		}
	});
});
Vue.mixin({
	data: function() {
		return {
			get ActiveUser() {
				return ActiveUser
			}
		}
	},
	methods: {
		SetPageTitle: function(title, pagename){
			document.title = title;
		},
		setPhotoUrl: function(src, width,height){
			var newSrc = 'helpers/timthumb.php?src=' + src;
			if(width){
				newSrc = newSrc + '&w=' + width
			}
			if(height){
				newSrc = newSrc + '&h=' + height	
			}
			return  newSrc;
		},
		exportPage: function(pagehtml , reporttitle){
			var form = document.getElementById("exportform");
			document.getElementById("exportformdata").value = pagehtml ;
			document.getElementById("exportformtitle").value = reporttitle ;
			form.submit();
		}
	}
});

var app = new Vue({
	el: '#app',
	router: router,
	data:{
		showPageError : false,
		pageErrorMsg : '',
		pageErrorStatus : '',
		modalComponentName: '',
		modalComponentProps: '',
		popoverTarget : '',
		showModalView : false,
		showFlash : false,
		flashMsg : '',
	},
	watch : {
		'$route': function(){
			this.pageErrorMsg = '' ;
			this.showPageError = false ;
		},
	},
	mounted : function(){
		this.$on('requestCompleted' ,  function (msg) {
			this.showModal = false;
			if(msg){
				this.showFlash = 3 ;
				this.flashMsg = msg ;
			}
			bus.$emit('refresh');
		});
		this.$on('requestError' ,  function (response) {
			this.pageErrorMsg = response.bodyText ;
			this.pageErrorStatus = response.statusText ;
			this.showPageError = true ;
		})
		
		this.$on('showPageModal' ,  function (props) {
			if(props.page){
				this.modalComponentName = props.page;
				delete props.page;
				props.resetgrid = true; // reset columns so that page components will fit well
				this.modalComponentProps = props;
				this.showModalView = true;
			}
			else{
				console.error("No Page Defined")
			}
		})
		
		this.$on('showPopOver' ,  function (props) {
			if(props.page && props.target){
				this.modalComponentName = props.page;
				this.popoverTarget = props.target;
				delete props.page;
				delete props.target;
				props.resetgrid=true;
				this.modalComponentProps = props;
			}
			else{
				console.error("No Page or Target  Defined")
			}
		})
		
		this.$on('showListModal' ,  function (arr) {
			this.modalComponentName = arr[0];
			this.modalFieldName = arr[1];
			this.modalFieldValue = arr[2];
			this.showModalList = true;
		})
	}
});


Vue.filter('toUSD', function (value) {
	return '$'+ value;
});
Vue.filter('upper', function (value) {
	return value.toUpperCase();
});
Vue.filter('lower', function (value) {
	return value.toLowerCase();
});
Vue.filter('proper', function (value) {
	return value.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
});
Vue.filter('truncate', function (text, length, suffix) {
	return text.substring(0, length) + suffix;
});
Vue.filter('toFixed', function (price, limit) {
	return price.toFixed(limit);
});
Vue.filter('makeRead', function (str) {
	return str.replace(/[-_]/g, " ");
});
Vue.filter('humanDate', function (datestr) {
	var timeStamp = new Date(datestr);
	return timeStamp.toDateString();
});
Vue.filter('humanTime', function (datestr) {
	var timeStamp = new Date(datestr);
	return timeStamp.toLocaleTimeString();
});

Vue.filter('toLocaleString', function (val) {
	return val.toLocaleString();
});
