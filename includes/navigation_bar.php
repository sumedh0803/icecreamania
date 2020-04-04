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
      <dialog id="dialog" class="mdl-dialog">
        <h3 class="mdl-dialog__title">MDL Dialog</h3>
        <div class="mdl-dialog__content">
          <p>
            This is an example of the Material Design Lite dialog component.
            Please use responsibly.
          </p>
        </div>
        <div class="mdl-dialog__actions">
          <button type="button" class="mdl-button">Close</button>
          <button type="button" class="mdl-button" disabled>Disabled action</button>
        </div>
      </dialog>
      <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">
          <div class="mdl-layout__header-row">
            <!-- Title -->
            <span class="mdl-layout-title">Ice Creamania!</span>
            <div class="input-group" id="searchBar">
              <input type="text" class="form-control">
              <div class="input-group-append">
                <button class="btn btn-info" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
            <!-- Add spacer, to align navigation to the right -->
            <div class="mdl-layout-spacer"></div>
            <!-- Navigation. We hide it in small screens. -->
            <nav class="mdl-navigation mdl-layout--large-screen-only">
                <a class="mdl-button mdl-js-button gotu top-bar-btn">Account</a>
                <a class="mdl-button mdl-js-button gotu top-bar-btn" id = "cart" href="./cart.php"><img src="../images/cartImage.png" id="cart-image"/>Cart</a>
            </nav>
          </div>
        </header>
  </body>
</html>
