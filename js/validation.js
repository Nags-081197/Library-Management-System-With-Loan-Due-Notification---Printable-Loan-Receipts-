
function lastnamecheck(){

	var last_name_output=document.getElementById('err_last_name');
	var last_name=document.signupcontent.last_name;
	var regex = /^[A-Za-z]{1,}$/;
	 if(last_name.value.length>0){
	 	last_name_output.innerHTML="";
	 	if(regex.test(last_name.value))
	 	{
	 		last_name_output.innerHTML="";
	 	}

	 	else{
	 		last_name_output.innerHTML="Enter Valid Name - Alphabets only";
	 	}

	 }
	 	else{
	 		last_name_output.innerHTML="This cannot be blank";
	 	}


	 }


function Usernamecheck1(){

	var username_output=document.getElementById('err_username');
	var username=document.signupcontent.username;
	var regex = /^[A-Za-z0-9]{3,}$/;
	 if(username.value.length>0){
	 	username_output.innerHTML="";
	 	if(regex.test(username.value))
	 	{
	 		username_output.innerHTML="";
	 	}

	 	else{
	 		username_output.innerHTML="Enter Valid Username - Min 3 Alphanumeric characters only ";
	 	}

	 }
	 	else{
	 		username_output.innerHTML="This cannot be blank";
	 	}


	 }


	 function emailcheck(){

	var email_output=document.getElementById('err_email');
	var email=document.signupcontent.email;
	var regex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
	 if(email.value.length>0){
	 	email_output.innerHTML="";
	 	if(regex.test(email.value))
	 	{
	 		email_output.innerHTML="";
	 	}

	 	else{
	 		email_output.innerHTML="Enter Valid Email - All lowercase & Alphanumeric - something@something.domain";
	 	}

	 }
	 	else{
	 		email_output.innerHTML="This cannot be blank";
	 	}


	 }

	 function passwordcheck(){

	var password_output=document.getElementById('err_password');
	var password=document.signupcontent.password;
	var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*]).{6,}$/;
	 if(password.value.length>0){
	 	password_output.innerHTML="";
	 	if(regex.test(password.value))
	 	{
	 		password_output.innerHTML="";
	 	}

	 	else{
	 		password_output.innerHTML="Must contain at least one number, one uppercase, lowercase letters, one special character, and at least 6 or more characters";
	 	}

	 }
	 	else{
	 		password_output.innerHTML="This cannot be blank";
	 	}


	 }

	 function repasswordcheck(){

	var repassword_output=document.getElementById('err_re_password');
	var repassword=document.signupcontent.re_password;
	var password=document.signupcontent.password;
	if((repassword.value.length==password.value.length)&&(password.value.length>0)){
	 	repassword_output.innerHTML="Password Macthed";
	 }
	 else
	 {
	 	repassword_output.innerHTML="Password Not Macthed";
	 }
	 	
	}


	function Lusernamecheck(){

	var Lusername_output=document.getElementById('err_Lusername');
	var Lusername=document.logincontent.Lusername;
	var regex = /^[A-Za-z0-9]{3,}$/;
	 if(Lusername.value.length>0){
	 	Lusername_output.innerHTML="";
	 	if(regex.test(Lusername.value))
	 	{
	 		Lusername_output.innerHTML="";
	 	}

	 	else{
	 		Lusername_output.innerHTML="Enter Valid Username - Min 3 Alphanumeric characters only ";
	 	}

	 }
	 	else{
	 		Lusername_output.innerHTML="This cannot be blank";
	 	}


	 }


	 function Lpasswordcheck(){

	var Lpassword_output=document.getElementById('err_Lpassword');
	var Lpassword=document.logincontent.Lpassword;
	var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*]).{6,}$/;
	 if(Lpassword.value.length>0){
	 	Lpassword_output.innerHTML="";
	 	if(regex.test(Lpassword.value))
	 	{
	 		Lpassword_output.innerHTML="";
	 	}

	 	else{
	 		Lpassword_output.innerHTML="Must contain at least one number, one uppercase, lowercase letters, one special character, and at least 6 or more characters";
	 	}

	 }
	 	else{
	 		Lpassword_output.innerHTML="This cannot be blank";
	 	}


	 }

	 function firstnamecheck(){

	var first_name_output=document.getElementById('err_first_name');
	var first_name=document.signupcontent.first_name;
	var regex = /^[A-Za-z]{1,}$/;
	 if(first_name.value.length>0){
	 	first_name_output.innerHTML="";
	 	if(regex.test(first_name.value))
	 	{
	 		first_name_output.innerHTML="";
	 	}

	 	else{
	 		first_name_output.innerHTML="Enter Valid Name - Alphabets only";
	 	}
	 }
	 	else{
	 		first_name_output.innerHTML="This cannot be blank";
	 	}


	 }


	 function cfirstnamecheck(){

	var cfirst_name_output=document.getElementById('err_cfirst_name');
	var cfirst_name=document.hitmeupcontent.your_name;
	var regex = /^[A-Za-z]{1,}$/;
	 if(cfirst_name.value.length>0){
	 	cfirst_name_output.innerHTML="";
	 	if(regex.test(cfirst_name.value))
	 	{
	 		cfirst_name_output.innerHTML="";
	 	}

	 	else{
	 		cfirst_name_output.innerHTML="Enter Valid Name - Alphabets only";
	 	}
	 }
	 	else{
	 		cfirst_name_output.innerHTML="This cannot be blank";
	 	}


	 }



	 function cemailcheck(){

	var cemail_output=document.getElementById('err_cemail');
	var cemail=document.hitmeupcontent.cemail;
	var regex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
	 if(cemail.value.length>0){
	 	cemail_output.innerHTML="";
	 	if(regex.test(cemail.value))
	 	{
	 		cemail_output.innerHTML="";
	 	}

	 	else{
	 		cemail_output.innerHTML="Enter Valid Email - All lowercase & Alphanumeric - something@something.domain";
	 	}

	 }
	 	else{
	 		cemail_output.innerHTML="This cannot be blank";
	 	}


	 }


	 function phonenumbercheck(){

	var phone_output=document.getElementById('err_phone');
	var phone=document.hitmeupcontent.phone_no;
	var regex = /^[0-9]{10}$/;
	 if(phone.value.length>0){
	 	phone_output.innerHTML="";
	 	if(regex.test(phone.value))
	 	{
	 		phone_output.innerHTML="";
	 	}

	 	else{
	 		phone_output.innerHTML="Enter Valid Phone number - Numbers only - 10 digits";
	 	}

	 }
	 	else{
	 		phone_output.innerHTML="This cannot be blank";
	 	}


	 }