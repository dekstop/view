<?
/**
 * A container for a single property, responsible for making its value
 * available for display. The default renderer attempts to sanitise
 * for HTML output (incl. type conversion and character escaping.)
 *
 * Custom renderers, once registered, can simply be called by their name: 
 * $my_property->my_renderer();
 *
 * Additionally this class offers basic checks for use in display logic 
 * control structures.
 */
class Property {
  
  private $value = null;
  
  public function Property($value) { 
    $this->value = $value; 
  }
  
  /**
   * Bypass default display renderer.
   */
  public function raw() {
    return $this->value;
  }
  
  /**
   * Default display renderer.
   */
  public function __toString() { 
    if ($this->is_null()) return 'null';
    if ($this->is_true()) return 'true';
    if ($this->is_false()) return 'false';
    // For now we'll just blindly treat every other value as a string.
    // May add more special cases for other types/classes later.
    return htmlentities($this->value, ENT_QUOTES, 'UTF-8');
  }
  
  /**
   * Dispatcher for user-defined renderers.
   */
  public function __call($name, $args=null) {
    $r = RendererLoader::get_renderer($name);
    return Sandbox::wrap($r($this, $args));
  }
  
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
}
?>