<?
require_once('../../lib/View.php');

// prepare some properties to display
$model = new Model(); // could also provide a map of properties to constructor

$model->title = 'View.php – A Basic Example';

$model->vars = array(); // map of properties
$model->vars['int'] = 1234567890;
$model->vars['float'] = 1/3;
$model->vars['string'] = "<b>this is bold</b>";
$model->vars['boolean'] = false;
$model->vars['array'] = array(1, 2, 'abc');
$model->vars['null'] = null;

$model->sizes = array(1, 10, 100, 1000, 100000, 1000000); // list
$model->sizes[] = 10000000; // append to list

$model->pleaseCrashMe = true; // we will use this as a flag

// display
$view = new View('../templates');
$view->display('index', $model);
?>