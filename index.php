<?php
include("./Tor.Class.php");

$tor = new tor();

$domain = "torlinkbgs6aabns.onion";

if($_SERVER["REQUEST_METHOD"] == "GET"){
	echo str_replace($domain, "ktpufypzla45vzfo.onion", $tor->get("http://$domain".$_SERVER["REQUEST_URI"]));
}
else
{
	echo "POST is not implemented yet. ";
}
