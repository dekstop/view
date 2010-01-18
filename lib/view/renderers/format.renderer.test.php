<?

class FormatRendererTest extends RendererUnitTestCase {
  
  function test_format() {
   $this->assertEqual('0.33', $this->render(1/3.0, 'format', '%.2f'));
   $this->assertEqual('ff', $this->render(255, 'format', '%x'));
  }

  function test_null() {
   $this->assertEqual('0.00', $this->render(null, 'format', '%.2f'));
   $this->assertEqual('0', $this->render(null, 'format', '%x'));
  }

  function test_empty_string() {
   $this->assertEqual('0.00', $this->render('', 'format', '%.2f'));
   $this->assertEqual('0', $this->render('', 'format', '%x'));
  }

  function test_string_as_number() {
   $this->assertEqual(0, $this->render('abc', 'format', '%d'));
  }

  function test_no_args() {
   $this->expectException();
   $this->render(1234567890, 'format');
  }
}
?>