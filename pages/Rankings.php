<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include 'head.php' ?>
	</head>
	<body>
		<?php include 'header.php' ?>
		<div id="general_content" class="row container-fluid">
			<div class="col-md-4 col-md-offset-2">
				<h2> Transactions </h2>

				<?php
								if(isset($_POST['add']))
								{
									$dbhost = 'mysql';
									$dbuser = 'nsu';
									$dbpass = 'EqOBqlgc5TpgEYYRWMem';
									$conn = mysql_connect($dbhost, $dbuser, $dbpass);
									if(! $conn )
									{
									  die('Could not connect: ' . mysql_error());
									}

									if(! get_magic_quotes_gpc() )
									{
									   $emp_name = addslashes ($_POST['emp_name']);
									   $emp_address = addslashes ($_POST['emp_address']);
									   $emp_reason = addslashes ($_POST['emp_reason']);
									}
									else
									{
									   $emp_name = $_POST['emp_name'];
									   $emp_address = $_POST['emp_address'];
									   $emp_reason = $_POST['emp_reason'];
									}
									$emp_salary = $_POST['emp_salary'];

									$sql = "INSERT INTO pointTransactions ".
									       "(sender,receiver, points, reason) ".
									       "VALUES('$emp_name','$emp_address',$emp_salary, '$emp_reason')";
									mysql_select_db('nsu');
									$retval = mysql_query( $sql, $conn );
									if(! $retval )
									{
									  die('Could not enter data: ' . mysql_error());
									}
									echo "Entered data successfully\n";
									mysql_close($conn);

									 function page_redirect($location)
									 {
									   echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
									   exit; 
									 }
									page_redirect("http://nsu.berkeley.edu/pages/Rankings.php");
								}
								else
								{
									?>
									<form method="post" action="<?php $_PHP_SELF ?>">
									<table width="400" border="0" cellspacing="1" cellpadding="2">
									<tr>
									<td width="100">From</td>
									<td><input name="emp_name" type="text" id="emp_name"></td>
									</tr>
									<tr>
									<td width="100">To</td>
									<td><input name="emp_address" type="text" id="emp_address"></td>
									</tr>
									<tr>
										<td width="100">Points</td>
										<td><input name="emp_salary" type="text" id="emp_salary"></td>
									</tr>
									<tr>
										<td width="100">Reason</td>
										<td><input name="emp_reason" type="text" id="emp_reason"></td>
									</tr>
									<tr>
									<td width="100"> </td>
									<td> </td>
									</tr>
									<tr>
									<td width="100"> </td>
									<td>
									<input name="add" type="submit" id="add" value="Add Points">
									</td>
									</tr>
									</table>
									</form>
									<?php
								}
							?>

				<?php
					$connection = mysql_connect('mysql', 'nsu', 'EqOBqlgc5TpgEYYRWMem'); //The Blank string is the password
					mysql_select_db('nsu');

					$query = "SELECT * FROM `pointTransactions` ORDER BY TimeStamp DESC"; //You don't need a ; like you do in SQL
					$result = mysql_query($query);

					while($row = mysql_fetch_array($result))  //Creates a loop to loop through results
					{  
						$sender = $row['sender'];
						$receiver = $row['receiver'];
						$points = $row['points'];
						$reason = $row['reason'];
						echo '<p>', $sender, ' gave ', $receiver, ' ', $points, ' points for ', $reason, '</p>';
					}

					mysql_close(); //Make sure to close out the database connection
				?>

							</html>
			</div>
			<div class="col-md-4">
				<h2> Rankings </h2>
				<?php
					$people = array("Kelly",
									"Steven",
									"Kayla", 
									"Amy", 
									"Kaitlin", 
									"Tara",
									"Allen",
									"Dallas",
									"Michael",
									"John",
									"Greg",
									"Alyssa"
									);
					$connection = mysql_connect('mysql', 'nsu', 'EqOBqlgc5TpgEYYRWMem'); //The Blank string is the password
					mysql_select_db('nsu');
					$count = count($people);
					//for($x = 0; $x < $count; $x++) {
						//$cur = $people[$x];
						$escape = mysql_real_escape_string($cur. "'");
					    $query = "SELECT receiver, SUM(points) FROM `pointTransactions` GROUP BY receiver ORDER BY SUM(points) DESC"; 
						$result = mysql_query($query);
						$currentPoints = 0;
						while($row = mysql_fetch_array($result))  //Creates a loop to loop through results
						{  
							$sender = $row['sender'];
							$receiver = $row['receiver'];
							$points = $row['points'];
							$reason = $row['reason'];
							echo '<p>'.$row[0].': '.$row[1].'</p>';
							//echo '<p>', $sender, ' gave ', $receiver, ' ', $points, ' points for ', $reason, '</p>';
							$currentPoints += $points;
						}
					//	echo '<p>'.$cur.': '.$currentPoints.'</p>';
					//}



					mysql_close(); //Make sure to close out the database connection
				?>
			</div>
		</div>
		<?php include 'footer.php' ?>
	</body>
</html>