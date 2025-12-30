<?php  
require_once("fun.php");
Global $printer;
$printer = new Printer ();
$printer->out_str ( get_lang('phpform_edit_success') );
?>