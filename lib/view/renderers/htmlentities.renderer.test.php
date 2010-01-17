<?

class HtmlentitiesRendererTest extends RendererUnitTestCase {

  function test_null() {
    $this->assertEqual(null, $this->render(null, 'htmlentities'));
  }

  function test_empty_string() {
    $this->assertEqual('', $this->render('', 'htmlentities'));
  }

  function test_string() {
    $this->assertEqual('abc', $this->render('abc', 'htmlentities'));
  }

  function test_html_string() {
    $this->assertEqual('&lt;b&gt;', $this->render('<b>', 'htmlentities'));
  }
}

?>