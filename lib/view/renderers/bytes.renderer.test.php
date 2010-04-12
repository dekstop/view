<?

class BytesRendererTest extends RendererUnitTestCase {
  
  function test_null() {
    $this->assertTrue($this->render(null, 'bytes')->is_null());
  }

  function test_empty_string() {
    $this->assertTrue($this->render('', 'bytes')->is_null());
  }

  function test_string() {
    $this->assertTrue($this->render('abc', 'bytes')->is_null());
  }

  function test_bytes() {
    $this->assertEqual('0 byte', $this->render(0, 'bytes'));
    $this->assertEqual('1023 byte', $this->render(1023, 'bytes'));
    $this->assertEqual('1.00 KB', $this->render(1024, 'bytes'));
    $this->assertEqual('1.00 MB', $this->render(1024*1024, 'bytes'));
    $this->assertEqual('1.00 GB', $this->render(1024*1024*1024, 'bytes'));
    $this->assertEqual('1.00 TB', $this->render(1024*1024*1024*1024, 'bytes'));
    $this->assertEqual('1.00 PB', $this->render(1024*1024*1024*1024*1024, 'bytes'));
    $this->assertEqual('1.15 GB', $this->render(1234567890, 'bytes'));
  }
}
?>