<?php
$receipt = a1_contact_take_receipt();
?>
<!doctype html>
<html>
<head>
	

<link href="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/favicon.ico" rel="shortcut icon" type="image/x-icon">
	<meta name="viewport" content="width=device-width"/>
	<title>THANKS!</title>
	<link href="<?php echo get_template_directory_uri(); ?>/imagenes/iconos/a1security.ico" rel="shortcut icon" type="image/x-icon">
	<meta name="author" content="Diego" />
	<link href="https://fonts.googleapis.com/css?family=Lato:700" rel="stylesheet">
<style type="text/css">
	
	body{
		background-image: url(<?php echo get_template_directory_uri(); ?>/imagenes/fondos/gracias.jpg);
		background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro con 50% de opacidad */
		background-blend-mode: overlay; /* Mezcla el fondo y el color de fondo de manera que la imagen se vea opaca */
		height: 100%; /* Ajusta la altura según tus necesidades */
		background-size: cover; /* Ajusta el tamaño de la imagen de fondo */
		background-repeat: no-repeat; /* Evita que la imagen se repita */
		background-attachment: fixed; /* Opcional: fija la imagen de fondo */
	}
	#boton{
		border: none;
		font-weight: 700;
		text-align: center;
		color: #FFFFFF;
		background: linear-gradient(45deg, #c4990e, #ffef9a);
		outline: none !important;
		border-radius: 37px;
		font-family: 'Lato', sans-serif;
		font-size: 20px;
		width: 20%;
		padding: 0 12px 0 12px;
		margin-top: 10.2% !important;
		margin-left: 40% !important;
		margin-right: 24% !important;
		border: none;
		height: 35px;
	}	
	#boton:hover{
		cursor: pointer;
		transition:.4s;
		-webkit-transition:.4s;
		background-color: black;
	}
	h1{
	    font-family: 'Montserrat', sans-serif;
		color: #ffffff;
		text-align: center;
		margin-top: 5%;
                font-size:30px;
	}
	@media only screen and    (max-width:1200px)  and (min-width:901px){
		h1{margin-top: 5%;}
	}
	@media only screen and    (max-width:900px)  and (min-width:481px){
		body{background-image: url(<?php echo get_template_directory_uri(); ?>/imagenes/fondos/gracias.jpg);height: auto;}
		h1{margin-top: 5%;}
	}
	@media only screen and    (max-width:480px){
		body{background-image: url(<?php echo get_template_directory_uri(); ?>/imagenes/fondos/gracias-movil.jpg);height: auto;}
		h1{margin-top: 300px;font-size: 15px;}
		#boton{width: 40%;margin: 5px 30% 0 30%;font-size:12px;}
	}
</style>
<?php a1_contact_tracking($receipt); ?>
</head>
<body>
<?php if ($receipt): ?>
<h1>THANK YOU FOR CONTACTING US<br>Your request has been submitted. For immediate assistance, call (917) 828-3434.</h1>
<?php else: ?>
<h1>CONTACT A1 SECURITY<br>For assistance, call (917) 828-3434 or use the contact form on our website.</h1>
<?php endif; ?>
<a href="<?php echo get_site_url(); ?>/"><button id="boton">Home</button></a>
</body>
</html>
