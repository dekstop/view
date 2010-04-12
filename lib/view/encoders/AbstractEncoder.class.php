<?

/**
 * A type-aware abstract encoder that introspects a scalar's type and forwards
 * to type-specific encoder functions. These can be overridden by subclasses.
 * Note that all such implementations have to return strings, regardless of
 * input type.
 */
abstract class AbstractEncoder implements Encoder {
  
  /**
   * Will forward to appropriate type-specific encoder functions for 
   * null, int, float, bool, string. Will throw an exception if the value 
   * passed is not a scalar.
   */
  public function encode($value) {
    if (is_null($value)) return $this->encodeNull(); // NULL was not a scalar before ca. PHP 4.3.9
    if (!is_scalar($value)) {
      throw new Exception("Value is not a scalar: ${value}");
    }
    if (is_bool($value)) return $this->encodeBool($value);
    if (is_float($value)) return $this->encodeFloat($value);
    if (is_int($value)) return $this->encodeInt($value);
    return $this->encodeString($value);
  }
  
  /**
   * Returns 'null'.
   */
  protected function encodeNull() {
    return 'null';
  }
 
  /**
   * Returns 'true' or 'false'.
   */
  protected function encodeBool($value) {
    if ($value===TRUE) return 'true';
    return 'false';
  }
 
  /**
   * Returns $value verbatim.
   */
  protected function encodeFloat($value) {
    return (string)$value;
  }
 
  /**
   * Returns $value verbatim.
   */
  protected function encodeInt($value) {
    return (string)$value;
  }

  /**
   * Returns $value verbatim.
   */  
  protected function encodeString($value) {
    return $value;
  }
}

?>