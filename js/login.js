window.onload = function (){
document.getElementById('login-button').addEventListener('click',
	function(){
		document.querySelector('.bg-modal-login').style.display = 'grid';
	});

document.querySelector('.close').addEventListener('click',
	function(){

		document.querySelector('.bg-modal-login').style.display = 'none';


	});

document.querySelector('.Fclose').addEventListener('click',
	function(){

		document.querySelector('.bg-modal-login').style.display = 'none';


	});

document.getElementById('signup-button').addEventListener('click',
	function(){
		document.querySelector('.bg-modal-signup').style.display = 'grid';
	});

document.querySelector('.close-cross').addEventListener('click',
	function(){

		document.querySelector('.bg-modal-signup').style.display = 'none';

	});

document.querySelector('.Fclose-signup').addEventListener('click',
	function(){

		document.querySelector('.bg-modal-signup').style.display = 'none';


	});

}





