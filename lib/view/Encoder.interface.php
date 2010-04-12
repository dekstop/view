<?

/**
 * Classes for output encoding of printable PHP scalars (strings and other 
 * types), e.g. to escape HTML entities.
 * 
 * Implementations may want to inspect the type of a value to generate 
 * appropriate output, and e.g. return "true" for a boolean TRUE value.
 */
interface Encoder {
  
  /**
   * $value is a PHP scalar, *not* a Property instance or PHP array.
   */
  public function encode($value);
  
}

?>