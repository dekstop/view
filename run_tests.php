<?
/**
 * This script will run all unit tests using SimpleTest.
 */

$VIEW_LIB_ROOT = './lib';

require_once('simpletest/autorun.php');
set_include_path(get_include_path() . PATH_SEPARATOR . $VIEW_LIB_ROOT);
require_once('View.php');

class ViewUnitTestCase extends UnitTestCase {
  
  private $e = null;
  
  public function ViewUnitTestCase() {
    $this->e = new HtmlEncoder();
  }
  
  protected function getEncoder() {
    return $this->e;
  }
  
  protected function wrap($value) {
    return Sandbox::wrap($value, $this->e);
  }
}
  
class RendererUnitTestCase extends ViewUnitTestCase {

  /**
    * This can optionally take additional arguments (varargs) and
    * pass them as an array to the render function.
    */
  function render($property_value, $renderer_name) {
    $r = RendererLoader::get_renderer($renderer_name);
    $p = Sandbox::wrap($property_value, $this->getEncoder());
    $a = array_slice(func_get_args(), 2);
    return $r($p, $this->getEncoder(), $a);
  }  
  
  /**
    * This can optionally take additional arguments (varargs) and
    * pass them as an array to the render function.
    */
  function render_list($property_value, $renderer_name) {
    $r = RendererLoader::get_list_renderer($renderer_name);
    $p = Sandbox::wrap($property_value, $this->getEncoder());
    $a = array_slice(func_get_args(), 2);
    return $r($p, $this->getEncoder(), $a);
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
      if (mb_ereg_match('.*\.test\.php', $filename)) {
        $this->addFile($filename);
      }
    }
  }
}

?>