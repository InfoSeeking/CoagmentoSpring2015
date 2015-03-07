<?php
$homepage = file_get_contents('http://www.msn.com/');
echo "<table width=50%><tr><td>$homepage</td></tr></table>";
?>