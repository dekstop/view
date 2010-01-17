<?

$VIEW_LIB_DIR = dirname(__FILE__) . '/view';
$RENDERER_LIB_DIR = dirname(__FILE__) . '/view/renderers';
set_include_path(get_include_path() . PATH_SEPARATOR . $VIEW_LIB_DIR);
set_include_path(get_include_path() . PATH_SEPARATOR . $RENDERER_LIB_DIR);

// ===================
// = Render dispatch =
// ===================

function _load_render_function($function_name, $filename) {
  if (!function_exists($function_name)) {
    // I couldn't figure out how to catch include failures
    // (e.g. when the file doesn't actually exist) without manually
    // traversing the include path. So for now we suppress the warning
    // and don't specifically handle missing files.
    @include_once($filename); 
  }
  if (!function_exists($function_name)) {
    throw new Exception('Unknown render function: ' . $function_name);
  }
  return $function_name;
}

function get_renderer($name) {
  return _load_render_function($name . '_renderer', $name . '.renderer.php');
}

function get_list_renderer($name) {
  return _load_render_function($name . '_list_renderer', $name . '.list_renderer.php');
}

// =======
// = lib =
// =======

require_once('Property.class.php');
require_once('PropertyList.class.php');
require_once('Model.class.php');
require_once('View.class.php');

?>