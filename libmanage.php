<?php 



include 'databaseconnect.php';	


$Mstatus = "";

//member table - update

if(isset($_POST['member-update'])){

$ssn = $_POST['ssn'];
	  $first_name = $_POST['first_name'];
	  $last_name = $_POST['last_name'];
	  $middle_name = $_POST['middle_name'];
	  $phone_number = $_POST['phone_number'];
	  $address = $_POST['address'];
	  $category = $_POST['category'];
	  $tdate = $_POST['todays_date'];
	  $expdate = $_POST['exp_date'];

	  if(empty($first_name)  || empty($last_name) ) {
	    $Mstatus = "All fields are compulsory.";
	  }
	  else
	    {
	      $chck = "SELECT * from MEMBER WHERE Mem_ssn='$ssn'";
	      $result = $pdo->query($chck);
	      if($result->rowCount()>0){
	      	$Mstatus = "Member already exists";
	      }
            else{
             $sql = "INSERT INTO MEMBER (Mem_ssn, First_name, Mid_name, Last_name, Phoneno, Haddress, Category, Date_issue, Date_exp) VALUES (:Mem_ssn, :First_name, :Mid_name, :Last_name, :Phoneno, :Haddress, :Category, :Date_issue, :Date_exp)";
	      $stmt = $pdo->prepare($sql);

	      $stmt->execute(['First_name'=>$first_name,'Mid_name'=>$middle_name, 'Last_name'=>$last_name,'Mem_ssn'=>$ssn,'Phoneno'=>$phone_number,'Haddress'=>$address,'Category'=>$category,'Date_issue'=>$tdate,'Date_exp'=>$expdate ]);

	      $Mstatus = "Member Added Successfully !!";



	  $ssn = "";
	  $first_name = "";
	  $middle_name = "";
	  $phone_number = "";
	  $address = "";
	  $category = "";
	  $tdate = "";
	  $expdate = "";
            }





	     }

}




$ABstatus = "";

//add book

if(isset($_POST['addbook-update'])){

	$isbn = $_POST['isbn'];
	  $title = $_POST['title'];
	  $author = $_POST['author'];
	  $genre = $_POST['genre'];
	  $desc = $_POST['desc'];
	  $classification = $_POST['classification'];
	  $quantity = $_POST['quantity'];
	  $publisher = $_POST['publisher'];


	  if(empty($isbn)  || empty($title) ) {
	    $ABstatus = "All fields are compulsory.";
	  }
	  else
	    {
	      $chck = "SELECT * from BOOKS_CATALOG WHERE ISBN='$isbn'";
	      $result = $pdo->query($chck);
	      if($result->rowCount()>0){
	      	$ABstatus = "Book already exists";
	      }
            else{
             $sql = "INSERT INTO BOOKS_CATALOG (ISBN, Book_Title, Author, Genre, Book_desc, Classification, Quantity, Publisher) VALUES (:ISBN, :Book_Title, :Author, :Genre, :Book_desc, :Classification, :Quantity, :Publisher)";
	      $stmt = $pdo->prepare($sql);

	      $result = $stmt->execute(['ISBN'=>$isbn,'Book_Title'=>$title, 'Author'=>$author,'Genre'=>$genre,'Book_desc'=>$desc,'Classification'=>$classification,'Quantity'=>$quantity,'Publisher'=>$publisher]);

	      if($result>0){

				$ABstatus = "Successfully ADDED";

			}

			else{

				$ABstate = "Error while Updating";
			}



	  $isbn = "";
	  $title ="";
	  $author = "";
	  $genre = "";
	  $desc = "";
	  $classification = "";
	  $quantity = "";
	  $publisher = "";
            }





	     }

}


$BBstatus = "";
// Transaction_borrow table

