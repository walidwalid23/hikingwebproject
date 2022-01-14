<!-- set the expand limit before the shrink of the navbar -->
<html>

<head>
    <link rel="stylesheet" href="navbar.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="icons/css/all.css">

</head>

<body>

    <nav id="navigation-bar" class="navbar sticky-top navbar-light navbar-expand-sm">

        <div class="collapse navbar-collapse" id="expandme">
            <div class="navbar-nav">
                <a href="home.php" style="color:#6F4E37" class="nav-item nav-link"> Home</a>
                <?php
                session_start();
                $hiker_id=($_COOKIE["remember"]=="yes")?$_COOKIE["ID"]:$_SESSION["ID"];
                echo ' <a href="profilepage.php?hikerid='.$hiker_id.'" style="color:#6F4E37" class="nav-item nav-link"> Profile</a>';
               echo' <a href="signout.php" style="color:#6F4E37" id="signout-button" class="nav-item nav-link"><i class="fas fa-share-square"></i> Sign Out</a>';
                try{
                $hiker_id=($_COOKIE["remember"]=="yes")?$_COOKIE["ID"]:$_SESSION["ID"];
                //CONNECTING TO THE DATABASE
                $db_conn=mysqli_connect("localhost","root","","hiking");
                if(!$db_conn){ echo '<h5 style="color:red;margin-left:200px;">Couldn"t Connect To Database<br>';}
                //DISPLAY THE NEW INBOX MESSAGES NUMBER IF THEY ARE > 0 
                $inbox_result=$db_conn->query("SELECT newmessagesnum from inbox WHERE hikerID='$hiker_id'");
                $new_messages_number=mysqli_fetch_array($inbox_result)["newmessagesnum"];
          
                if($new_messages_number>0){
                    echo' <a href="inbox.php" id="inbox-icon" style="color:#6F4E37" class="nav-item nav-link">
                    Inbox <i id="open-box-icon" class="fas fa-envelope-open"></i>';
                    echo '<span id="inbox-badge" class="badge badge-pill badge-primary">'.$new_messages_number.'</span>';
       
                }
                else{
                   echo' <a href="inbox.php" id="inbox-icon" style="color:#6F4E37" class="nav-item nav-link">
                    Inbox <i class="fas fa-envelope"></i></a>';
                    
                }
                 //echo other nav buttons
                echo' <a href="groups.php" style="color:#6F4E37" class="nav-item nav-link"> Groups</a>';
                echo'<a href="contactusform.php" style="color:#6F4E37" class="nav-item nav-link"> Contact Us</a>';
                //GET THE CART ITEMS NUMBER FROM THE DATABASE
                  $result=$db_conn->query("SELECT COUNT(productID) from cart WHERE hikerID='$hiker_id'");
                  $count_data=mysqli_fetch_array($result);
                  $items_count=$count_data["COUNT(productID)"];

               echo'<span id="cart-badge" class="badge badge-pill badge-primary">'.$items_count.'</span>';
                  }
                  catch(Exception $error){
                      echo '<h1 style="color:red">'.$error.'</h1>';
                  }
                ?>
                <!--- CART -->
                <a id="cart" href="checkout.php" style="color:#6F4E37" class="nav-item nav-link">Cart <i
                        class="fas fa-shopping-cart"></i></a>
                  <!--- SEARCH -->      
                <input id="search-bar" class="form-control" type="search" placeholder="Search Trips"
                    aria-label="Search">
                    <ul id="all-search-results">
          
                </ul>
                <button id="search-button" onclick="">Search</button>
            </div>
        </div>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#expandme">
            <span class="navbar-toggler-icon"></span>
        </button>
        
    </nav>
  <script src="livesearch.js"></script>
</body>

</html>