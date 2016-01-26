<?php
/*
 case for size icon
*/ 
switch (get_option('pasw_dimsocial')) {
    case 0:
        $iconsize = '';
        break;
    case 1:
        $iconsize = 'fa-lg';
        break;
    case 2:
        $iconsize = 'fa-2x';
        break;
	case 3:
        $iconsize = 'fa-3x';
        break;
}

/*
 case for align icon
 */ 

switch (get_option('pasw_pisocial')) {
    case 0:
		$alignicon = '';
        break;
    case 1:
		$alignicon = 'center';
        break;
    case 2:
		$alignicon = 'center';
        break;
	case 3:
		$alignicon = 'right';
        break;
}

?>

<p style="text-align: <?php echo $alignicon; ?>">
<?php  
if (get_option('pasw_pagefb') != '') {echo '<a href="'. get_option('pasw_pagefb') .'" title="url esterno pagina facebook"><i style=\'padding-right:2px\' class="fa fa-facebook-square '.$iconsize.'"></i></a>';}else{if (get_option('pasw_hidesocial')) {echo '<i style=\'padding-right:2px; opacity:0.2;\' class="fa fa-facebook-square '.$iconsize.'"></i>';}}
if (get_option('pasw_proftwitter') != '') {echo '<a href="'. get_option('proftwitter') .'" title="url esterno pagina profilo twitter"><i style=\'padding-right:2px\' class="fa fa-twitter-square '.$iconsize.'"></i></a>';}else{if (get_option('pasw_hidesocial')) {echo '<i style=\'padding-right:2px; opacity:0.2;\' class="fa fa-twitter-square '.$iconsize.'"></i>';}}
if (get_option('pasw_profinstagram') != '') {echo '<a href="'. get_option('profinstagram') .'" title="url esterno pagina profilo instagram"><i style=\'padding-right:2px\' class="fa fa-instagram '.$iconsize.'"></i></a>';}else{if (get_option('pasw_hidesocial')) {echo '<i style=\'padding-right:2px; opacity:0.2;\' class="fa fa-instagram '.$iconsize.'"></i>';}}
if (get_option('pasw_canaleyoutube') != '') {echo '<a href="'. get_option('canaleyoutube') .'" title="url esterno pagina canale youtube"><i style=\'padding-right:2px\' class="fa fa-youtube-square '.$iconsize.'"></i></a>';}else{if (get_option('pasw_hidesocial')) {echo '<i style=\'padding-right:2px; opacity:0.2;\' class="fa fa-youtube-square '.$iconsize.'"></i>';}}
if (get_option('pasw_profgoogle') != '') {echo '<a href="'. get_option('profgoogle') .'" title="url esterno pagina profilo google plus"><i style=\'padding-right:2px\' class="fa fa-google-plus-square '.$iconsize.'"></i></a>';}else{if (get_option('pasw_hidesocial')) {echo '<i style=\'padding-right:2px; opacity:0.2;\' class="fa fa-google-plus-square '.$iconsize.'"></i>';}}
if (get_option('pasw_proflinkedin') != '') {echo '<a href="'. get_option('proflinkedin') .'" title="url esterno pagina profilo linkedin"><i style=\'padding-right:2px\' class="fa fa-linkedin-square '.$iconsize.'"></i></a>';}else{if (get_option('pasw_hidesocial')) {echo '<i style=\'padding-right:2px; opacity:0.2;\' class="fa fa-linkedin-square '.$iconsize.'"></i>';}}
?>
</p>
