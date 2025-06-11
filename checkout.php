<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Astonish</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/owl.css">

  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
<?php 
include('header.php');

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Get subtotal from POST (coming from cart page)
if(isset($_POST['sub_total'])) {
    $sub_total = $_POST['sub_total'];
} else {
    // Calculate subtotal from cart items if not provided
    $sub_total = 0;
    $cart_query = mysqli_query($conn, "SELECT c.qty, p.p_price FROM cart c JOIN products p ON c.p_id = p.p_id WHERE c.user_id = '$user_id'");
    
    if(mysqli_num_rows($cart_query) > 0) {
        while($cart_item = mysqli_fetch_assoc($cart_query)) {
            $sub_total += ($cart_item['qty'] * $cart_item['p_price']);
        }
    } else {
        echo "<script>alert('Your cart is empty. Please add items to cart first.'); window.location.href='cart.php';</script>";
        exit();
    }
}

// Process order when form is submitted
if(isset($_POST['submit'])) {
    $sub_total = $_POST['total'];
    $pre_name = $_POST['pre_name'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mno = $_POST['mno'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $payment = $_POST['payment'];
    $status = "Order has been dispatched";
    
    // Check stock availability before processing order
    $stock_available = true;
    $out_of_stock_products = array();
    
    $cart_check_query = mysqli_query($conn, "SELECT c.p_id, c.qty as cart_qty, p.p_name, p.qty as stock_qty 
                                           FROM cart c 
                                           JOIN products p ON c.p_id = p.p_id 
                                           WHERE c.user_id = '$user_id'") or die('stock check query failed');
    
    while($item = mysqli_fetch_assoc($cart_check_query)) {
        if($item['stock_qty'] < $item['cart_qty']) {
            $stock_available = false;
            $out_of_stock_products[] = $item['p_name'] . " (Available: " . $item['stock_qty'] . ", Requested: " . $item['cart_qty'] . ")";
        }
    }
    
    if(!$stock_available) {
        echo "<script>alert('Sorry, the following products are out of stock or have insufficient quantity:\\n" . implode("\\n", $out_of_stock_products) . "');";
        echo "window.location.href = 'cart.php';</script>";
    } else {
        // Insert order
        $order_insert = mysqli_query($conn, "INSERT INTO `orders`(`user_id`, `total`, `pre_name`, `name`, `email`, `mno`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `payment`, `status`)
             VALUES ('$user_id','$sub_total','$pre_name','$name','$email','$mno','$address1','$address2','$city','$state','$zip','$country','$payment','$status')");
        
        if($order_insert) {
            // Update product quantities
            $cart_query = mysqli_query($conn, "SELECT p_id, qty FROM cart WHERE user_id = '$user_id'");
            
            while($cart_item = mysqli_fetch_assoc($cart_query)) {
                $product_id = $cart_item['p_id'];
                $ordered_quantity = $cart_item['qty'];
                
                // Decrease product quantity
                mysqli_query($conn, "UPDATE products SET qty = qty - '$ordered_quantity' WHERE p_id = '$product_id'");
            }
            
            // Clear the cart
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
            
            echo "<script>alert('Order placed successfully - Track Order'); window.location.href = 'index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error placing order. Please try again.');</script>";
        }
    }
}
?>

    <!-- Page Content -->
   
      <div class="container">
        <div class="row">
        </div>
      </div>

    <div class="products call-to-action">
      <div class="container">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <div class="row">
                  <div class="col-6">
                       <em>Sub-total</em>
                  </div>
                  
                  <div class="col-6 text-right">
                       <strong>Dz <?php echo $sub_total; ?></strong>
                  </div>
             </div>
          </li>
          
          <li class="list-group-item">
               <div class="row">
                    <div class="col-6">
                         <em>Extra</em>
                    </div>

                    <div class="col-6 text-right">
                         <strong>Dz 0.00</strong>
                    </div>
               </div>
          </li>

          <li class="list-group-item">
               <div class="row">
                    <div class="col-6">
                         <em>Tax</em>
                    </div>

                    <div class="col-6 text-right">
                         <strong>Dz 0.00</strong>
                    </div>
               </div>
          </li>

          <li class="list-group-item">
               <div class="row">
                    <div class="col-6">
                      <h4><em>Total</em></h4>
                    </div>

                    <div class="col-6 text-right">
                         <h4><strong>Dz <?php echo $sub_total; ?></strong></h4>
                    </div>
               </div>
          </li>

        </ul>

        <br>
        
        <div class="inner-content">
          <div class="contact-form">
              <form action="" method="post">
                    <input type="hidden" name="total" value="<?php echo $sub_total; ?>">
                   <div class="row">
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Title:</label>
                                  <select class="form-control" data-msg-required="This field is required." name="pre_name" required>
                                       <option value="">-- Choose --</option>
                                       <option value="mr">Mr.</option>
                                       <option value="miss">Miss</option>
                                       <option value="mrs">Mrs.</option>
                                       <option value="ms">Ms.</option>
                                       <option value="dr">Dr.</option>
                                       <option value="other">Other</option>
                                       <option value="prof">Prof.</option>
                                       <option value="rev">Rev.</option>
                                  </select>
                             </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Name:</label>
                                  <input type="text" class="form-control" name="name" required>
                             </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Email:</label>
                                  <input type="text" class="form-control" name="email" required>
                             </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Phone:</label>
                                  <input type="text" class="form-control" name="mno" required>
                             </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Address 1:</label>
                                  <input type="text" class="form-control" name="address1" required>
                             </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Address 2:</label>
                                  <input type="text" class="form-control" name="address2" required>
                             </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">City:</label>
                                  <input type="text" class="form-control" name="city" required>
                             </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">State:</label>
                                  <input type="text" class="form-control" name="state" required>
                             </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Zip:</label>
                                  <input type="text" class="form-control" name="zip" required>
                             </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Country:</label>
                                  <select class="form-control" name="country" required>
                                       <option value="Algeria">Algeria</option>
                                  </select>
                             </div>
                        </div>
                   </div>

                   <div class="row">
                        <div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                  <label class="control-label">Payment method</label>

                                  <select class="form-control" name="payment" required>
                                       <option value="Cash on delivery">Cash on delivery</option>
                                       <!-- <option value="bank">Bank account</option>
                                       <option value="paypal">PayPal</option> -->
                                  </select>
                             </div>
                        </div>
                   </div>

                   <div class="form-group">
                        <label class="control-label">
                             <input type="checkbox" required>

                             I agree with the <a href="terms.php" target="_blank" style="color: black;">Terms &amp; Conditions</a>
                        </label>
                   </div>

                   <div class="clearfix">
                        <button type="button" class="filled-button pull-left">Back</button>
                        
                        <button type="submit" class="filled-button pull-right" name="submit">Finish</button>
                   </div>
              </form>
          </div>
        </div>
      </div>
    </div>

    <?php 
     include('footer.php');
   ?>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Book Now</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="contact-form">
              <form action="#" id="contact">
                  <div class="row">
                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Pick-up location" required="">
                          </fieldset>
                       </div>

                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Return location" required="">
                          </fieldset>
                       </div>
                  </div>

                  <div class="row">
                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Pick-up date/time" required="">
                          </fieldset>
                       </div>

                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Return date/time" required="">
                          </fieldset>
                       </div>
                  </div>
                  <input type="text" class="form-control" placeholder="Enter full name" required="">

                  <div class="row">
                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Enter email address" required="">
                          </fieldset>
                       </div>

                       <div class="col-md-6">
                          <fieldset>
                            <input type="text" class="form-control" placeholder="Enter phone" required="">
                          </fieldset>
                       </div>
                  </div>
              </form>
           </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary">Book Now</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
  </body>

</html>
