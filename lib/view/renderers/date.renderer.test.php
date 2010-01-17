<?

class DateRendererTest extends RendererUnitTestCase {
  
  function test_null() {
    $this->assertEqual(null, $this->render(null, 'date', 'Y-m-d H:i'));
  }

  function test_empty_string() {
    $this->assertEqual(null, $this->render('', 'date', 'Y-m-d H:i'));
  }

  function test_string() {
    $this->assertEqual(null, $this->render('abc', 'date', 'Y-m-d H:i'));
  }

  function test_timestamps() {
    $this->assertEqual('2009-02-13 23:31', $this->render(1234567890, 'date', 'Y-m-d H:i'));
  }

  function test_no_args() {
    $this->expectException();
    $this->render(1234567890, 'date');
  }
}
?>