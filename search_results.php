<?php

    // Store variables passed via query strings to auto fill the form.
$from = $_GET['airport'];
$to = $_GET['destination'];
$date = $_GET['flightdate'];
$returndate = $_GET['return'];
$passengers = $_GET['passengers'];

?>


<html>
<link rel="stylesheet" href="search_results_styles.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome to SkyEngine </title>
<head id="top"></head>
<body>
<div class = "top">

      <!-- Logo and company name at the top right-->
    <div class = "logo">
        <img src="images/engine_logo.png" alt="logo" align="middle" style="width:80px;height:80px;">
        <b><em> SkyEngine</em></b>
    </div>

    <!-- Jump to different sections(Home, Recommendations, About Us, Contact Us, ...) of the webpage-->
    <div class = "tab">
        <a href="index.html#top"><button>Home</button></a>
        <a href="index.html#recommend"><button>Recommendations</button></a>
        <a href="index.html#about"><button>About Us</button></a>
        <a href="index.html#contact"><button>Contact Us</button></a>
        <a href="index.html#impressum"><button>Impressum</button></a>
        <a href="index.html#sign" class="sign"><button>Log In</button></a>
    </div>
</div>

  <!-- Search edit form -->
<div class="barDiv">
    <button class="button roundButton"></button>
    <p1>Return</p1>
    <button class="button roundButton"></button>
    <p1>One Way</p1>
    <br>
    <form action = "search_results.php" type = "get">
    <div class="searchDiv">
        <div class = "col">
            <label for="from">From</label>
            <br>
            <input class = "col" type="text" value="<?php echo $from ?>" name="airport" required style="height:40px">
        </div>
        <div class = "col">
            <label for="to">To</label>
            <br>
            <input class = "col" type="text" value="<?php echo $to ?>" name="destination" required style="height:40px">
        </div>
        <div class = "col">
            <label for="depart">Depart</label>
            <br>
            <input class = "col" type="date" value="<?php echo $date ?>" name="flightdate" required style="height:40px">
        </div>
        <div class = "col">
            <label for="return">Return</label>
            <br>
            <input class = "col" type="date" value="<?php echo $returndate ?>" name="return" required disabled style="height:40px">
        </div>
        <div class = "col">
            <label for="numofpassenger">Number of passenger</label>
            <br>
            <input class = "col" type="number" required min="1" max="5" style="width:150px; height:40px" value="<?php echo $passengers ?>" name="passengers">
        </div>
        <button class="button searchButton">Search Again</button>
    </div>
</div>
<div class = "searchResults">

  <?php
  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

    //find the best(time, price) flight based on input data
  $sql = "SELECT ROUTE.Airport, ROUTE.Destination, FARE.Fare, FLIGHT.FlightDate, FLIGHT.DepartureTime, FLIGHT.ArrivalTime, FLIGHT.FlightID
    FROM ROUTE
  	INNER JOIN FARE ON ROUTE.RouteId = FARE.Route
  	INNER JOIN FLIGHT ON FARE.FareId = FLIGHT.TotalFare
  	WHERE ROUTE.Airport = '$from' AND ROUTE.Destination = '$to' AND FLIGHT.FlightDate = '$date'
  	ORDER BY FLIGHT.DepartureTime";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {

      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
      	$id = $row["FlightID"];
        $airport = $row["Airport"];
        $destination = $row["Destination"];
        $fare = $row["Fare"];
        $date = $row["FlightDate"];
        $dtime = $row["DepartureTime"];
        $atime = $row["ArrivalTime"];
    ?>
        <div class = "selectFlight">
          <div class = "departTime">
            <p2><?php echo"$dtime"; ?></p2><br>
            <p3><?php echo"$airport"; ?></p3>
          </div>
          <div class = "arrow">
            <img src= "images/arrow.png" alt="logo" align="middle" class="arrowImg">
          </div>
          <div class = "arrivalTime">
            <p2><?php echo"$atime"; ?></p2><br>
            <p3><?php echo"$destination"; ?></p3>
          </div>
          <div class = "flightPrice">
            <p3> <?php echo"$fare "; ?>euros</p3>
            <button class="selectButton"><a href = "detail.php?cid=<?php echo "$id"; ?>" style = "text-decoration: none; color: white;">Select</a></button>
          </div>
        </div>
      <?php }
  } else {
      echo " <h3>We couldn't find any flights on this date.<br> Please try on different dates and/or airports.</h3>";
  }
  mysqli_close($conn); ?>

</div>

<div class="bottom">
    <h2>Partners & Sponsors</h2>
</div>
</body>
</html>
