<?
require_once('../../lib/View.php');

class MyModelClass {
  public function getSomeHtmlString() {
    return '<a href="http://dekstop.de/">dekstop.de</a>';
  }
}

// prepare some properties to display
$ctx = new Context();

# a string
$ctx->title = 'View.php – A Basic Example';

# a map of properties
$ctx->vars = array(); // map of properties
$ctx->vars['null'] = null;
$ctx->vars['int'] = 1234567890;
$ctx->vars['float'] = 1/3;
$ctx->vars['string'] = "My <i>Dearest</i> one, <br>My name is miss Sara";
$ctx->vars['boolean'] = false;
$ctx->vars['list'] = array(1, 10, 100, 1000, 100000, 1000000);
$ctx->vars->list[] = 10000000; // append to list

# a timestamp
$ctx->now = time();

# a flag
$ctx->pleaseCrashMe = true; // we will use this as a flag

# an object
$ctx->my_model = new MyModelClass();

// display
$view = new View('../templates');
$view->display('index', $ctx);
?>