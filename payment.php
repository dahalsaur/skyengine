<?php

  // Store variables passed via query strings or URL parameters
$id = $_GET['cid'];
$fname = $_GET['firstname'];
$lname = $_GET['lastname'];
$addr = $_GET['address'];
$email = $_GET['email'];
$no = $_GET['phoneno'];
$age = $_GET['age'];
$nation = $_GET['nationality'];

  // Confidential!! Login information to connect to the mySQL database
$servername = "localhost";
$username = "sdahal";
$password = "catchmeifyoucan";
$dbname = "skyengine";

?>

<html>
<link rel="stylesheet" href="detail_styles.css">
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
<br><br><br><br><br><br><br><br><br><br>

<?php

  // Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn){
	die("Connection failed: " . mysqli_connect_error());
}

  //Inserts passenger info into mySQL table named PASSENGER
$sql = "INSERT INTO PASSENGER(FirstName,LastName,Address,Email,PhoneNo,Age,Nationality)
        VALUES('$fname','$lname','$addr','$email','$no','$age','$nation');";

mysqli_close($conn);

?>

<?php

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn){
	die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM PASSENGER ORDER BY PId DESC LIMIT 1;";

$result = mysqli_query($conn, $sql);

?>

<html>
<link rel="stylesheet" href="payment_styles.css">
<meta name="viewport" content="width=device-width, initial-scale=1">

    <body>

        <table id = "passenger">
        	<caption>Passenger Details</caption>
           <tr bgcolor="#2ECCFA">
                     <th>FirstName</th>
                     <th>Last Name</th>
                     <th>Address</th>
                     <th>Email</th>
                     <th>PhoneNo</th>
                     <th>Age</th>
                     <th>Nationality</th>

           </tr>

<?php
// output data of each row
while($row = mysqli_fetch_assoc($result)){
    echo "<tr>";
               echo "<td>".$row["FirstName"]."</td>";
               echo "<td>".$row["LastName"]."</td>";
               echo "<td>".$row["Address"]."</td>";
               echo "<td>".$row["Email"]."</td>";
               echo "<td>".$row["PhoneNo"]."</td>";
               echo "<td>".$row["Age"]."</td>";
               echo "<td>".$row["Nationality"]."</td>";
           echo "</tr>";
}

mysqli_close($conn);

?>
</table>

<br><br>

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

?>

<table id = "flight">
	<caption>Flight Details</caption>
           <tr bgcolor="#2ECCFA">
                     <th>From</th>
                     <th>To</th>
                     <th>Flight Date</th>
                     <th>Departure Time</th>
                     <th>Arrival Time</th>
                     <th>Fare</th>

           </tr>

<?php
// output data of each row
while($row = mysqli_fetch_assoc($result)){
	$airport = $row["Airport"];
    $destination = $row["Destination"];
    $fare = $row["Fare"];
    $date = $row["FlightDate"];
    $dtime = $row["DepartureTime"];
    $atime = $row["ArrivalTime"];

    echo "<tr>";
               echo "<td>".$row["Airport"]."</td>";
               echo "<td>".$row["Destination"]."</td>";
               echo "<td>".$row["FlightDate"]."</td>";
               echo "<td>".$row["DepartureTime"]."</td>";
               echo "<td>".$row["ArrivalTime"]."</td>";
                echo "<td>".$row["Fare"]."</td>";
           echo "</tr>";

}

mysqli_close($conn);
?>

</table>
</body>
</html>
