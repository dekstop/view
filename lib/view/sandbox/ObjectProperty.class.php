<?

require_once('Property.interface.php');

/**
 * A container for a single object, which provides access to its public 
 * properties and methods.
 *
 * Note that values returned from a method call will always be wrapped in a 
 * Property instance. (This is different from values returned by render 
 * function calls on ScalarProperty and ListProperty instances, where the 
 * render function is in control of sandboxing.)
 *
 * The default renderer just throws an exception; it is not expected that you 
 * will want to print objects themselves. Instead they're seen as a means to
 * access/construct printable properties.
 *
 * There's one additional bit of syntactic sugar to make it more convenient to 
 * access properties: ObjectProperty will redirect read access of named 
 * properties to a function call if there is no public property of that name.
 * I.e., trying to read the non-existent $my_object_property->myField will 
 * result in a call to $my_object_property->getMyField() instead.
 *
 * This class should never be instantiated directly.
 */
class ObjectProperty implements Property {
  
  private $obj = null;
  private $encoder = null;
  
  public function ObjectProperty($obj, $encoder) { 
    $this->obj = $obj; 
    $this->encoder = $encoder;
  }
  
  public function getEncoder() {
    return $this->encoder;
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
      return Sandbox::wrap($v, $this->encoder);
    }
    throw new Exception('Object has no such method: ' . $name);
  }
  
  /**
   * $my_objectproperty->a = 123
   */
  public function __set($key, $value) {
    $this->obj->$key = Sandbox::unwrap($value);
  }
  
  /**
   * $value = $my_objectproperty->a
   */
  public function __get($key) { 
    if (array_key_exists($key, get_object_vars($this->obj))) {
      return Sandbox::wrap($this->obj->$key, $this->encoder);
    }
    # No such property -> call a getter method instead.
    # Note that in PHP function names are case insensitive, so it doesn't matter if
    # we call ->getx() or ->getX() (The same is not true for variable names.)
    $accessor_method = 'get' . $key; 
    return Sandbox::wrap($this->obj->$accessor_method(), $this->encoder);
  }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function equals($other) { return $this->obj==Sandbox::unwrap($other); }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_null() { return is_null($this->obj); }
}


?>