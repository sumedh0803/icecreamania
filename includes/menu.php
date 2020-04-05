<?php
    require_once "navigation_bar.php";
    if(isset($_GET["productId"]) and isset($_SESSION["cartItemsList"])){
        foreach($_SESSION["cartItemsList"] as $key => $value){
            if($key == $_GET["productId"]){
                unset($_SESSION["cartItemsList"][$key]);
                if(empty($_SESSION["cartItemsList"])){
                    unset($_SESSION["cartItemsList"]);
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="../css/base.css">
    </head>
    <body>
        <?php
            if(isset($_SESSION["cartItemsList"])){
                $totalPrice = 0;
                $totalQuantity = 0;
                ?>
                <div class="pb-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
                                <!-- Shopping cart table -->
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
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase"></div>
                                        </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($_SESSION["cartItemsList"] as $key => $value){
                                            $totalPrice += $_SESSION["cartItemsList"][$key]["rate"] * $_SESSION["cartItemsList"][$key]["quantity"];
                                            $totalQuantity += $_SESSION["cartItemsList"][$key]["quantity"];
                                        ?>
                                        <tr>
                                            <th scope="row" class="border-0">
                                                <div class="p-2">
                                                    <img src="<?php echo $_SESSION["cartItemsList"][$key]["imagepath"]; ?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                                                    <div class="ml-3 d-inline-block align-middle">
                                                        <h5 class="mb-0">
                                                            <a href="#" class="text-dark d-inline-block align-middle">
                                                                <?php echo $_SESSION["cartItemsList"][$key]["itemname"]; ?>
                                                            </a>
                                                        </h5>
                                                        <span class="text-muted font-weight-normal font-italic d-block"></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <td class="border-0 align-middle"><strong>$<?php echo $_SESSION["cartItemsList"][$key]["rate"]; ?></strong></td>
                                            <td class="border-0 align-middle"><strong><?php echo $_SESSION["cartItemsList"][$key]["quantity"]; ?></strong></td>
                                            <td class="border-0 align-middle"><strong>$<?php echo $_SESSION["cartItemsList"][$key]["rate"] * $_SESSION["cartItemsList"][$key]["quantity"]; ?></strong></td>
                                            <td class="border-0 align-middle">
                                                <button class="btn btn-danger" onClick='location.href="?productId=<?php echo $key; ?>"'><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><a href="#" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                                            <td colspan="2" class="hidden-xs"></td>
                                            <td class="hidden-xs text-center"><strong>Total $ <?php echo $totalPrice;?></strong></td>
                                            <td><a href="#" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
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
                echo "Your cart is empty!";
            }
        ?>
    </body>
</html>
