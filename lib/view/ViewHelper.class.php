<?

/**
 * Hosts various template generator functions. An instance of this class is made available 
 * to templates as a variable named $view.
 */
class ViewHelper {
  
  private $templateDir = null;
  private $encoder = null;
  
  public function ViewHelper($templateDir, $encoder) {
    $this->templateDir = $templateDir;
    $this->encoder = $encoder;
  }
  
  public function fragment($name, $params=array()) {
    return new FragmentGenerator($this->templateDir, Sandbox::unwrap($name), Sandbox::unwrap($params), $this->encoder);
  }
  
  /**
   * Alias for fragment($name, $params)
   */
  public function display($name, $params=array()) {
    return $this->fragment($name, $params);
  }
}

?>