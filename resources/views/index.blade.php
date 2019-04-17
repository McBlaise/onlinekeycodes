<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <link rel="stylesheet" type="text/css" href="/css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Keycodes</title>
  </head>
  <body style="background-color: #ececee">
    <div id="lock" class="">
     
        <topbar 
            :is-loggedin="loggedin" 
            :currentpage="currentPage" 
            :type="type"> 
        </topbar>
        <br><br><br>
        <div class="">
            <transition name="fade">
              <router-view  
                v-on:current-page="currentPage = arguments[0]" 
                v-on:status="status = arguments[0]" 
                :is-loggedin="loggedin" style="min-height: 550px">
              </router-view>
            </transition>
        </div>
        <footer-vue></footer-vue>
    </div>

    <script src="/js/app.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
  </body>
</html>