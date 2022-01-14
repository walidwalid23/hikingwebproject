<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="contactusform.css">
    <title>Contact Us</title>
</head>
<body>
   <?php
   include 'navbar.php';
   ?> 
  <h1 id="header"> Contact Us </h1>
<form>
  <div class="form-group">
    <label class="labels" for="message-title"><b>Title</b></label>
    <input type="text" class="form-control" id="message-title"  placeholder="Enter Message Title">
  </div>
  <div class="form-group">
    <label class="labels" for="message-body"><b>Message</b></label>
    <textarea class="form-control" id="message-body" rows="4" placeholder="Enter Your Message Here">
</textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>