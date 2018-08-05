<?php
	
	function newToken()
	{
		return bcrypt(str_random(60));
	}

?>
