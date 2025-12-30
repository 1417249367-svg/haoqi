<?php

if (ISINSTALL)
	header("Location:account/login.html");
else
	header("Location:include/index.html#public");
?>