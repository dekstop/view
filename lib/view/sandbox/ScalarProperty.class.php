<?

require_once('Property.interface.php');

/**
 * A container for a single scalar, responsible for making its value
 * available for display. The default renderer just calls 
 * $encoder->encode($value)
 *
 * Custom renderers, once registered, can simply be called by their name: 
 * $my_property->my_renderer();
 *
 * Additionally this class offers basic checks for use in display logic 
 * control structures.
 *
 * This class should never be instantiated directly.
 */
class ScalarProperty implements Property {
  
  private $value = null;
  private $encoder = null;
  
  public function ScalarProperty($value, $encoder) { 
    $this->value = $value;
    $this->encoder = $encoder;
  }
  
  public function getEncoder() {
    return $this->encoder;
  }
  
  /**
   * Bypass default display renderer.
   */
  public function raw() {
    return $this->value;
  }
  
  /**
   * Returns the result of calling $encoder->encode($value)
   */
  public function __toString() { 
    return $this->encoder->encode($this->value);
  }
  
  /**
   * Dispatcher for user-defined renderers.
   */
  public function __call($name, $args=null) {
    $r = RendererLoader::get_renderer($name);
     // Note: renderer function is in control of escaping its own output.
    return $r($this, $this->encoder, $args);
  }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function equals($other) { return $this->value==Sandbox::unwrap($other); }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_true() { return $this->value===TRUE; }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_false() { return $this->value===FALSE; }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_null() { return is_null($this->value); }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_empty_string() { return $this->value===''; }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_array() { return is_array($this->value); }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_empty() { 
    return 
      ($this->is_null()) ||
      ($this->is_array() && count($this->value)==0) ||
      ($this->is_empty_string()); 
  }
}
?>