<?

class RendererLoader {
  
  private static function _load_render_function($function_name, $filename) {
    if (!function_exists($function_name)) {
      // I couldn't figure out how to catch include failures
      // (e.g. when the file doesn't actually exist) without manually
      // traversing the include path. So for now we suppress the warning
      // and don't specifically handle missing files.
      @include_once($filename); 
    }
    if (!function_exists($function_name)) {
      throw new Exception('Unknown render function: ' . $function_name);
    }
    return $function_name;
  }

  public static function get_renderer($name) {
    return self::_load_render_function($name . '_renderer', $name . '.renderer.php');
  }

  public static function get_list_renderer($name) {
    return self::_load_render_function($name . '_list_renderer', $name . '.list_renderer.php');
  }
}

?>