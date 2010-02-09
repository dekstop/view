<?

/**
 * A container for a single object, which provides access to its public 
 * properties and methods.
 *
 * The default renderer just throws an exception; it is not expected that you 
 * will want to print objects themselves. Instead they're seen as a means to
 * access/construct printable properties.
 */
class PropertyObject {
  
  private $obj;
  
  public function PropertyObject($obj) { 
    $this->obj = $obj; 
  }
  
  /**
   * Bypass default display renderer.
   */
  public function raw() {
    return $this->obj;
  }
  
  /**
   * Default display renderer. Throws an exception.
   */
  public function __toString() { 
    throw new Exception('Object cannot be evaluated as string (did you try to print it?).');
  }
  
  /**
   * Dispatcher for user-defined list renderers.
   */
  public function __call($name, $args=array()) {
    if (method_exists($this->obj, $name)) {
      $v = call_user_func_array(array($this->obj, $name), $args);
      return Sandbox::wrap($v);
    }
    throw new Exception('Object has no such method: ' . $name);
  }
  
  /**
   * $my_propertyobj->a = 123
   */
  public function __set($key, $value) {
    $this->obj->$key = Sandbox::unwrap($value);
  }
  
  /**
   * $value = $my_propertyobj->a
   */
  public function __get($key) { 
    return Sandbox::wrap($this->obj->$key);
  }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_null() { return is_null($this->obj); }
}


?>