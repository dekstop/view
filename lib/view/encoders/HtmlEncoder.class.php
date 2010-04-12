<?

require_once('AbstractEncoder.class.php');

/**
 * Uses htmlspecialchars to escape text, with ENT_QUOTES option. Assumes UTF-8 
 * character encoding.
 */
class HtmlEncoder extends AbstractEncoder {
  
  protected function encodeString($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }
}

?>