<?

require_once('property/ScalarProperty.class.php');
require_once('property/ListProperty.class.php');
require_once('property/ObjectProperty.class.php');

/**
 * Tools that manage the transition between template scope and application scope.
 */
class Sandbox {
  
  /**
   * Wraps a variable in a Property instance: ScalarProperty, ListProperty, or 
   * ObjectProperty.
   * Variables that already are Property instances will not be wrapped.
   */
  public static function wrap($value) {
    if ($value instanceof Property) {
      return $value; // don't wrap twice
    }
    if (is_array($value)) {
      return new ListProperty($value);
    }
    if (is_object($value)) {
      return new ObjectProperty($value);
    }
    return new ScalarProperty($value);
  }

  /**
   * Extracts an encapsulated value from a Property instance.
   * Objects that are not a Property instance are returned verbatim.
   */
  public static function unwrap($value) {
    if ($value instanceof Property) {
      return $value->raw();
    }
    return $value;
  }
}

?>