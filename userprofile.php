<?php
session_start();
$username =  $_SESSION['username'];
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];  

require_once("includes/dbcontroller.php");
$db = new dbcontroller();
$db -> connectDb();

$sql = "SELECT fname, lname, email, gender, points FROM user WHERE uid = $userid";
$result = $db->runQuery($sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Spicy+Rice&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.pink-blue.min.css">
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/userprofile.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script>
        usertype = "<?php echo $usertype; ?>"
        username = "<?php echo $username; ?>"
        userid = "<?php echo $userid; ?>"
        gender = "<?php echo $row['gender']; ?>"
        points = "<?php echo $row['points']; ?>"
        lname = "<?php echo $row['lname']; ?>"
    </script>
    <script src="./js/userprofile.js"></script>    
    <title>Ice Creamania | UserProfile</title>
</head>
<body>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
        <!-- Title -->
        <a class="mdl-layout-title" href = "index.php">Ice Creamania!</a>
        <!-- Add spacer, to align navigation to the right (add spacer if no search bar)
        <div class="mdl-layout-spacer"></div> -->
        <div class="mdh-expandable-search mdl-cell--hide-phone">
            <i class="material-icons">search</i>
            <form action="#">
            <input type="text" placeholder="Search" size="1">
            </form>
        </div>
        <!-- Navigation. We hide it in small screens. -->
        <nav class="mdl-navigation mdl-layout--large-screen-only">
            <div id="tt1" class="icon material-icons"><button class="mdl-button mdl-js-button gotu top-bar-btn points"></button>
            </div>
                <div class="mdl-tooltip mdl-tooltip--large" data-mdl-for="tt1">
                Earn 100 points to get a free Sundae!
                </div>
            <button class="mdl-button mdl-js-button gotu top-bar-btn"><a href="signout.php">Sign Out</a></button>
        </nav>
        </div>
    </header>
    
    <main class="mdl-layout__content">
        <div class="page-content"><!-- Your content goes here -->
                <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer">
                        <div class="mdl-layout__drawer  custom-side-bar">
                            <div class="userprofile border">
                                <img src = "images/woman.png" alt="User Profile" class="userphoto">
                            </div>
                            <div class="username gotu">
                                <span class="name"><?php echo $row['fname']." ".$row['lname'] ?></span><br>
                                <span class="emailaddr"><?php echo $row['email'] ?></span><br>
                            </div>
                        <nav class="mdl-navigation">
                            <a class="mdl-navigation__link" id="myprofile" href="#">My Profile</a>
                            <a class="mdl-navigation__link" id="transactions" href="#">My Transactions</a>
                        </nav>
                        </div>
                        <main class="mdl-layout__content" style="margin-left: 20%;">
                            <div class="page-content" style="height: 100%; position: relative;">
                                    <div class = "bg">
                                        <div class="card main-card">
                                            <h3 class="gotu" style="margin-left: 2%;">Edit Profile:</h3>
                                            <form action="#" class="editform" style="padding-left: 2%; margin-bottom: 2%;">
                                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%; padding-right: 2%;" required>
                                                    <input class="mdl-textfield__input" type="text" id="fname">
                                                    <label class="mdl-textfield__label" for="fname">First Name</label>
                                                  </div>
                                                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%;">
                                                    <input class="mdl-textfield__input" type="text" id="lname">
                                                    <label class="mdl-textfield__label" for="lname">Last Name</label>
                                                  </div>
                                                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%; padding-right: 2%;">
                                                    <input class="mdl-textfield__input" type="text" id="addr11">
                                                    <label class="mdl-textfield__label" for="addr11">Address1</label>
                                                  </div>
                                                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%;">
                                                    <input class="mdl-textfield__input" type="text" id="addr12">
                                                    <label class="mdl-textfield__label" for="addr12">Address2</label>
                                                  </div>
                                                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%; padding-right: 2%;">
                                                    <input class="mdl-textfield__input" type="text" id="city">
                                                    <label class="mdl-textfield__label" for="city">City</label>
                                                  </div>
                                                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%;">
                                                    <input class="mdl-textfield__input" type="number" id="zip">
                                                    <label class="mdl-textfield__label" for="zip">Zip Code</label>
                                                  </div><br>

                                                  <div class="adddeletebtns" style="">
                                                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent addbtn">
                                                        Add Address
                                                   </button>
                                                   <button class="mdl-button mdl-js-button mdl-button--accent cancelbtn" style="color:rgb(233,30,99); display: none;">
                                                        Cancel
                                                    </button>
                                                  </div>  

                                                    <div class="secaddr" style="display: none;">
                                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%; padding-right: 2%;">
                                                        <input class="mdl-textfield__input" type="text" id="addr21">
                                                        <label class="mdl-textfield__label" for="addr21">Address1</label>
                                                        </div>
                                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%;">
                                                            <input class="mdl-textfield__input" type="text" id="addr22">
                                                            <label class="mdl-textfield__label" for="addr22">Address2</label>
                                                        </div>
                                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%; padding-right: 2%;">
                                                            <input class="mdl-textfield__input" type="text" id="city2">
                                                            <label class="mdl-textfield__label" for="city2">City</label>
                                                        </div>
                                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 48%;">
                                                            <input class="mdl-textfield__input" type="number" id="zip2">
                                                            <label class="mdl-textfield__label" for="zip2">Zip Code</label>
                                                        </div><br>
                                                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent deletebtn" style="background-color:rgb(233,30,99);">
                                                            Delete Address
                                                        </button>
                                                    </div>

                                                  <!-- Accent-colored raised button -->
                                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent savebtn" style="margin-left: 40%; margin-top:3%;">
                                                        Save Changes
                                                    </button>
                                              </form>
                                        </div>
                                        <div class="card main-card1" style="display: none;">
                                            <div class="mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active spinner" style = "display:block"></div>
                                                <!-- Table dyanamically created in JS -->
                                        </div>
                                    </div>
                            </div>
                        </main>
                </div>

            </div>
    </main>
</div>
      
<script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>