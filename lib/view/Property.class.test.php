<?

// TODO: render function chaining and its effect on escaping
class PropertyTest extends UnitTestCase {
  function test_null() {
    $p = new Property(null);
    $this->assertEqual('null', $p);
    $this->assertEqual('null', (string)$p);
    $this->assertEqual(null, $p->raw());
    $this->assertFalse($p->is_true());
    $this->assertFalse($p->is_false());
    $this->assertTrue($p->is_null());
  }

  function test_bool() {
    $p = new Property(true);
    $this->assertEqual('true', $p);
    $this->assertEqual('true', (string)$p);
    $this->assertEqual(true, $p->raw());
    $this->assertTrue($p->is_true());
    $this->assertFalse($p->is_false());
    $this->assertFalse($p->is_null());
  }

  function test_string() {
    $p = new Property('Bob');
    $this->assertEqual('Bob', $p);
    $this->assertEqual('Bob', (string)$p);
    $this->assertEqual('Bob', $p->raw());
    $this->assertFalse($p->is_true());
    $this->assertFalse($p->is_false());
    $this->assertFalse($p->is_null());
  }

  function test_html_string() {
    $p = new Property('<b>');
    $this->assertEqual('&lt;b&gt;', $p);
    $this->assertEqual('&lt;b&gt;', (string)$p);
    $this->assertEqual('<b>', $p->raw());
    $this->assertFalse($p->is_true());
    $this->assertFalse($p->is_false());
    $this->assertFalse($p->is_null());
  }

  function test_chained_renderers() {
    $p = new Property(1234567890);
    $this->assertEqual('2009-02-13 <', $p->date('Y-m-d <')->raw());
    $this->assertEqual('2009-02-13 &lt;', $p->date('Y-m-d <')->htmlentities()->raw());
  }

  function test_unknown_renderer_exception() {
    $p = new Property(1);
    $this->expectException();
    $p->renderer_which_does_not_exist();
  }
}

?>