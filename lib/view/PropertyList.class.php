<?
/**
 * A container for lists of properties, which can be accessed using array (map)
 * or object syntax, and which can be iterated over. Values are wrapped in 
 * Property or PropertyList objects when they're added.
 */
class PropertyList implements ArrayAccess, Iterator, Countable {
  private $data = array();
  private $idx = 0;
  
  public function PropertyList($data=array()) {
    foreach ($data as $k=>$v) {
      $this->data[$k] = self::_wrap($v);
    }
  }
  
  /**
   * $my_propertylist['a'] = $value
   */
  public function offsetSet($key, $value) {
    if (is_null($key)) { // array append syntax used? e.g. $my_propertylist[] = $value
      $key = count($this->data);
    }
    $this->data[$key] = self::_wrap($value);
  }

  /**
   * $value = $my_propertylist['a']
   */
  public function offsetGet($key) {
    return $this->data[$key];
  }
  
  /**
   * isset($my_propertylist['a'])
   */
  public function offsetExists($key) {
    return isset($this->data[$key]);
  }
  
  /**
   * unset($my_propertylist['a'])
   */
  public function offsetUnset($key) {
    unset($this->data[$key]);
  }

  /**
   * $my_propertylist->a = 123
   */
  public function __set($key, $value) {
    $this[$key] = self::_wrap($value);
  }
  
  /**
   * $value = $my_propertylist->a
   */
  public function __get($key) { 
    return $this[$key];
  }
  
  /**
   * Bypass default display renderer.
   */
  public function raw() {
    $r = array();
    foreach ($this->data as $k=>$v) {
      $r[$k] = self::_unwrap($v);
    }
    return $r;
  }
  
  public function values() {
    return array_values($this->data);
  }

  // public function keys() {
  //   $r = array();
  //   foreach (array_keys($this->data) as $k) {
  //     $r[] = self::_wrap($k);
  //   }
  //   return $r;
  // }
  
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
    $r = get_list_renderer($name);
    return self::_wrap($r($this, $args));
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

  // Countable function
  public function count() { return count($this->data); }
  
  // util
  private static function _wrap($value) {
    if (($value instanceof Property) || ($value instanceof PropertyList)) {
      return $value; // don't wrap twice
    }
    if (is_array($value)) {
      return new PropertyList($value);
    }
    return new Property($value);
  }

  private static function _unwrap($value) {
    if (($value instanceof Property) || ($value instanceof PropertyList)) {
      return $value->raw();
    }
    return $value;
  }
}
?>