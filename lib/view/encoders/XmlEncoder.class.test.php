<?

class XmlEncoderTest extends ViewUnitTestCase {
  
  function test_encodeString() {
    $e = new XmlEncoder();
    $this->assertEqual('', $e->encode(''));
    $this->assertEqual('abc', $e->encode('abc'));
    $this->assertEqual('&lt;abc&gt;', $e->encode('<abc>'));
    $this->assertEqual('池田亮司', $e->encode('池田亮司'));
  }
}
?>