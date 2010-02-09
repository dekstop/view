<?

require_once('property/ListProperty.class.php');

/**
 * A container for arbitrary collections of properties. Can be accessed using 
 * either array (map) or object syntax. Values will be wrapped in Property 
 * instances.
 */
class Context extends ListProperty {
  
  public function Context($d = array()) {
    parent::__construct($d);
  }

}
?>