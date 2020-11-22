<?php

include 'databaseconnect.php';

global $todays_date,$bookdue_array,$membershipexpiry_array;
$Dstatus="";
$Mstatus="";
$bookdue_array= array();
$membershipexpiry_array = array();

if(isset($_POST['date-update'])){

        $todays_date=$_POST['todays_date'];



 $stmt = "SELECT M.Mem_ssn, M.First_name, M.Phoneno, BC.ISBN, BC.Book_Title, T.Date_due FROM MEMBER AS M, BOOKS_CATALOG AS BC, TRANSACTION_BORROW AS T WHERE T.Mem_ssn = M.Mem_ssn AND T.ISBN_book = BC.ISBN AND T.Borrow_status = 'Borrowed' AND ((M.Category = 'Student' AND DATE_ADD(T.Date_due, INTERVAL 7 DAY) < date('$todays_date')) OR (M.Category IN ('Staff','Professor') AND DATE_ADD(T.Date_due, INTERVAL 14 DAY) < date('$todays_date')))";
        $final = $pdo->prepare($stmt);
        $final->execute();
        $bookdue_array = array();
        while($rowout = $final->fetch())
        {
            $bookdue_array[] = $rowout;
        }
        for($i=0;$i<count($bookdue_array);$i++){
    $to = 'infinitepitechnologies@gmail.com';
    $email = 'infinitepitechnologies@gmail.com';
    $subject = "LOANED LIBRARY BOOKS CROSSING DUE DATE !!";
	$message = "First Name:".$bookdue_array[$i]['First_name']."\n"."ISBN:".$bookdue_array[$i]['ISBN']."\n"."Title:".$bookdue_array[$i]['Book_Title']."\n"."Due Date:".$bookdue_array[$i]['Date_due']."\n"." Please Return the loaned book(s) to the library";
	$headers = "From:".$email;
	mail($to, $subject, $message, $headers);
    }
    $Dstatus="Email Notification Has been Sent !!";

 $stmt = "select Mem_ssn, First_name, Last_name, Date_exp, Phoneno, Haddress from MEMBER where Date_exp <= DATE_ADD(date('$todays_date'), INTERVAL 1 MONTH)";
        $final = $pdo->prepare($stmt);
        $final->execute();
        $membershipexpiry_array = array();
        while($rowout = $final->fetch())
        {
            $membershipexpiry_array[] = $rowout;
        }
        for($i=0;$i<count($membershipexpiry_array);$i++){
    $to = 'infinitepitechnologies@gmail.com';
    $email = 'infinitepitechnologies@gmail.com';
    $subject = "LIBRARY MEMBERSHIP EXPIRY WITHIN 30 DAYS";
	$message = "First Name:".$membershipexpiry_array[$i]['First_name']."\n"."Last Name:".$membershipexpiry_array[$i]['Last_name']."\n"."Expiry Date:".$membershipexpiry_array[$i]['Date_exp']."\n"." Please Renew your Membership";
	$headers = "From:".$email;
	mail($to, $subject, $message, $headers);
    }
    $Mstatus="Email Notification Has been Sent !!";
   }







?>

<!DOCTYPE html>
<html>
<head>
	<title>Nagashekar Ananda Portfolio</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta http-equi="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="css/customize.css">
	<script type="text/javascript" src="js/customize.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Rajdhani|Roboto&display=swap" rel="stylesheet">
	<style>
            table, th, td {
              border: 2px solid black;
              text-align: center;
            }
            td
            {
             height: 40px;
            }
            th
            {
             height: 40px;
             background-color: #999999;
            }

