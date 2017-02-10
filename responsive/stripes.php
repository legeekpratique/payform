<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Your site description." />
    <title>L'increvable</title>

    <link href="responsive.css" rel="stylesheet" />

</head>
<body>
  <div class="form">
    <form action="/paiement.php" method="POST" id="payment-form">
    <span class="payment-errors"></span>

    <div class="form-row">
      <label>
        <span>Card Number</span>
        <input type="text" size="20" data-stripe="number">
      </label>
    </div>

    <div class="form-row">
      <label>
        <span>Expiration (MM/YY)</span>
        <input type="text" size="2" data-stripe="exp_month">
      </label>
      <span> / </span>
      <input type="text" size="2" data-stripe="exp_year">
    </div>

    <div class="form-row">
      <label>
        <span>CVC</span>
        <input type="text" size="4" data-stripe="cvc">
      </label>
    </div>

    <div class="form-row">
      <label>
        <span>Billing Postal Code</span>
        <input type="text" size="6" data-stripe="address_zip">
      </label>
    </div>

    <input type="submit" class="submit" value="Submit Payment">
  </form>
</div>



  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script src="vendor/jquery-2.1.4.js"></script>
  <script src="responsive.js"></script>
  <script type="text/javascript">
  Stripe.setPublishableKey('pk_test_Zj2YmRv5msENVe8wFsuhsXfT');

  $(function() {
  var $form = $('#payment-form');
  $form.submit(function(event) {
    // Disable the submit button to prevent repeated clicks:
    $form.find('.submit').prop('disabled', true);

    // Request a token from Stripe:
    Stripe.card.createToken($form, stripeResponseHandler);

    // Prevent the form from being submitted:
    return false;
  });
});

function stripeResponseHandler(status, response) {
  // Grab the form:
  var $form = $('#payment-form');

  if (response.error) { // Problem!

    // Show the errors on the form:
    $form.find('.payment-errors').text(response.error.message);
    $form.find('.submit').prop('disabled', false); // Re-enable submission

  } else { // Token was created!

    // Get the token ID:
    var token = response.id;

    // Insert the token ID into the form so it gets submitted to the server:
    $form.append($('<input type="hidden" name="stripeToken">').val(token));

    // Submit the form:
    $form.get(0).submit();
  }
};

</script>


</body>
</html>
