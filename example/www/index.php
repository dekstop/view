<?
require_once('../../lib/View.php');

// prepare some properties to display
$ctx = new Context(); // could also provide a map of properties to constructor

$ctx->title = 'View.php – A Basic Example';

$ctx->vars = array(); // map of properties
$ctx->vars['null'] = null;
$ctx->vars['int'] = 1234567890;
$ctx->vars['float'] = 1/3;
$ctx->vars['string'] = "My <i>Dearest</i> one, <br>My name is miss Sara";
$ctx->vars['boolean'] = false;
$ctx->vars['list'] = array(1, 10, 100, 1000, 100000, 1000000);
$ctx->vars->list[] = 10000000; // append to list

$ctx->pleaseCrashMe = true; // we will use this as a flag

// display
$view = new View('../templates');
$view->display('index', $ctx);
?>