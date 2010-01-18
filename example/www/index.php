<?
require_once('../../lib/View.php');

// prepare some properties to display
$model = new Model(); // could also provide a map of properties to constructor

$model->title = 'View.php – A Basic Example';

$model->vars = array(); // map of properties
$model->vars['null'] = null;
$model->vars['int'] = 1234567890;
$model->vars['float'] = 1/3;
$model->vars['string'] = "My <i>Dearest</i> one, <br>My name is miss Sara";
$model->vars['boolean'] = false;
$model->vars['list'] = array(1, 10, 100, 1000, 100000, 1000000);
$model->vars->list[] = 10000000; // append to list

$model->pleaseCrashMe = true; // we will use this as a flag

// display
$view = new View('../templates');
$view->display('index', $model);
?>