</style>
</head>
<body>
	<!--Header Showcase -->
	<div id="wrapper">
		<div class="header">
						</div>
			<div class="main-block">
				<nav class="main-nav">


				<ul>

						<li><a href="index.php"><img src="images/logo.png" class="logo" alt="logo"></a></li>

						<li><p id="myname">Nagashekar Ananda</p></li>



						<li><a  href="index.php">HOME</a></li>

						<li><a href="libmanage.php">MANAGE LIBRARY</a></li>

						<li><a class="current" href="notificationtrigger.php">NOTIFICATION</a></li>

					</ul>



				</nav>

				<div class="main-block-customize">

				<div class="HTop">
					<h1>NOTIFICATIONS</h1>
				</div>

				<div class="home">
				<div>
				<form method="POST"  enctype="multipart/form-data">
				        <div class="pass-word">
                            <label>Todays date</label>
                            <input type="date" name="todays_date"  required>
                        </div>
                        <button type="submit" name="date-update" value="Submit" class="newbutton"> Enter Date And Send Email Notification </button>
				 </form>
                </div>

				<div class="booksdue">

				 <div id="laaabel">
						<label><h3>MEMBERS WITH BOOKS CROSSING DUE DATE </h3></label>
						 <?php echo $Dstatus ?>
				</div>
				<br>

				    <table style="width: 100%;">
				    <colgroup>
                       <col span="1" style="width: 10%;">
                       <col span="1" style="width: 10%;">
                       <col span="1" style="width: 10%;">
                       <col span="1" style="width: 15%;">
                       <col span="1" style="width: 45%;">
                       <col span="1" style="width: 10%;">
                    </colgroup>
                         <tr>
                            <th>Member SSN</th>
                            <th>First Name</th>
                            <th>Phone No.</th>
                            <th>ISBN</th>
                            <th>Book Title </th>
                            <th>Due Date.</th>
                          </tr>

                    <?php if(count($bookdue_array)>0): ?>
                    <?php for($i=0;$i<count($bookdue_array);$i++): ?>

					<tr>
                            <td><?php echo $bookdue_array[$i]['Mem_ssn'] ?></td>
                            <td><?php echo $bookdue_array[$i]['First_name'] ?></td>
                            <td><?php echo $bookdue_array[$i]['Phoneno'] ?></td>
                            <td><?php echo $bookdue_array[$i]['ISBN'] ?></td>
                            <td><?php echo $bookdue_array[$i]['Book_Title'] ?></td>
                            <td><?php echo $bookdue_array[$i]['Date_due'] ?></td>
                         </tr>
					<?php endfor;?>
					<?php endif; ?>
				    </table>


				</div>

				<br>

                <hr>

				<div class="membershipexpiry">

                <div id="laaabel">
						<label><h3>MEMBERSHIPS WITHIN 30 DAYS OF EXPIRY </h3> </label>
						 <?php echo $Mstatus ?>
				</div>


				<br>

				    <table style="width: 100%;">
				    <colgroup>
                       <col span="1" style="width: 10%;">
                       <col span="1" style="width: 10%;">
                       <col span="1" style="width: 10%;">
                       <col span="1" style="width: 15%;">
                       <col span="1" style="width: 15%;">
                       <col span="1" style="width: 40%;">
                    </colgroup>
                         <tr>
                            <th>Member SSN</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Expiry Date</th>
                            <th>Phone No.</th>
                            <th>Home Address</th>
                          </tr>
                          <?php if(count($membershipexpiry_array)>0): ?>
                    <?php for($i=0;$i<count($membershipexpiry_array);$i++): ?>
                        <tr>
                            <td><?php echo $membershipexpiry_array[$i]['Mem_ssn'] ?></td>
                            <td><?php echo $membershipexpiry_array[$i]['First_name'] ?></td>
                            <td><?php echo $membershipexpiry_array[$i]['Last_name'] ?></td>
                            <td><?php echo $membershipexpiry_array[$i]['Date_exp'] ?></td>
                            <td><?php echo $membershipexpiry_array[$i]['Phoneno'] ?></td>
                            <td><?php echo $membershipexpiry_array[$i]['Haddress'] ?></td>
                         </tr>


					<?php endfor;?>
					<?php endif; ?>
				    </table>

				</div>

			    </div>



				<div class="tothetop">

							<a href="#"><img src="images/arrowG.png" class="arrowhead" alt="arrow"></a>
					</div>


				</div>

	</div>
	<footer>
		<p>Copyright &copy; Registered &reg; Nagashekar Ananda</p>
	</footer>
</div>


</body>
</html>

