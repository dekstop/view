<?

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
    if (($value instanceof Property) || ($value instanceof PropertyList)) {
      return $value; // don't wrap twice
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
    if (($value instanceof Property) || ($value instanceof PropertyList)) {
      return $value->raw();
    }
    return $value;
  }
}

?>