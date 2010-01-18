<?
/**
 * A container for arbitrary collections of properties. Can be accessed using 
 * either array (map) or object syntax. Values will be wrapped in Property or
 * PropertyList objects.
 */
class Context extends PropertyList {
  
  public function Context($d = array()) {
    parent::__construct($d);
  }

}
?>