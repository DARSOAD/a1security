<!doctype html>
<html lang="es" class="js csstransitions">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
	<!-- Bootstrap CSS -->
  
    <title>Home</title>
    <!-------------------FUENTES---------------->
    <?php get_template_part('fuentes'); ?>
    <link href="<?php echo get_template_directory_uri(); ?>/fuentes/fuentes.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/css/letra.css" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri(); ?>/css/main.css" rel="stylesheet">
    <!-------------------FUENTES---------------->
	<!-------------------logo---------------->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/logo.css" async>
	<!-------------------logo---------------->
	
	<style type="text/css">
        /*----------------------PORTADA------------------------------*/
			@media only screen and  (min-width:992px){body{background-image: url("<?php echo get_template_directory_uri(); ?>/imagenes/fondos/bloque1.jpg");}}
			@media only screen and (max-width:991px) and  (min-width:768px){body{background-image: url("<?php echo get_template_directory_uri(); ?>/imagenes/fondos/bloque1.jpg");}}
			@media only screen and (max-width:767px) {body{background-image: url("<?php echo get_template_directory_uri(); ?>/imagenes/fondos/bloque1.jpg");}}
		/*----------------------PORTADA------------------------------*/
		/*----------------------ON/OFF ------------------------------*/		
			@media only screen and  (min-width:992px){.tablet, .celular{display:none;}.pc{display: block;}}
			@media only screen and (max-width:991px) and  (min-width:768px){.pc, .celular{display:none;}.tablet{display: block;}}
			@media only screen and (max-width:767px) {.pc, .tablet{display:none;}.celular{display: block;}}
			.off{display:none !important;}
		/*----------------------ON/OFF------------------------------*/
		/*----------------------POSICIÓN------------------------------*/
			@media only screen and  (min-width:992px){
			.pc-izquierda-grande{margin-left: 5% !important;width: 50% !important;}.pc-izquierda-mediano{margin-left: 5% !important;width: 40% !important;}.pc-centrado-extraGrande{margin-left: 8% !important;width: 84% !important;}.pc-centrado-superGrande{margin-left: 15% !important;width: 70% !important;}.pc-centrado-grande{margin-left: 25% !important;width: 50% !important;}.pc-centrado-mediano{margin-left: 30% !important;width: 40% !important;}.pc-derecha-grande{margin-left: 45% !important;width: 50% !important;}.pc-derecha-mediano{margin-left: 55% !important;width: 40% !important;}.pc-centrado-mediano2{margin-left: 20% !important;width: 60% !important;}}
			
			@media only screen and  (max-width:991px) and  (min-width:768px){
			.tb-izquierda-grande{margin-left: 5% !important;width: 50% !important;}.tb-izquierda-mediano{margin-left: 5% !important;width: 40% !important;}.tb-centrado-superGrande{margin-left: 10% !important;width: 80% !important;}.tb-centrado-grande{margin-left: 20% !important;width: 60% !important;}.tb-centrado-mediano{margin-left: 30% !important;width: 40% !important;}.tb-derecha-grande{margin-left: 45% !important;width: 50% !important;}.tb-derecha-mediano{margin-left: 55% !important;width: 40% !important;}}
			@media only screen and  (max-width:767px){
			.mv-izquierda-grande{margin-left: 5% !important;width: 50% !important;}.mv-izquierda-mediano{margin-left: 5% !important;width: 40% !important;}.mv-centrado-superGrande{margin-left: 10% !important;width: 80% !important;}.mv-centrado-grande{margin-left: 20% !important;width: 60% !important;}.mv-centrado-mediano{margin-left: 30% !important;width: 40% !important;}.mv-derecha-grande{margin-left: 45% !important;width: 50% !important;}.mv-derecha-mediano{margin-left: 55% !important;width: 40% !important;}.mv-centrado-super-grande{margin-left: 5% !important;width: 90% !important;}.mv-centrado-grande2 {margin-left: 10% !important;width: 80% !important;}
			}
		/*----------------------POSICIÓN------------------------------*/
		</style>