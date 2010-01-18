<?

class TruncateRendererTest extends RendererUnitTestCase {
  
  function test_truncate() {
    $this->assertEqual('123', $this->render('123', 'truncate', 5));
    $this->assertEqual('1234...', $this->render('1234567890', 'truncate', 7));
  }

  function test_null() {
   $this->assertEqual(null, $this->render(null, 'truncate', 10));
  }

  function test_empty_string() {
    $this->assertEqual('', $this->render('', 'truncate', 10));
  }

  function test_multibyte() {
    $this->assertEqual('池...', $this->render('池田亮司abc', 'truncate', 4));
    $this->assertEqual('123456…', $this->render('1234567890', 'truncate', 7, '…'));
  }

  function test_no_args() {
    $this->expectException();
    $this->render('1234567890', 'truncate');
  }
}
?>