<?

require_once('Property.class.php');
require_once('PropertyList.class.php');
require_once('PropertyObject.class.php');

/**
 * Tools that manage the border between template scope and application scope.
 */
class Sandbox {
  
  /**
   * Wraps a variable in either a Property (for scalars) or PropertyList object
   * (for arrays/maps).
   * Objects that already are Property/PropertyList instances will not be wrapped.
   */
  public static function wrap($value) {
    if (($value instanceof Property) || 
      ($value instanceof PropertyList) || 
      ($value instanceof PropertyObject)) {
      
      return $value; // don't wrap twice
    }
    if (is_object($value)) {
      return new PropertyObject($value);
    }
    if (is_array($value)) {
      return new PropertyList($value);
    }
    return new Property($value);
  }

  /**
   * Extracts an encapsulated value from a Property/PropertyList object.
   * Objects that are neither are returned verbatim.
   */
  public static function unwrap($value) {
    if (($value instanceof Property) || 
      ($value instanceof PropertyList) ||
      ($value instanceof PropertyObject)) {
      return $value->raw();
    }
    return $value;
  }
}

?>