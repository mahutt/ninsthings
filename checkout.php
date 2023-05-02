<?php 
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
  // temporarily update SQl db (figure out how to do this) while purchase is attemtped
  // if update fails (not enough stock anymore) - send to another page
  
  foreach ($_POST as $key => $value) {
    echo "(".$key." => ".$value.") ";
  }

  /*
  require_once 'stripe-php-10.12.1/init.php';
  require_once 'secrets.php';

  \Stripe\Stripe::setApiKey($stripeSecretKey); # Defined in secrets.php
  $DOMAIN = 'http://localhost/nins';
  */

  // getting all orders from $_POST and matching them with db to get imgs!
  // then looping through all to create line items

  /*
  $checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    
    // example of 1 product:
    'line_items' => [[
        'price_data' => [
          'currency' => 'cad',
          'unit_amount' => ($price * 100), // make sure is defined when looping
          'product_data' => [
            'name' => $name, // make sure is defined
            'description' => $size, // make sure is defined
            'images' => [$DOMAIN.'/'.$img.'/1.jpg'], // make sure $img is defined
          ],
        ],
        'quantity' => $quantity, // make sure is defined
      ]],
      // end foreach




    
    
    
    
    
    
    'mode' => 'payment',
    'success_url' => $DOMAIN.'/success.php', // redirect through index?
    'cancel_url' => $DOMAIN.'/cancel.php',
  ]); */
  
  // header("HTTP/1.1 303 See Other");
  // header("Location: " . $checkout_session->url);


}


// calculate total, pass image(s), proceed to checkout!
// (if not valid form, redirect to what?)









?>

