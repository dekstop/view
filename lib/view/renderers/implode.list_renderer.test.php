<?

class ImplodeListRendererTest extends RendererUnitTestCase {

  function test_empty_list() {
    $this->assertEqual('', $this->render_list(array(), 'implode'));
  }

  function test_list() {
    $this->assertEqual('1, null, abc, true', $this->render_list(array(1, null, 'abc', true), 'implode', ', '));
  }

  function test_html_list() {
    $this->assertEqual('&lt;b&gt;, &lt;i&gt;', $this->render_list(array('<b>', '<i>'), 'implode', ', '));
  }

  function test_html_separator() {
    $this->assertEqual('1&lt;/li&gt;&lt;li&gt;2', $this->render_list(array(1, 2), 'implode', '</li><li>'));
  }
}

?>