<?

require_once('Property.interface.php');

/**
 * A container for lists of properties, which can be accessed using array (map)
 * or object syntax, and which can be iterated over. Values are wrapped in 
 * Property instances when they're added.
 */
class ListProperty implements Property, Countable, ArrayAccess, Iterator {
  private $data = array();
  private $idx = 0;
  
  public function ListProperty($data=array()) {
    foreach ($data as $k=>$v) {
      $this->data[$k] = Sandbox::wrap($v);
    }
  }
  
  /**
   * Bypass default display renderer.
   */
  public function raw() {
    $r = array();
    foreach ($this->data as $k=>$v) {
      $r[$k] = Sandbox::unwrap($v);
    }
    return $r;
  }
  
  /**
   * Simply for convenience. Returns a comma-separated list of all values.
   */
  public function __toString() {
    return implode(', ', array_values($this->data));
  }
  
  /**
   * Dispatcher for user-defined list renderers.
   */
  public function __call($name, $args=null) {
    $r = RendererLoader::get_list_renderer($name);
    return Sandbox::wrap($r($this, $args));
  }
  
  public function values() {
    return array_values($this->data);
  }

  // public function keys() {
  //   $r = array();
  //   foreach (array_keys($this->data) as $k) {
  //     $r[] = Sandbox::wrap($k);
  //   }
  //   return $r;
  // }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function equals($other) { return $this->data==Sandbox::unwrap($other); }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_null() { return is_null($this->data); }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_array() { return is_array($this->data); }
  
  /**
   * For use as flag in display logic control structures.
   */
  public function is_empty() { 
    return 
      self::is_null() ||
      (self::is_array() && count($this->data)==0); 
  }
  
  // Countable function
  public function count() { return count($this->data); }
  
  // ArrayAccess functions
  /**
   * $my_listproperty['a'] = $value
   */
  public function offsetSet($key, $value) {
    if (is_null($key)) { // array append syntax used? e.g. $my_listproperty[] = $value
      $key = count($this->data);
    }
    $this->data[$key] = Sandbox::wrap($value);
  }

  /**
   * $value = $my_listproperty['a']
   */
  public function offsetGet($key) {
    return $this->data[$key];
  }
  
  /**
   * isset($my_listproperty['a'])
   */
  public function offsetExists($key) {
    return isset($this->data[$key]);
  }
  
  /**
   * unset($my_listproperty['a'])
   */
  public function offsetUnset($key) {
    unset($this->data[$key]);
  }

  /**
   * $my_listproperty->a = 123
   */
  public function __set($key, $value) {
    $this[$key] = Sandbox::wrap($value);
  }
  
  /**
   * $value = $my_listproperty->a
   */
  public function __get($key) { 
    return $this[$key];
  }

  // Iterator functions
  function rewind() {
    $this->idx = 0;
  }

  function key() {
    $k = array_keys($this->data);
    return $k[$this->idx];
  }

  function valid() {
    $k = array_keys($this->data);
    return isset($k[$this->idx]);
  }
  
  function current() {
    return $this->data[$this->key()];
  }

  function next() {
    $this->idx++;
  }
}
?>