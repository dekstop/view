<?

class View {
  
  private $templateDir = '.';
  
  function View($templateDir) {
    $this->templateDir = $templateDir;
  }
  
  private function _getTemplateFilename($template) {
    return $this->templateDir . '/' . $template . '.view.php';
  }
  
  #function ob_callback($buffer, $flags) {
  #  return $buffer;
  #}
  
  function display($__template, $__ctx) {
    foreach ($__ctx as $k=>$v) {
      $$k = $v; // load variables in local scope
    }
    $fn = $this->_getTemplateFilename($__template);
    if(file_exists($fn)) {
      #ob_start(array($this, 'ob_callback'));
      include($fn); // execute template
      #ob_end_flush();
    }
    else {
      throw new Exception('Template file not found: ' . $fn);
    }
  }
  
}

?>