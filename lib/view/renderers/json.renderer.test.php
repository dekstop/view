<?

class JsonRendererTest extends RendererUnitTestCase {

  function test_null() {
    $this->assertEqual('null', $this->render(null, 'json'));
  }

  function test_empty_string() {
    $this->assertEqual('""', $this->render('', 'json'));
  }

  function test_string() {
    $this->assertEqual('"abc"', $this->render('abc', 'json'));
  }

  function test_html_string() {
    $this->assertEqual('"<b>"', $this->render('<b>', 'json'));
  }

  function test_number() {
    $this->assertEqual('0', $this->render(0, 'json'));
    $this->assertEqual('123', $this->render(123, 'json'));
    $this->assertEqual('-123', $this->render(-123, 'json'));
  }

  function test_boolean() {
    $this->assertEqual('true', $this->render(true, 'json'));
    $this->assertEqual('false', $this->render(false, 'json'));
  }
}

?>