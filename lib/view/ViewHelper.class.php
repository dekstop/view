<?

/**
 * Hosts various template generator functions. An instance of this class is made available 
 * to templates as a variable named $view.
 */
class ViewHelper {
  
  private $_templateDir;
  
  public function ViewHelper($templateDir) {
    $this->_templateDir = $templateDir;
  }
  
  public function fragment($name, $params=array()) {
    return new FragmentGenerator($this->_templateDir, Sandbox::unwrap($name), Sandbox::unwrap($params));
  }
}

?>