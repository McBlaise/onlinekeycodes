<template>
        <div id="wrapper" class="toggled">
          <!-- Sidebar -->
          <div id="sidebar-wrapper">
              <ul class="sidebar-nav">
                  <!-- <li class="sidebar-brand">
                      <a href="#">
                          Lock something
                      </a>
                  </li> -->
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
              </ul>
          </div>
          <!-- /#sidebar-wrapper -->
        </div>
</template>
<script>

  import axios from 'axios';

  export default{

    mounted(){

      console.log("sidebar mounted");

      

    },
    data(){

      return{

        user : ""

      }

    }

  }
</script>
<style scoped>
    /*!
   * Start Bootstrap - Simple Sidebar (https://startbootstrap.com/template-overviews/simple-sidebar)
   * Copyright 2013-2017 Start Bootstrap
   * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-simple-sidebar/blob/master/LICENSE)
   */

  body {
    overflow-x: hidden;
  }

  #wrapper {
    padding-left: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
  }

  #wrapper.toggled {
    padding-left: 250px;
  }

  #sidebar-wrapper {
    z-index: 1000;
    position: fixed;
    left: 250px;
    width: 0;
    height: 100%;
    margin-left: -250px;
    overflow-y: auto;
    background: white;
    border-right: 1px solid #ddd;
    box-shadow: 1px 1px 2px #ddd;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
    overflow: hidden;
  }

  #wrapper.toggled #sidebar-wrapper {
    width: 250px;
  }

  #page-content-wrapper {
    width: 100%;
    position: absolute;
    padding: 15px;
  }

  #wrapper.toggled #page-content-wrapper {
    position: absolute;
    margin-right: -250px;
  }


  /* Sidebar Styles */

  .sidebar-nav {
    position: absolute;
    top: 0;
    width: 250px;
    margin: 0;
    padding: 0;
    list-style: none;
  }

  .sidebar-nav li {
    text-indent: 20px;
    line-height: 40px;
  }

  .sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: inherit;
  }

  .sidebar-nav li a:hover {
    text-decoration: none;
    color: #fff;
    background: #ddd;
  }

  .sidebar-nav li a:active, .sidebar-nav li a:focus {
    text-decoration: none;
  }

  .sidebar-nav>.sidebar-brand {
    height: 65px;
    font-size: 18px;
    line-height: 60px;
  }

  .sidebar-nav>.sidebar-brand a {
    color: inherit;
  }

  .sidebar-nav>.sidebar-brand a:hover {
    /*color: #fff;*/
    /*background: none;*/
  }

  @media(min-width:768px) {
    #wrapper {
      padding-left: 0;
    }
    #wrapper.toggled {
      padding-left: 250px;
    }
    #sidebar-wrapper {
      width: 0;
    }
    #wrapper.toggled #sidebar-wrapper {
      width: 250px;
    }
    #page-content-wrapper {
      padding: 20px;
      position: relative;
    }
    #wrapper.toggled #page-content-wrapper {
      position: relative;
      margin-right: 0;
    }
  }
</style>