if(isset($_POST['bookborrow-update'])){

            $isbn = $_POST['isbn'];
	        $mem_ssn = $_POST['mem_ssn'];
	        $givestaff_ssn = $_POST['givestaff_ssn'];
	        $todays_date = $_POST['todays_date'];
	        $due_date = "";

	        $stmt = "SELECT * from BOOKS_CATALOG WHERE ISBN='$isbn'";
        $final = $pdo->prepare($stmt);
        $final->execute();
        $required_array = array();
        while($rowout = $final->fetch())
        {
            $required_array[] = $rowout;
        }
        if(!empty($required_array)){
            if(strtolower($required_array[0]['Classification'])=='rare' || strtolower($required_array[0]['Classification']=='required')){
                $BBstatus = "Not allowed to borrow!!";
            }
            else{

                $sql ="SELECT * FROM TRANSACTION_BORROW WHERE Mem_ssn='$mem_ssn' AND Borrow_status='Borrowed' AND ISBN_book='$isbn'";
			    $result = $pdo->query($sql);
	            if($result->rowCount()>0){
	      	        $BBstatus = "Book already loaned !!";
	                }
               else{

                $sql ="SELECT count(*) FROM TRANSACTION_BORROW WHERE Mem_ssn='$mem_ssn' AND Borrow_status='Borrowed'";


			    $stmt = $pdo->prepare($sql);
			    $stmt->execute();
                $borrower_count = $stmt->fetchColumn();

                if(((int)($borrower_count))>5){
			        $BBstatus = "Can loan only 5 books maximum!!";
			    }
			    else{

                    $sql ="SELECT count(*) FROM TRANSACTION_BORROW WHERE ISBN_book='$isbn' AND Borrow_status='Borrowed'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $borrowing_count = $stmt->fetchColumn();

                    if(((int)($borrowing_count))<((int)($required_array[0]['Quantity']))){
                        $sql ="SELECT Category FROM MEMBER WHERE Mem_ssn='$mem_ssn'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $category = $stmt->fetchColumn();


                        if((strtolower($category))=='student'){

                              $date= new DateTime($todays_date);
                            $final_date = date_add($date,date_interval_create_from_date_string("21 days"));
                            $due_date= (string)($final_date->format('Y-m-d H:i:s'));

                        }
                        else{
                             $date= new DateTime($todays_date);
                            $final_date = date_add($date,date_interval_create_from_date_string("90 days"));
                            $due_date=(string)($final_date->format('Y-m-d H:i:s'));
                        }

                        $sql = "INSERT INTO TRANSACTION_BORROW (ISBN_book,Mem_ssn,Giveaway_staff,Issue_date,Date_due,Borrow_status) VALUES (:ISBN_book,:Mem_ssn,:Giveaway_staff,:Issue_date,:Date_due,:Borrow_status)";
                          $stmt = $pdo->prepare($sql);

                          $result = $stmt->execute(['ISBN_book'=>$isbn,'Mem_ssn'=>$mem_ssn, 'Giveaway_staff'=>$givestaff_ssn,'Issue_date'=>$todays_date,'Date_due'=>$due_date,'Borrow_status'=>'Borrowed']);

                          if($result>0){

                                $BBstatus = "'$mem_ssn' : Successfully Borrowed Books ISBN : '$isbn' !!";

                               $sql = "SELECT * FROM TRANSACTION_BORROW WHERE Mem_ssn='$mem_ssn' AND ISBN_book='$isbn'";
                               $stmt = $pdo->query($sql);
                               $trans_borrow_array = $stmt->fetch();

                               $sql = "SELECT * FROM MEMBER WHERE Mem_ssn='$mem_ssn'";
                               $stmt = $pdo->query($sql);
                               $mem_array = $stmt->fetch();


                               $sql = "SELECT * FROM BOOKS_CATALOG WHERE ISBN='$isbn' ";
                               $stmt = $pdo->query($sql);
                               $books_array = $stmt->fetch();

                                echo "<script type='text/javascript'>
                                    function printDiv() {
                                    var a = window.open('', '', 'height=500, width=500');
                                    a.document.write('<html>');
                                    a.document.write('<body > <h1>BOOK LOAN ACKNOWLEDGEMENT</h1><br>');
                                    a.document.write('<label>First Name : ".$mem_array['First_name']."</label><br>');
                                    a.document.write('<label>Last Name : ".$mem_array['Last_name']."</label><br>');
                                    a.document.write('<label>Acknowledgement No. : ".$trans_borrow_array['Trans_ID']."</label><br>');
                                    a.document.write('<label>Book ISBN. : ".$books_array['ISBN']."</label><br>');
                                    a.document.write('<label>Book Title. : ".$books_array['Book_Title']."</label><br>');
                                    a.document.write('<label>Book Author. : ".$books_array['Author']."</label><br>');
                                    a.document.write('<label>Issue date : ".$trans_borrow_array['Issue_date']."</label><br>');
                                    a.document.write('<label>Due date : ".$trans_borrow_array['Date_due']."</label><br>');
                                    a.document.write('</body></html>');
                                    a.document.close();
                                    a.print();
                                    }
                                    this.printDiv();

                            </script> ";

                            }

                            else{

                                $BBstate = "Error while Updating";
                            }



                          $isbn = "";
                          $mem_ssn ="";
                          $givestaff_ssn = "";
                          $todays_date = "";



                    }
                    else{
                    $BBstatus = "Book unavailable or already rented by the user";

                    }




			    }


                }

            }


        }
        else{
            $BBstatus = "No such book in the library !!";
        }

}

