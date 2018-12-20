<?php

require_once ('LettingWeb.class.php');

$lw = new LettingWeb (1621, true);
$lw->getAllSummary();

#echo sizeof ($lw->results);
#print_r($lw->results);

$prop = 'mna7so';

$lw->getPropertyDetail ($prop);

?>

