<?php

switch ($page->pagina)
{
case 'best_of_2015':
		require ('pags/bestof2015.php');
break;
case 'best_of_2016':
		require ('pags/bestof2016.php');
break;
case 'best_of_2017':
		require ('pags/bestof2017.php');
break;
case 'radio':
		require ('pags/radio.php');
break;
}
?>