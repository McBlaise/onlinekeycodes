<template>
	
  <div> 
    <nav v-show="isLoggedin == 'true'">
      <div class="nav-wrapper blue" v-show="type == 'client'">
        <router-link to="/" class="brand-logo sm-font">
        <img class="img" src="/keycodes.png">
        <!-- <i class="material-icons">vpn_key</i>  -->
        <span class="title">Online Keycodes</span></router-link>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li>
            <a href="javascript:void(0)" :style="bg"><b>{{level}}</b></a>
          </li>
          <li>
            <router-link to="/profile">Profile</router-link>
          </li>
          <li>
            <router-link to="/purchase">Purchase</router-link>
          </li>
          <li>
            <router-link to="/history">History</router-link>
          </li>
          <li>
            <a href="/logout">Logout</a>
          </li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
          <li class="special">
            <a class="special" :style="bg">{{level}}</a>
          </li>
          <li>
            <router-link to="/profile">Profile</router-link>
          </li>
          <li>
            <router-link to="/purchase">Purchase</router-link>
          </li>
          <li>
            <router-link to="/history">History</router-link>
          </li>
          <li>
            <a href="/logout">Logout</a>
          </li>
        </ul>
      </div>
      <div class="nav-wrapper blue" v-show="type == 'admin'">
        <router-link to="/" class="brand-logo sm-font">
        <img class="img" src="/keycodes.png">
        <!-- <i class="material-icons">vpn_key</i> -->
        <span class="title">Online Keycodes</span></router-link> 
        <a href="#" data-activates="mobile-democ" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li>
            <router-link to="/admin">Process Queue</router-link>
          </li>
          <li>
            <router-link to="/dashboard/history">Dashboard</router-link>
          </li>
          <li>
            <a href="/logout">Logout</a>
          </li>
        </ul>
        <ul class="side-nav" id="mobile-democ">
          <li>
            <router-link to="/admin">Process Queue</router-link>
          </li>
          <li>
            <router-link to="/dashboard/history">Dashboard</router-link>
          </li>
          <li>
            <a href="/logout">Logout</a>
          </li>
        </ul>
      </div>
    </nav>

    <nav v-show="isLoggedin == 'false'">
      <div class="nav-wrapper blue" >
        <router-link to="/" class="brand-logo sm-font">
        <img class="img" src="/keycodes.png">
        <!-- <i class="material-icons">vpn_key</i> -->
        <span class="title">Online Keycodes</span></router-link>
        <a href="#" data-activates="mobile-demoa" class="button-collapse"><i class="material-icons">menu</i></a>
        <div v-if="!signupPage">
          <ul class="right hide-on-med-and-down">
            <li>
              <router-link to="/signup">Sign up</router-link>
            </li>
          </ul>
          <ul class="side-nav" id="mobile-demoa">
            <li><router-link to="/signup">Sign up</router-link></li>
          </ul>
        </div>
        <div v-else>
          <ul class="right hide-on-med-and-down">
            <li>
              <router-link to="/">Login</router-link>
            </li>
          </ul>
          <ul class="side-nav" id="mobile-demoa">
            <li><router-link to="/">Login</router-link></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- <nav v-else>
      <div class="nav-wrapper blue" >
        <a href="#!" class="brand-logo">OLKeycodes</a>
        <a href="#" data-activates="mobile-demoa" class="button-collapse"><i class="material-icons">menu</i></a>
      </div>
    </nav> -->
    <!-- <nav>
      <div class="nav-wrapper blue" >
        <a href="#!" class="brand-logo">OLKeycodes</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li>
            <router-link to="/profile">Profile</router-link>
          </li>
          <li>
            <router-link to="/purchase">Purchase</router-link>
          </li>
          <li>
            <router-link to="/messages">Messages</router-link>
          </li>
          <li>
            <router-link to="/history">History</router-link>
          </li>
          <li>
            <a href="/logout">Logout</a>
          </li>
        </ul>
        <ul class="side-nav" id="mobile-demo">
          <li>
            <router-link to="/profile">Profile</router-link>
          </li>
          <li>
            <router-link to="/purchase">Purchase</router-link>
          </li>
          <li>
            <router-link to="/messages">Messages</router-link>
          </li>
          <li>
            <router-link to="/history">History</router-link>
          </li>
          <li>
            <a href="/logout">Logout</a>
          </li>
        </ul>
      </div>
    </nav> -->
  </div>
</template>


<script>

  import axios from 'axios';

	export default{
		mounted(){

			console.log("topbar mounted");
      $(".button-collapse").sideNav();

        setInterval(()=>{

          this.getLevel();

        }, 1000);

		},
    data(){

      return{

        action: "",
        isLog: false,
        signupPage: false,
        level: "",
        color: ""
      }

    },
    computed: {
      bg: function() {
        return { 
          color: this.color
        };
      },
    },
    props: ['isLoggedin','currentpage', 'type'],
    watch:{

      'currentpage': function(){
        
        if(this.currentpage == 'signup'){

          this.signupPage = true;

        }
        else{

          this.signupPage = false;

        }

      },
      'type': function(){

        axios.get('/locksmith/level')
        .then((response)=>{
          if(response.data.level == 1){
            this.level = "Silver";
            this.color = "#c9f8ff";
          }
          else if(response.data.level == 2){
            this.level = "Gold";
            this.color = "#ffd767";
          }
          else{
            this.level = "Platinum";
            this.color = "#e48838";
          }

        })
        .catch(()=>{

          console.log('error currentUser');

        })

      }

    },
    methods: {
      getLevel(){
        axios.get('/locksmith/level')
        .then((response)=>{
          if(response.data.level == 1){
            this.level = "Silver";
            this.color = "#c9f8ff";
          }
          else if(response.data.level == 2){
            this.level = "Gold";
            this.color = "#ffd767";
          }
          else{
            this.level = "Platinum";
            this.color = "#e48838";
          }
          // console.log(response.data.level);
        })
        .catch(()=>{

          console.log('error currentUser');

        })
      }
    }
    

	}
</script>
<style scoped>
  .nav-wrapper{
    background-color: #2d3b48 !important;
  }
  nav{
    overflow: hidden;
    position: fixed; /* Set the navbar to fixed position */
    top: 0; /* Position the navbar at the top of the page */
    width: 100%; /* Full width */
    z-index: 20;
  }
  .side-nav li>a:hover, .router-link-exact-active, .router-link-active, .hide-on-med-and-down a:hover{
    background-color: #2d3b48;
    color: white;
  }
  .brand-logo{
    padding-left: 10px;
    padding-right: 5px;
    font-family: impact; 
  }
  .img{
    display: block;
    position: relative;
    float: left;
  }
 

  @media only screen and (max-width: 670px) {

    .title{
      display: none;
    }
    .img{
      height: 70px;
    }

  }
  @media only screen and (min-width: 671px) {

    .title{
      display: ;
    }
    .img{
      height: 80px;
    }

  }

  .special{
    background-color: white !important;
    color: #dc2829 !important;
  }



</style>


