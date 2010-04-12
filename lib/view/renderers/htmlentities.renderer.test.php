<?

class HtmlentitiesRendererTest extends RendererUnitTestCase {

  function test_null() {
    $this->assertTrue($this->render(null, 'htmlentities')->is_null());
  }

  function test_empty_string() {
    $this->assertEqual('', $this->render('', 'htmlentities')->raw());
  }

  function test_string() {
    $this->assertEqual('abc', $this->render('abc', 'htmlentities')->raw());
  }

  function test_html_string() {
    $this->assertEqual('&lt;b&gt;', $this->render('<b>', 'htmlentities')->raw());
  }
}

?>