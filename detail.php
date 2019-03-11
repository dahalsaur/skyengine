<?php

$id = $_GET['cid'];

$servername = "";
$username = "";
$password = "";
$dbname = "";

?>

<html>
<link rel="stylesheet" href="detail_styles.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome to SkyEngine </title>
<head id="top"></head>
<body>
<div class = "top">
    <div class = "logo">
        <img src="images/engine_logo.png" alt="logo" align="middle" style="width:80px;height:80px;">
        <b><em> SkyEngine</em></b>
    </div>
    <div class = "tab">
        <a href="index.html#top"><button>Home</button></a>
        <a href="index.html#recommend"><button>Recommendations</button></a>
        <a href="index.html#about"><button>About Us</button></a>
        <a href="index.html#contact"><button>Contact Us</button></a>
        <a href="index.html#impressum"><button>Impressum</button></a>
        <a href="index.html#sign" class="sign"><button>Log In</button></a>
    </div>
</div>
<br><br>

<div class = "searchResults">

  <div class ="head1">
  <h1> Review Your Flight </h1>
  </div>

<?php
  // Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn){
	die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT ROUTE.Airport, ROUTE.Destination, FARE.Fare, FLIGHT.FlightDate, FLIGHT.DepartureTime, FLIGHT.ArrivalTime, FLIGHT.FlightID
		FROM ROUTE
		INNER JOIN FARE ON ROUTE.RouteId = FARE.Route
		INNER JOIN FLIGHT ON FARE.FareId = FLIGHT.TotalFare
		WHERE FLIGHT.FlightID = '$id'";

$result = mysqli_query($conn, $sql);
// output data of each row
while($row = mysqli_fetch_assoc($result)){
	$airport = $row["Airport"];
    $destination = $row["Destination"];
    $fare = $row["Fare"];
    $date = $row["FlightDate"];
    $dtime = $row["DepartureTime"];
    $atime = $row["ArrivalTime"];
?>
    <div class = "selectFlight">
          <div class = "departTime">
            <p2>Departure</p2><br>
            <p2><?php echo"$dtime"; ?></p2><br>
            <p3><?php echo"$airport"; ?></p3>
          </div>
          <div class = "arrow">
            <img src= "images/arrow.png" alt="logo" align="middle" class="arrowImg">
          </div>
          <div class = "arrivalTime">
            <p2>Arrival</p2><br>
            <p2><?php echo"$atime"; ?></p2><br>
            <p3><?php echo"$destination"; ?></p3>
          </div>
          <div class = "flightPrice">
            <p2>Price</p2><br>
            <p4> <?php echo"$fare "; ?>euros</p4>
          </div>
<?php } ?>
<?php mysqli_close($conn); ?>

<?php
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT AIRLINES.AirlinesName, AIRCRAFT.AIRCRNo
        FROM AIRLINES
        INNER JOIN AIRCRAFT ON AIRLINES.AirlinesName = AIRCRAFT.AirlinesName
        INNER JOIN FLIGHT ON AIRCRAFT.AIRCRId = FLIGHT.AirCraft
        WHERE FLIGHT.FlightID = '$id'";

$result = mysqli_query($conn, $sql);
// output data of each row
while($row = mysqli_fetch_assoc($result)) {
    $airname = $row["AirlinesName"];
    $airno = $row["AIRCRNo"];
?>
    <div class = "airlinename">
        <p2>Airlines Name</p2><br>
        <p3><?php echo"$airname"; ?></p3>
    </div>
    <div class = "aircraftno">
        <p2>Aircraft No</p2><br>
        <p3><?php echo"$airno"; ?></p3>
    </div>
<?php } ?>

<?php mysqli_close($conn); ?>
</div>

<h1> Book Your Ticket </h1>

<form action = "payment.php" type = "get">
    <div class="searchDiv">
        <div class = "col1">
            <p1>First Name</p1>
            <input class = "col" type="text" name="firstname" required style="height:30px">
        </div>
        <div class = "col2">
            <p1>Last Name</p1><br>
            <input class = "col" type="text" name="lastname" required style="height:30px">
        </div>
        <div class = "col3">
            <p1>Address</p1><br>
            <input class = "col" type="text" name="address" required style="height:30px">
        </div>
        <div class = "col4">
            <p1>Email</p1><br>
            <input class = "col" type="text" name="email" required style="height:30px">
        </div>
        <div class = "col5">
            <p1>Phone No</p1><br>
            <input class = "col" type="number" name="phoneno" required style="height:30px">
        </div>
        <div class = "col6">
            <p1>Age</p1><br>
            <input class = "col" type="number" name="age" required style="height:30px">
        </div>
        <div class = "col7">
            <p1>Nationality</p1><br>
            <input class = "col" type="text" name="nationality" required style="height:30px">
        </div>
    </div>
<br>
<div>
  <input type='hidden' name='cid' value='<?php echo "$id";?>'/>
  <button class="button paymentButton" type="submit">Proceed to Payment</button>
  </form>
</div>
</div>

<div class="bottom">
    <h2>Partners & Sponsors</h2>
</div>
</body>
</html>
