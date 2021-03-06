<?

ini_set('mbstring.internal_encoding', 'UTF-8'); // Sorry for this, but anything else is madness.

$VIEW_LIB_DIR = dirname(__FILE__) . '/view';
$RENDERER_LIB_DIR = dirname(__FILE__) . '/view/renderers';
set_include_path(get_include_path() . PATH_SEPARATOR . $VIEW_LIB_DIR);
set_include_path(get_include_path() . PATH_SEPARATOR . $RENDERER_LIB_DIR);

require_once('Context.class.php');
require_once('View.class.php');
require_once('RendererLoader.class.php');
require_once('Sandbox.class.php');
require_once('ViewHelper.class.php');

require_once('Encoder.interface.php');
require_once('encoders/HtmlEncoder.class.php');
require_once('encoders/JsonEncoder.class.php');
require_once('encoders/XmlEncoder.class.php');

require_once('Generator.class.php');
require_once('generators/FragmentGenerator.class.php');

?>