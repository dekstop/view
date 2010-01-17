<?

$VIEW_LIB_DIR = dirname(__FILE__) . '/view';
$RENDERER_LIB_DIR = dirname(__FILE__) . '/view/renderers';
set_include_path(get_include_path() . PATH_SEPARATOR . $VIEW_LIB_DIR);
set_include_path(get_include_path() . PATH_SEPARATOR . $RENDERER_LIB_DIR);

require_once('Property.class.php');
require_once('PropertyList.class.php');
require_once('Model.class.php');
require_once('View.class.php');
require_once('RendererLoader.class.php');
require_once('Sandbox.class.php');

?>