$BRstatus = "";
// Transaction_borrow table

if(isset($_POST['bookreturn-update'])){

            $isbn = $_POST['isbn'];
	        $mem_ssn = $_POST['mem_ssn'];
	        $returnstaff_ssn = $_POST['returnstaff_ssn'];
	        $todays_date = $_POST['todays_date'];
	        $trans_remarks = $_POST['trans_remarks'];

            $chck = "SELECT * FROM TRANSACTION_BORROW WHERE ISBN_book ='$isbn' AND Mem_ssn='$mem_ssn' AND Borrow_status='Borrowed' ORDER BY Date_due";
              $result = $pdo->query($chck);
              if($result->rowCount()>0){
                   $rowout=$result->fetch();
                   $sql = "UPDATE TRANSACTION_BORROW SET Date_return=:Date_return, Borrow_status=:Borrow_status, Receive_staff =:Receive_staff, Trans_remarks =:Trans_remarks WHERE Trans_ID=:Trans_ID ";
                   $stmt = $pdo->prepare($sql);
			       $result = $stmt->execute(['Date_return' => $todays_date,'Borrow_status' => 'Returned','Receive_staff' => $returnstaff_ssn,'Trans_remarks' =>$trans_remarks,'Trans_ID' => $rowout['Trans_ID']]);

                   if($result>0){

                                $BRstatus = "'$mem_ssn' : Successfully Returned Book ISBN : '$isbn' !!";

                            }

                            else{

                                $BRstate = "Error while Updating";
                            }

                   $sql = "SELECT Trans_ID,Issue_date,Date_due,Date_return, Trans_remarks, Receive_staff FROM TRANSACTION_BORROW WHERE ISBN_book='$isbn' AND Mem_ssn='$mem_ssn' AND Borrow_status='Returned'";
                   $final = $pdo->prepare($sql);
                    $final->execute();
                    $trans_borrow_array = $final->fetch();

			       $sql = "SELECT * FROM MEMBER WHERE Mem_ssn='$mem_ssn'";
                   $stmt = $pdo->query($sql);
			       $mem_array = $stmt->fetch();


			       $sql = "SELECT * FROM BOOKS_CATALOG WHERE ISBN='$isbn' ";
                   $stmt = $pdo->query($sql);
			       $books_array = $stmt->fetch();

			        echo "<script type='text/javascript'>
			            function printDiv() {
                        var a = window.open('', '', 'height=500, width=500');
                        a.document.write('<html>');
                        a.document.write('<body > <h1>BOOK RETURN ACKNOWLEDGEMENT</h1><br>');
                        a.document.write('<label>First Name : ".$mem_array['First_name']."</label><br>');
                        a.document.write('<label>Last Name : ".$mem_array['Last_name']."</label><br>');
                        a.document.write('<label>Acknowledgement No. : ".$trans_borrow_array['Trans_ID']."</label><br>');
                        a.document.write('<label>Book ISBN. : ".$books_array['ISBN']."</label><br>');
                        a.document.write('<label>Book Title. : ".$books_array['Book_Title']."</label><br>');
                        a.document.write('<label>Book Author. : ".$books_array['Author']."</label><br>');
                        a.document.write('<label>Issue date : ".$trans_borrow_array['Issue_date']."</label><br>');
                        a.document.write('<label>Due date : ".$trans_borrow_array['Date_due']."</label><br>');
                        a.document.write('<label>Return date : ".$trans_borrow_array['Date_return']."</label><br>');
                        a.document.write('</body></html>');
                        a.document.close();
                        a.print();
                        }
                        this.printDiv();

                </script> ";



              }
              else{
                    $BRstatus = "No Book Borrowed !!";
              }




}

$MRstatus = "";
// Transaction_borrow table

