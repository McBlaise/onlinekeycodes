require('./bootstrap');
import Vue              from 'vue';
import Router           from 'vue-router';
import topBar           from './components/nav/topbar.vue';
import typeahead        from './components/common/typeahead.vue';
import index            from './components/pages/home/index.vue';
import signup           from './components/pages/signup/signup.vue';
import profile          from './components/pages/profile/profile.vue';
import purchase         from './components/pages/purchase/purchase.vue';
import history          from './components/pages/history/history.vue';
import messages         from './components/pages/messages/messages.vue';
import admin            from './components/pages/admin/admin.vue';
import dashboard        from './components/pages/dashboard/dashboard.vue';
import users            from './components/pages/dashboard/children/users.vue';
import cars             from './components/pages/dashboard/children/cars.vue';
import settings         from './components/pages/dashboard/children/settings.vue';
import transHistory     from './components/pages/transaction_history/transhistory.vue';
import footer           from './components/nav/footer.vue';
import VueGoodTable     from 'vue-good-table';
import material         from 'materialize-css';

Vue.component('topbar', topBar);
Vue.component('footer-vue', footer);
Vue.component('typeahead', typeahead);

Vue.use(VueGoodTable);
Vue.use(Router);

const router = new Router({
  routes:[

    {path: '/', component: index, props: true},
    {path: '/signup', component: signup},
    {path: '/profile', component: profile},
    {path: '/purchase', component: purchase},
    {path: '/history', component: history},
    {path: '/messages', component: messages},
    {path: '/admin', component: admin},
    {path: '/dashboard/history', component: dashboard, children:[

      {path: '/dashboard/history', component: transHistory},
      {path: '/dashboard/users', component: users},
      {path: '/dashboard/cars', component: cars},
      {path: '/dashboard/settings', component: settings}

    ]},
  
  ]
})

const app = new Vue ({
  el: '#lock',
  router: router,
  mounted(){

    this.checkUser();

  },
  data(){
    return{

      currentPage: "",
      loggedin: "",
      status: "out",
      type: ""

    }
  },
  watch: {

    'status': function(){

      this.loggedin = "true";
      this.checkUser();

    }

  },
  methods:{

    checkUser(){

      axios.get('/check')
      .then((response)=>{
        
        if(response.data.msg == "false"){

          this.loggedin = "false";

        }
        else{

          this.loggedin = "true";

          if(response.data.type == "admin"){

            this.type = "admin";

          }
          else{

            this.type = "client";

          }

        }

      })
      .catch(()=>{

      });

    }

  },

  http : {
      headers: {
        'X-CSRF-Token': $('meta[name=_token]').attr('content'),
        'Content-Type': 'multipart/form-data'
      }
  },
});