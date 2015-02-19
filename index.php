<?php
include("./Tor.Class.php");

$tor = new tor();

$domain = "torlinkbgs6aabns.onion";
$clone_domain = "ktpufypzla45vzfo.onion";

if($_SERVER["REQUEST_METHOD"] == "GET"){
	echo str_replace($domain, $clone_domain, $tor->get("http://$domain".$_SERVER["REQUEST_URI"]));
}
else
{
	echo "POST is not implemented yet. ";
}
