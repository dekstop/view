<?

/**
 * ...
 */
abstract class Generator {
  
  private $_vars = array();

  /**
   * Implement this in subclasses. Must return a string that is safe for display (i.e., 
   * that is properly escaped where appropriate).
   */
  protected abstract function execute(array $parameters);
  
  protected function setParams($params) {
    foreach ($params as $k=>$v) {
      $this->setParam($k, $v);
    }
  }
  
  protected function setParam($key, $value) {
    $this->_vars[$key] = Sandbox::unwrap($value);
  }
  
  /**
   * Set named properties in $this->_vars.
   */
  public function __call($name, $args=array()) {
    if (count($args)==1) {
      $this->setParam($name, Sandbox::unwrap($args[0]));
    }
    else {
      $this->setParam($name, Sandbox::unwrap($args));
    }
    return $this; # this allows chaining and is needed for our __toString trigger
  }

  /**
   * Calls $this->execute($this->_vars).
   */
  public function __toString() {
    return $this->execute($this->_vars);
  }
  
  public function build() {
    return $this->execute($this->_vars);
  }
}

?>