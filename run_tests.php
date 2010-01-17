<?

$VIEW_LIB_ROOT = './lib';

require_once('simpletest/autorun.php');
set_include_path(get_include_path() . PATH_SEPARATOR . $VIEW_LIB_ROOT);
require_once('View.php');

class RendererUnitTestCase extends UnitTestCase {
  /**
    * This can optionally take additional arguments (varargs) and
    * pass them as an array to the render function.
    */
  function render($property_value, $renderer_name) {
    $r = RendererLoader::get_renderer($renderer_name);
    $p = Sandbox::wrap($property_value);
    $args = array();
    if (count(func_get_args())>2) {
      // we have varargs
      $args = func_get_args();
      $args = array_slice($args, 2);
    }
    return $r($p, $args);
  }  
  
  /**
    * This can optionally take additional arguments (varargs) and
    * pass them as an array to the render function.
    */
  function render_list($property_value, $renderer_name) {
    $r = RendererLoader::get_list_renderer($renderer_name);
    $p = Sandbox::wrap($property_value);
    $args = array();
    if (count(func_get_args())>2) {
      // we have varargs
      $args = func_get_args();
      $args = array_slice($args, 2);
    }
    return $r($p, $args);
  }
}

class UnitTests extends TestSuite {
  function UnitTests() {
    global $VIEW_LIB_ROOT;
    
    $this->TestSuite('Unit tests');
    
    // Add all files matching a *.test.php filename
    // (PHP directory walking is generally horrible.)
    $it = new RecursiveDirectoryIterator($VIEW_LIB_ROOT);
    foreach (new RecursiveIteratorIterator($it) as $filename=>$cur) {
      if (preg_match('/.*\.test\.php/', $filename)) {
        $this->addFile($filename);
      }
    }
  }
}

?>