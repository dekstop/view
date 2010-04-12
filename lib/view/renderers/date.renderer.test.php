<?

class DateRendererTest extends RendererUnitTestCase {
  
  function test_null() {
    $this->assertTrue($this->render(null, 'date', 'Y-m-d H:i')->is_null());
  }

  function test_empty_string() {
    $this->assertTrue($this->render('', 'date', 'Y-m-d H:i')->is_null());
  }

  function test_string() {
    $this->assertTrue($this->render('abc', 'date', 'Y-m-d H:i')->is_null());
  }

  function test_timestamps() {
    $this->assertEqual('2009-02-13 23:31', $this->render(1234567890, 'date', 'Y-m-d H:i'));
  }

  function test_string_timestamps() {
    $this->assertEqual('2009-02-13 23:31', $this->render('2009-02-13 23:31', 'date', 'Y-m-d H:i'));
    $this->assertEqual('2009-07-09 03:27', $this->render('2009-07-09 03:27:48.064122', 'date', 'Y-m-d H:i'));
  }

  function test_no_args() {
    $this->expectException();
    $this->render(1234567890, 'date');
  }
}
?>