<?

class FragmentGenerator extends Generator {
  
  private $templateDir;
  private $fragment;
  private $encoder;
  
  public function FragmentGenerator($templateDir, $fragment, $params, $encoder) {
    $this->templateDir = $templateDir;
    $this->fragment = $fragment;
    $this->encoder = $encoder;
    $this->setParams($params);
  }
  
  public function execute(array $params) {
    $ctx = new Context($params, $encoder);
    $view = new View($this->templateDir);
    $view->displayFragment($this->fragment, $ctx);
    return '';
  }
}

?>