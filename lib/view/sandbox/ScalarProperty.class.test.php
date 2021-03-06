<?

// TODO: render function chaining and its effect on escaping
class ScalarPropertyTest extends ViewUnitTestCase {

  function test_null() {
    $p = new ScalarProperty(null, $this->getEncoder());
    $this->assertEqual('null', $p);
    $this->assertEqual('null', (string)$p);
    $this->assertEqual(null, $p->raw());
    $this->assertFalse($p->is_true());
    $this->assertFalse($p->is_false());
    $this->assertTrue($p->is_null());
  }

  function test_bool() {
    $p = new ScalarProperty(true, $this->getEncoder());
    $this->assertEqual('true', $p);
    $this->assertEqual('true', (string)$p);
    $this->assertEqual(true, $p->raw());
    $this->assertTrue($p->is_true());
    $this->assertFalse($p->is_false());
    $this->assertFalse($p->is_null());
  }

  function test_int() {
    $p = new ScalarProperty(1, $this->getEncoder());
    $this->assertEqual('1', (string)$p);
    $this->assertEqual(1, $p->raw());
    $this->assertTrue($p->equals(1));
    $this->assertFalse($p->equals(2));
    $this->assertFalse($p->is_null());
  }

  function test_float() {
    $p = new ScalarProperty(1.5, $this->getEncoder());
    $this->assertEqual('1.5', $p);
    $this->assertEqual('1.5', (string)$p);
    $this->assertEqual(1.5, $p->raw());
    $this->assertTrue($p->equals(1.5));
    $this->assertFalse($p->equals(2.5));
    $this->assertFalse($p->is_null());
  }

  function test_string() {
    $p = new ScalarProperty('Bob', $this->getEncoder());
    $this->assertEqual('Bob', $p);
    $this->assertEqual('Bob', (string)$p);
    $this->assertEqual('Bob', $p->raw());
    $this->assertFalse($p->is_true());
    $this->assertFalse($p->is_false());
    $this->assertFalse($p->is_null());
  }

  function test_html_string() {
    $p = new ScalarProperty('<b>', $this->getEncoder());
    $this->assertEqual('&lt;b&gt;', $p);
    $this->assertEqual('&lt;b&gt;', (string)$p);
    $this->assertEqual('<b>', $p->raw());
    $this->assertFalse($p->is_true());
    $this->assertFalse($p->is_false());
    $this->assertFalse($p->is_null());
  }

  function test_chained_renderers() {
    $p = new ScalarProperty('1234567890', $this->getEncoder());
    $this->assertEqual('12345', $p->truncate(5, '')->raw());
    $this->assertEqual('1234', $p->truncate(5, '')->truncate(4, '')->raw());
  }

  function test_unknown_renderer_exception() {
    $p = new ScalarProperty(1, $this->getEncoder());
    $this->expectException();
    $p->renderer_which_does_not_exist();
  }

  function test_is_array() {
    $p = new ScalarProperty(null, $this->getEncoder());
    $this->assertEqual(false, $p->is_array());
    $p = new ScalarProperty(false, $this->getEncoder());
    $this->assertEqual(false, $p->is_array());
    $p = new ScalarProperty(1234567890, $this->getEncoder());
    $this->assertEqual(false, $p->is_array());
    $p = new ScalarProperty('1234567890', $this->getEncoder());
    $this->assertEqual(false, $p->is_array());
  }

  function test_is_empty() {
    $p = new ScalarProperty(null, $this->getEncoder());
    $this->assertEqual(true, $p->is_empty());
    $p = new ScalarProperty(false, $this->getEncoder());
    $this->assertEqual(false, $p->is_empty());
    $p = new ScalarProperty(1234567890, $this->getEncoder());
    $this->assertEqual(false, $p->is_empty());
    $p = new ScalarProperty('1234567890', $this->getEncoder());
    $this->assertEqual(false, $p->is_empty());
  }

}

?>