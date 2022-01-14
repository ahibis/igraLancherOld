<?
require 'rb.php';
require 'config.php';
R::addDatabase('main',"mysql:host=".$conf['dbIp'].";dbname=".$conf['dbName'], $conf['dbLogin'], $conf['dbPassword'] );
R::addDatabase('offline','mysql:host=127.0.0.1;dbname=igra', 'mysql', 'mysql' );
function start_bd($a){R::selectDatabase($a);}
function select_bd($a){R::close();R::selectDatabase($a);}
start_bd('main');
