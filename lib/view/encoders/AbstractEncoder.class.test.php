<?

class MyAbstactEncoder extends AbstractEncoder { }

class AbstractEncoderTest extends ViewUnitTestCase {
  
  function test_encodeNull() {
    $e = new MyAbstactEncoder();
    $this->assertEqual('null', $e->encode(null));
  }
  
  function test_encodeBool() {
    $e = new MyAbstactEncoder();
    $this->assertEqual('true', $e->encode(true));
    $this->assertEqual('false', $e->encode(false));
  }
  
  function test_encodeFloat() {
    $e = new MyAbstactEncoder();
    $this->assertEqual('1.1', $e->encode(1.1));
    $this->assertEqual('0.0', $e->encode(0.0));
    $this->assertEqual('-1.1', $e->encode(-1.1));
  }
  
  function test_encodeInt() {
    $e = new MyAbstactEncoder();
    $this->assertEqual('1', $e->encode(1));
    $this->assertEqual('0', $e->encode(0));
    $this->assertEqual('-1', $e->encode(-1));
  }
  
  function test_encodeString() {
    $e = new MyAbstactEncoder();
    $this->assertEqual('', $e->encode(''));
    $this->assertEqual('abc', $e->encode('abc'));
    $this->assertEqual('<abc>', $e->encode('<abc>'));
    $this->assertEqual('池田亮司', $e->encode('池田亮司'));
  }
}
?>