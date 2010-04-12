<?

class View {
  
  private $templateDir = '.';
  
  public function View($templateDir) {
    $this->templateDir = $templateDir;
  }
  
  public function display($template, $ctx) {
    $this->displayFile($this->_getTemplateFilename($template), $ctx);
  }
  
  public function displayFragment($template, $ctx) {
    $this->displayFile($this->_getFragmentFilename($template), $ctx);
  }
  
  public function displayFile($__fn, $__ctx) {
    // load variables in local scope
    foreach ($__ctx as $__k=>$__v) {
      $$__k = $__v;
    }
    $view = new ViewHelper($this->templateDir, $__ctx->getEncoder());
    
    // execute template
    if(file_exists($__fn)) {
      include($__fn);
    }
    else {
      throw new Exception('Template file not found: ' . $__fn);
    }
  }
  
  private function _getTemplateFilename($template) {
    return $this->templateDir . '/' . $template . '.view.php';
  }
  
  private function _getFragmentFilename($template) {
    return $this->templateDir . '/_' . $template . '.view.php';
  }
}

?>