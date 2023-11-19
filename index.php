<?phpgh

use DI\ContainerBuilder;

if(!session_id()) { session_start(); }

require "vendor/autoload.php";

$contBuilder = new ContainerBuilder();
$cont = $contBuilder->build();
$connect = $cont->get("CustClasses\models\Router");


