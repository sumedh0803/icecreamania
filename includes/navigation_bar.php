<?php
  session_start();
  require_once "dbcontroller.php";
  $dbcontroller = new DBController();
  $dbcontroller -> connectDb();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Spicy+Rice&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css2?family=Gotu&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css">
      <link rel="stylesheet" href="../css/base.css">
  </head>
  <body>
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title">Ice Creamania!</span>       
          <div class="mdh-expandable-search mdl-cell--hide-phone">
        <i class="material-icons">search</i>
        <form action="#">
          <input type="text" placeholder="Search" size="1">
        </form>
      </div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
              <button class="mdl-button mdl-js-button gotu top-bar-btn" id = "login" >Login</button>
              <button class="mdl-button mdl-js-button gotu top-bar-btn">Sign Up</button>
          </nav>
        </div>
      </header>
        <main class="mdl-layout__content">
        <h1></h1>
      </main>
      </div>
  </body>
</html>


<!-- <div class="input-group" id="searchBar">
              <input type="text" class="form-control">
              <div class="input-group-append">
                <button class="btn btn-info" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div> 
          <nav class="mdl-navigation mdl-layout--large-screen-only">
                <a class="mdl-button mdl-js-button gotu top-bar-btn">Account</a>
                <a class="mdl-button mdl-js-button gotu top-bar-btn" id = "cart" href="./cart.php"><img src="../images/cartImage.png" id="cart-image"/>Cart</a>
            </nav>-->