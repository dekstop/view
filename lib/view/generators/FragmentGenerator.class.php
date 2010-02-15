<?

class FragmentGenerator extends Generator {
  
  private $templateDir;
  private $fragment;
  
  public function FragmentGenerator($templateDir, $fragment, $params) {
    $this->templateDir = $templateDir;
    $this->fragment = $fragment;
    $this->setParams($params);
  }
  
  public function execute(array $params) {
    $ctx = new Context($params);
    $view = new View($this->templateDir);
    $view->displayFragment($this->fragment, $ctx);
    return '';
  }
}

?>