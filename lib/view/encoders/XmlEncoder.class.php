<?

require_once('AbstractEncoder.class.php');

/**
 * Uses htmlentities to escape text, with ENT_QUOTES option. Assumes UTF-8 
 * character encoding.
 */
class XmlEncoder extends AbstractEncoder {
  
  protected function encodeString($value) {
    return htmlentities($value, ENT_QUOTES, 'UTF-8');
  }
}

?>