<?php
    require_once "navigation_bar.php";
    if(!empty($_GET["action"])){
        $getProductDetails = $dbcontroller -> runQuery("Select * from inventory where itemid = '". $_GET["productId"] ."'");
        $productDetailsResult = mysqli_fetch_assoc($getProductDetails);
        $cartItem = array();
        $cartItem[$productDetailsResult["itemid"]] = array('itemname' => $productDetailsResult["itemname"], 'rate' => $productDetailsResult["rate"], 'imagepath' => $productDetailsResult["imagepath"], 'quantity' => $_POST["quantity"]);
        if(isset($_SESSION["cartItemsList"])){
            if(in_array($productDetailsResult["itemid"],array_keys($_SESSION["cartItemsList"]))){
                foreach($_SESSION["cartItemsList"] as $key => $value){
                    if($productDetailsResult["itemid"] == $key){
                        if(empty($_SESSION["cartItemsList"][$key]["quantity"])){
                            $_SESSION["cartItemsList"][$key]["quantity"] = 0;
                        }
                        $_SESSION["cartItemsList"][$key]["quantity"] += $_POST["quantity"];
                    }
                }
            }
            else{
                $_SESSION["cartItemsList"] += $cartItem;
            }
        }
        else{
            $_SESSION["cartItemsList"] = $cartItem;
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="../css/base.css">
    </head>
    <body>
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <!-- List group-->
                    <ul class="list-group shadow">
                        <?php
                            //Get products which are not deleted by the admin
                            $resultSet = $dbcontroller -> runQuery("Select * from inventory where deleteitem = 0 order by itemid ASC");
                            if(!$resultSet -> num_rows === 0){
                                echo "no results";
                            }
                            else{
                                while($row = mysqli_fetch_assoc($resultSet)) {
                        ?>
                                    <li class="list-group-item">
                                        <form action="products.php?action=addItem&productId=<?php echo $row["itemid"]?>" method="post">
                                            <div class="media align-items-lg-center flex-column flex-lg-row p-3">
                                                <div class="media-body order-2 order-lg-1">
                                                    <h5 class="mt-0 font-weight-bold mb-2"><?php echo $row["itemname"]; ?></h5>
                                                    <p class="font-italic text-muted mb-0 small"><?php echo $row["description"]; ?></p>
                                                    <div class="d-flex align-items-center justify-content-between mt-1">
                                                        <h6 class="font-weight-bold my-2"><?php echo "$".$row["rate"]; ?></h6>
                                                        <input type="text" class="product-quantity" name="quantity" value="1" size="2" />
                                                        <input type="submit" value="Add to Cart" class="btnAddAction" />
                                                    </div>
                                                </div>
                                                <img src="https://png2.kisspng.com/sh/6ed0d41aa194fb899f8ed29aa948b1ee/L0KzQYq3U8A1N5dxepH0aYP2gLBuTfFxeJ1qRdt5aHBxdX7Bk71uaakygeJxb37oPcn5TgNuaaN5iNp4bnWwecHvjB5mNWZoRdt5aHBxdX7Bkr0zPWdsep92aT3meLK0iBNpNZl0jJ9taT24c4jqhcFnbZQ7e6VtOD60QIe7WckxQWI6TaMBOEi0SYGBUcQzNqFzf3==/kisspng-apple-iphone-xs-max-iphone-xr-smartphone-iphone-5c-iphone-xr-256gb-mi-cha-kch-hot-di-5c7ce1fec6c3d8.1064990915516881908142.png" alt="Generic placeholder image" width="200" class="ml-lg-5 order-1 order-lg-2">
                                            </div> <!-- End -->
                                        </form>
                                    </li> <!-- End -->
                        <?php
                                }
                            }
                        ?>
                    </ul> <!-- End -->
                </div>
            </div>
        </div>
    </body>
</html>
