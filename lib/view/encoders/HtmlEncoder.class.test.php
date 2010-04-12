<?

class HtmlEncoderTest extends ViewUnitTestCase {
  
  function test_encodeString() {
    $e = new HtmlEncoder();
    $this->assertEqual('', $e->encode(''));
    $this->assertEqual('abc', $e->encode('abc'));
    $this->assertEqual('&amp;', $e->encode('&'));
    $this->assertEqual('&amp;amp;', $e->encode('&amp;'));
    $this->assertEqual('&lt;abc&gt;', $e->encode('<abc>'));
    $this->assertEqual('池田亮司', $e->encode('池田亮司'));
  }
}
?>