if(isset($_POST['memrenewal-update'])){

	        $mem_ssn = $_POST['mem_ssn'];
	        $renewed_date = $_POST['renewed_date'];


            $chck = "SELECT * FROM MEMBER WHERE Mem_ssn='$mem_ssn'";
              $result = $pdo->query($chck);
              if($result->rowCount()>0){
                   $rowout=$result->fetch();
                   $sql = "UPDATE MEMBER SET Date_exp=:Date_exp WHERE Mem_ssn=:mem_ssn ";
                   $stmt = $pdo->prepare($sql);
			       $result = $stmt->execute(['Date_exp' => $renewed_date,'mem_ssn' => $mem_ssn]);
			       if($result>0){

                                $MRstatus = "'$mem_ssn' : Membership Successfully Renewed - New Epiry Date : '$renewed_date' !!";

                            }

                            else{

                                $MRstate = "Error while Updating";
                            }
              }
              else{
                    $MRstatus = "Member Does not Exist !!";
              }




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

						<li><a class="current" href="libmanage.php">MANAGE LIBRARY</a></li>

						<li><a href="notificationtrigger.php">NOTIFICATION</a></li>

					</ul>
				
							

				</nav>
				
				<div class="main-block-customize">
				
				<div class="HTop">
					<h1>LIBRARY MANAGEMENT</h1>
				</div>

				<div class="home">

			        <div id="laaabel">
						<button onclick="myFunctionI()">
								Register Member
						</button>

					</div>


					<form method="POST" id="formid_home" class="hide" enctype="multipart/form-data">

        			    <?php echo $Mstatus ?>

      				    <div class="pass-word">
                            <label>SSN</label>
                            <input type="text" name="ssn" pattern="[0-9]{9}" title="Enter Valid SSN - Numbers only" required>
                        </div>

					    <div class="user-name">
                            <label>First Name</label>
                            <input type="text" name="first_name"  pattern="[A-Za-z]{1,}" title="Enter Valid Name - Alphabets only" required>
                        </div>

                        <div class="pass-word">
                            <label>Middle Name</label>
                            <input type="text" name="middle_name" pattern="[A-Za-z]{1,}" title="Enter Valid Name - Alphabets only" required>
                        </div>

                        <div class="pass-word">
                            <label>Last Name</label>
                            <input type="text" name="last_name" pattern="[A-Za-z]{1,}" title="Enter Valid Name - Alphabets only" required>
                        </div>

                        <div class="pass-word">
                            <label>Phone Number</label>
                            <input type="text" name="phone_number" pattern="[0-9]{10}" title="Enter Valid phone number - 10 digits only" required>
                        </div>

                        <div class="pass-word">
                            <label>Address</label>
                            <input type="text" name="address" pattern="[A-Za-z0-9_ ]{1,}" title="Enter Valid Address" required>
                        </div>

                        <div class="pass-word">
                            <label>Category</label>
                            <input type="text" name="category" pattern="[A-Za-z]{1,}" title="Enter Valid Category - Alphabets only" required>
                        </div>

                        <div class="pass-word">
                            <label>Registration Date - Todays date</label>
                            <input type="date" name="todays_date"  required>
                        </div>

                         <div class="pass-word">
                            <label> Expiry Date - 4 years from today</label>
                            <input type="date" name="exp_date"  required>
                        </div>
                        <button type="submit" name="member-update" value="Submit" class="getin">Register</button>

					

					</form>

			</div>

		

					<div class="aboutme">
						
					<div id="laaabel">	
						<button onclick="myFunctionA()">
								Add Book
						</button>

					</div>


					<form method="POST" id="formid_aboutme" class="hide" enctype="multipart/form-data">
        			
        			<?php echo $ABstatus ?>
      				
					<div class="user-name">
                            <label>ISBN</label>
                            <input type="text" name="isbn"  pattern="(?=.*\d)(?=.*[-]).{7,}" title="Enter Valid ISBN " required>
                        </div>

                        <div class="pass-word">
                            <label>Title</label>
                            <input type="text" name="title" pattern="[0-9A-Za-z_ ]{1,}" title="Enter Valid Title" required>
                        </div>

                        <div class="pass-word">
                            <label>Author</label>
                            <input type="text" name="author" pattern="[0-9A-Za-z]{1,}" title="Enter Valid Name" required>
                        </div>

                        <div class="user-name">
                            <label>Genre</label>
                            <input type="text" name="genre"  pattern="[0-9A-Za-z_ ]{1,}" title="Enter Valid genre " required>
                        </div>

                        <div class="pass-word">
                            <label>Description</label>
                            <textarea name="desc" pattern="[0-9A-Za-z_ ]{1,}" title="Enter Valid Description" required></textarea>
                        </div>

                        <div class="pass-word">
                            <label>Classification</label>
                            <input type="text" name="classification" pattern="[0-9A-Za-z_ ]{1,}" title="Enter Valid Classification" required>
                        </div>

                        <div class="pass-word">
                            <label>Quantity</label>
                            <input type="text" name="quantity" pattern="[0-9]{1,}" title="Enter Valid quantity" required>
                        </div>

                        <div class="pass-word">
                            <label>Publisher</label>
                            <input type="text" name="publisher" pattern="[0-9A-Za-z_ ]{1,}"  title="Enter Valid Publisher name" required>
                        </div>



					<button type="submit" value="Submit" name="addbook-update" class="getin">Add Book</button>

					

					</form>

					</div>


					<div class="skills">

					<div id="laaabel">	
						<button onclick="myFunctionS()">
								Book Borrow
						</button>

					</div>

					<form method="POST" id="formid_skills" class="hide" enctype="multipart/form-data">

        			<?php echo $BBstatus ?>

					<div class="user-name">
                            <label>ISBN</label>
                            <input type="text" name="isbn"  pattern="(?=.*\d)(?=.*[-]).{7,}" title="Enter Valid ISBN " required>
                        </div>

                        <div class="pass-word">
                            <label>Member SSN</label>
                            <input type="text" name="mem_ssn" pattern="[0-9]{9}" title="Enter Valid SSN" required>
                        </div>

                        <div class="pass-word">
                            <label>Checkout Staff SSN</label>
                            <input type="text" name="givestaff_ssn" pattern="[0-9]{9}" title="Enter Valid SSN" required>
                        </div>

                        <div class="user-name">
                            <label>Todays Date</label>
                            <input type="date" name="todays_date" required>
                        </div>


					<button type="submit" value="Submit" name="bookborrow-update" class="getin">Borrow Book</button>



					</form>

					</div>

						

					
					<div class="portfolio">
						
					<div id="laaabel">	
						<button onclick="myFunctionP()">
								Book Return
						</button>

					</div>

					<form method="POST" id="formid_portfolio" class="hide" enctype="multipart/form-data">

        			<?php echo $BRstatus ?>

					<div class="user-name">
                            <label>ISBN</label>
                            <input type="text" name="isbn"  pattern="(?=.*\d)(?=.*[-]).{7,}" title="Enter Valid ISBN " required>
                        </div>

                        <div class="pass-word">
                            <label>Member SSN</label>
                            <input type="text" name="mem_ssn" pattern="[0-9]{9}" title="Enter Valid SSN" required>
                        </div>

                        <div class="pass-word">
                            <label>Checkin Staff SSN</label>
                            <input type="text" name="returnstaff_ssn" pattern="[0-9]{9}" title="Enter Valid SSN" required>
                        </div>

                        <div class="pass-word">
                            <label>Comments - IF ANY orelse enter NA</label>
                            <textarea name="trans_remarks" pattern="[0-9A-Za-z_ ]{1,}" title="Enter Valid Comments" required></textarea>
                        </div>

                        <div class="user-name">
                            <label>Todays Date</label>
                            <input type="date" name="todays_date" required>
                        </div>


					<button type="submit" value="Submit" name="bookreturn-update" class="getin">Return Book</button>



					</form>

					</div>
	

					


					<div class="experience">

						<div id="laaabel">	
						<button onclick="myFunctionE()">
								Membership Renewal
						</button>

					</div>

					<div id="formid_experience" class="hide">

					<form method="POST"  enctype="multipart/form-data" >
        			
        			<?php echo $MRstatus ?>

        			 <div class="pass-word">
                            <label>Member SSN</label>
                            <input type="text" name="mem_ssn" pattern="[0-9]{9}" title="Enter Valid SSN" required>
                      </div>

                      <div class="user-name">
                            <label> Renew Date - 4 years from today</label>
                            <input type="date" name="renewed_date" required>
                        </div>



					<button type="submit" value="Submit" name="memrenewal-update" class="getin">Membership Renewal</button>


					</form>



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

<script>
 var userdel=(<?php echo count($signup_array) ?>);
</script>




</body> 
</html>

