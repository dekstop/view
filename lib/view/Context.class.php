<?

require_once('sandbox/ListProperty.class.php');

/**
 * A container for arbitrary collections of properties. Can be accessed using 
 * either array (map) or object syntax. Values will be wrapped in Property 
 * instances.
 */
class Context extends ListProperty {
  
  /**
   * Parameters:
   * * $d (optional): a set of properties
   * * $encoder (optional): an Encoder instance. Defaults to HtmlEncoder.
   */
  public function Context($d = array(), $encoder=null) {
    parent::__construct($d, is_null($encoder) ? new HtmlEncoder() : $encoder);
  }

}
?>