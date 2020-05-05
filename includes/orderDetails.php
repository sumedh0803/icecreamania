<?php
    session_start();
    require_once "dbcontroller.php";
    if(isset($_SESSION['username']) && isset($_SESSION['userid']) && isset($_SESSION['usertype']))
    {
      $username =  $_SESSION['username'];
      $userid = $_SESSION['userid'];
      $usertype = $_SESSION['usertype'];  
      ?>
      <script>
          usertype = "<?php echo $usertype ?>"
          username = "<?php echo $username ?>"
          userid = "<?php echo $userid ?>"
          canSeeMenu = "1";
      </script>
      <?php
    }
    else
    {
      $username =  "Guest";
      $userid = "999";
      $usertype = "user";
    ?>
<script>
      alert("Please sign in first");
      canSeeMenu = "0"
      usertype = "user"
      username = "Guest"
      userid = "999"</script>;
<?php 
    }
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
        <link rel="stylesheet" href="../css/menu.css">
        <script src="../js/menu.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <!-- Title -->
                    <a href = "../menu.php" style = "color:white;"><span class="mdl-layout-title">Ice Creamania!</span></a>
                    <!-- Add spacer, to align navigation to the right (add spacer if no search bar)
                    <div class="mdl-layout-spacer"></div> -->
                    <div class="mdh-expandable-search mdl-cell--hide-phone" style="margin-left:190px;">
                    
                    <form action="#" style = "margin-bottom: 0px;">
                        <input type="text" placeholder="Search" size="1" id="search-bar">
                    </form>
                    <i class="material-icons search">search</i>
                    <i class="material-icons clear">clear</i>
                    </div>
                    

                    <ul class = "sugg-box">
                    
                    </ul>
                    <!-- Navigation. We hide it in small screens. -->
                    <nav class="mdl-navigation mdl-layout--large-screen-only">
                        <button class="mdl-button mdl-js-button gotu top-bar-btn" id = "adminpanel">Adminpanel</button>
                        <button class="mdl-button mdl-js-button gotu top-bar-btn" id = "profile" >Hello, <?php echo $username; ?></button>
                        <button class="mdl-button mdl-js-button gotu top-bar-btn" id = "cart"><img src="../images/cartImage.png" id="cart-image"/>Cart</button>
                    </nav>
                </div>
            </header>
        <main class="mdl-layout__content">
            <div class="page-content">
                <div id="results">
            <?php
            if(isset($_GET["orderId"])){
                $dbcontroller = new DBController();
                $dbcontroller -> connectDb();
                $orderId = $_GET["orderId"];
                $transactionDetails = $dbcontroller -> runQuery("SELECT price from transaction where tid = $orderId");
                $transactionResult = mysqli_fetch_assoc($transactionDetails);
                $orderDetails = $dbcontroller -> runQuery("SELECT quantity,itemname,price,imagepath,oid from orders,inventory where tid = $orderId and o_itemid = itemid");
                $totalPrice = 0;
                $totalQuantity = 0;
        ?>
                <div class="pb-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
                                <div class="table-responsive">
                                    <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border-0 bg-light">
                                                <div class="p-2 px-3 text-uppercase">Product</div>
                                            </th>
                                            <th scope="col" class="border-0 bg-light">
                                                <div class="py-2 text-uppercase">Price</div>
                                            </th>
                                            <th scope="col" class="border-0 bg-light">
                                                <div class="py-2 text-uppercase">Quantity</div>
                                            </th>
                                            <th scope="col" class="border-0 bg-light">
                                                <div class="py-2 text-uppercase">Subtotal</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($orderDetails -> num_rows > 0){
                                            while($row = mysqli_fetch_assoc($orderDetails)) {
                                                $totalPrice += $row["price"] * $row["quantity"];
                                                ?>
                                                <tr>
                                                    <th scope="row" class="border-0">
                                                        <div class="p-2">
                                                            <img src="<?php echo $row["imagepath"]; ?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                                                            <div class="ml-3 d-inline-block align-middle">
                                                                <h5 class="mb-0">
                                                                    <a href="#" class="text-dark d-inline-block align-middle">
                                                                        <?php echo $row["itemname"]; ?>
                                                                    </a>
                                                                </h5>
                                                                <span class="text-muted font-weight-normal font-italic d-block"></span>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <td class="border-0 align-middle"><strong>$<?php echo $row["price"]; ?></strong></td>
                                                    <td class="border-0 align-middle"><strong><?php echo $row["quantity"]; ?></strong></td>
                                                    <td class="border-0 align-middle"><strong>$<?php echo $row["price"] * $row["quantity"]; ?></strong></td>
                                                </tr>
                                                <?php
                                                    $oid = "'".$row['oid']."'";
                                                    $orderExtras = $dbcontroller -> runQuery("SELECT oc_eid from order_customization where oc_oid = $oid");
                                                    while($extras = mysqli_fetch_assoc($orderExtras)){
                                                        $eid = "'".$extras["oc_eid"]."'";
                                                        $extraDetails = $dbcontroller -> runQuery("SELECT ename,rate from extras where eid = $eid");
                                                        while($det = mysqli_fetch_assoc($extraDetails)){
                                                            ?>
                                                            <tr>
                                                                <th scope="row" class="border-0">
                                                                    <div class="p-2">
                                                                        <div class="ml-3 d-inline-block align-middle">
                                                                            <h5 class="mb-0">
                                                                                <a href="#" class="text-dark d-inline-block align-middle">
                                                                                    <?=$det["ename"]; ?>
                                                                                </a>
                                                                            </h5>
                                                                            <span class="text-muted font-weight-normal font-italic d-block"></span>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                                <td class="border-0 align-middle"><strong>$<?=$det["rate"]; ?></strong></td>
                                                                <td class="border-0 align-middle"><strong>1</strong></td>
                                                                <td class="border-0 align-middle"><strong>$<?= $det["rate"]?></strong></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    }
                                                ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><a href="orders.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Back to orders</a></td>
                                            <td colspan="2" class="hidden-xs"></td>
                                            <td class="hidden-xs text-center">
                                                <strong>
                                                    <?php 
                                                        $finalCost = $transactionResult['price'];
                                                        $diff = floatval($totalPrice - $finalCost);
                                                        if($diff > 0){
                                                            ?>
                                                            Total $ <?php echo $totalPrice ?></br>
                                                            Coupon Discount -$<?php echo $diff ?></br>
                                                            <?php
                                                        }
                                                    ?>
                                                    Final Price $ <?php echo $finalCost;?>
                                                </strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
            else{
                echo "No order details to display";
            }
            $dbcontroller -> close();
        ?>
            </div>
        </main>
        </div>
    </body>
</html>
