<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>National Geographic presents Machu Picchu</title>
<link href="css/machu_picchu.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js'></script>
<script type="text/javascript">

  
	



var messageDelay = 2000;  // How long to display status messages (in milliseconds)

// Init the form once the document is ready
$( init );


// Initialize the form

function init() {

  // Hide the form initially.
  // Make submitForm() the form's submit handler.
  // Position the form so it sits in the centre of the browser window.
  $('#contactForm').hide().submit( submitForm ).addClass( 'positioned' );
	
	
		
		
  // When the "contact" link is clicked:
  // 1. Fade the content out
  // 2. Display the form
  // 3. Move focus to the first field
  // 4. Prevent the link being followed

  $('a[href="#contactForm"]').click( function() {
    $('#container').fadeTo( 'slow', .2 );
    $('#contactForm').fadeIn( 'slow', function() {
      $('#senderName').focus();
    } )

    return false;
  } );
  
 
  // When the "Cancel" button is clicked, close the form
  $('#cancel').click( function() { 
    $('#contactForm').fadeOut();
    $('#container').fadeTo( 'slow', 1 );
  } );  

  // When the "Escape" key is pressed, close the form
  $('#contactForm').keydown( function( event ) {
    if ( event.which == 27 ) {
      $('#contactForm').fadeOut();
      $('#container').fadeTo( 'slow', 1 );
    }
  } );

}



// Submit the form via Ajax

function submitForm() {
  var contactForm = $(this);

  // Are all the fields filled in?

  if ( !$('#senderName').val() || !$('#senderEmail').val() || !$('#message').val() ) {

    // No; display a warning message and return to the form
    $('#incompleteMessage').fadeIn().delay(messageDelay).fadeOut();
    contactForm.fadeOut().delay(messageDelay).fadeIn();

  } else {

    // Yes; submit the form to the PHP script via Ajax

    $('#sendingMessage').fadeIn();
    contactForm.fadeOut();

    $.ajax( {
      url: contactForm.attr( 'action' ) + "?ajax=true",
      type: contactForm.attr( 'method' ),
      data: contactForm.serialize(),
      success: submitFinished
    } );
  }

  // Prevent the default form submission occurring
  return false;
}


// Handle the Ajax response

function submitFinished( response ) {
  response = $.trim( response );
  $('#sendingMessage').fadeOut();

  if ( response == "success" ) {

    // Form submitted successfully:
    // 1. Display the success message
    // 2. Clear the form fields
    // 3. Fade the content back in

    $('#successMessage').fadeIn().delay(messageDelay).fadeOut();
    $('#senderName').val( "" );
    $('#senderEmail').val( "" );
    $('#message').val( "" );

    $('#container').delay(messageDelay+500).fadeTo( 'slow', 1 );

  } else {

    // Form submission failed: Display the failure message,
    // then redisplay the form
    $('#failureMessage').fadeIn().delay(messageDelay).fadeOut();
    $('#contactForm').delay(messageDelay+500).fadeIn();
  }
}
 

</script>
<?php include('includes/needed_variables.php');?>
<?php if($section== '-1'){?>

<meta http-equiv="refresh" content="0;URL=index.php?section=home" />
<?php }?>
</head>

<body <?php if(isset($_GET['section'])){echo 'class="'.$_GET['section'].'"';}else{echo 'class="home"';}?>>
<div id="header"><?php include('includes/header.php');?></div>
<div id="wrapper">
<div id="container">
<div id="global_nav"><?php include('includes/global_nav.php');?></div>
	

<div id="content">
<div id="main"><?php include('includes/body_content.php');?> </div>

</div></div></div>
<div id="footer"><?php include('includes/footer.php');?></div>
<form id="contactForm" action="processForm.php" method="post">

<h2></h2>

<ul>

<li>
<label for="senderName">Your Name</label>
<input type="text" name="senderName" id="senderName" placeholder="Please type your name" required="required" maxlength="40"/>
</li>

<li>
<label for="senderEmail">Your Email Address</label>
<input type="email" name="senderEmail" id="senderEmail" placeholder="Please type your email address" required="required" maxlength="50"/>
</li>

<li>
<label for="message" style="padding-top:.5em;">Comments</label>
<textarea name="message" id="message" placeholder="Please type your message" required="required" cols="80" rows="10" maxlength="10000"></textarea>
</li>

</ul>

<div id="formButtons">
<input type="submit" id="sendMessage" name="sendMessage" value="Send Email"/>
<input type="button" id="cancel" name="cancel" value="Cancel"/>
</div>

</form>
</body>
</html>
