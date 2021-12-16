    //validate radio
     function validateRadio (radios){
			for (i = 0; i < radios.length; ++ i)
			{
				if (radios [i].checked) return true;
			}
			return false;
      }

	 //validate register form
	 function validate_register_form(){
		 
		 var Title = document.register_form.title.value;
		 var Fname = document.register_form.firstname.value;
		 var Lname = document.register_form.lastname.value;
		 var Tel = document.register_form.tel.value;
		 var Email = document.register_form.email.value;
		 var Pass = document.register_form.password.value;
		 var Cpass = document.register_form.cpass.value; 
		 
		  if(Title=="") {
		   alert("Please select your Title");
		   return false;
		   }
		   
		   
		   if( Fname=="") {
		   alert("Please enter your first name");
		   return false;
		   }
		   
		    if( Lname=="") {
		   alert("Please enter your last name");
		   return false;
		   }
		   
		  
		 if(!validateRadio (document.forms["register_form"]["gender"])){
			 window.alert('Please select your gender');
          return false;}
		  
		    if( Tel=="") {
		   alert("Please enter your phone number");
		   return false;
		   }
		
		  
		    if (Email.indexOf("@", 0) < 0)
			{
				window.alert("Please enter a valid e-mail address.");
				return false;
			}
			
			
			if (Email.indexOf(".", 0) < 0)
			{
				window.alert("Please enter a valid e-mail address.");
				return false;
			}
			
			if((Pass !="") && (Cpass =="")) {
		   alert("Please confirm password");
		   return false;
		   }
		   
		    if(Pass!=Cpass){
		     alert("PASSWORDS DO NOT MATCH");
		   return false; 
		   }
		 
		 return true;
		 }
		 
		                //validate phone number
			            function isNumeric(elem,helperMsg)
						{ 
							var NumPhone = document.getElementById('phone');
							
							if(NumPhone.value !=""){
								
							var numericExpression=/^[0-9]{10}$/;
							if(elem.value.match(numericExpression)){
								return true;
							}
							else
							{
								alert(helperMsg);
								elem.focus();
								return false;
								
								} 
								} 
						} 
						
						//validate change password
						function validate_edit_password(){
							
							var Pass =  document.change_password_form.password.value;
							var Cpass =  document.change_password_form.cpass.value;
							
							if((Pass !="") && (Cpass =="")) {
							   alert("Please confirm password");
							   return false;
							   }
							   
								if(Pass!=Cpass){
								 alert("PASSWORDS DO NOT MATCH");
							   return false; 
							   }
							   
							 alert('Password Updated successfully')
							return true;
							}  