<?

class JsonListRendererTest extends RendererUnitTestCase {

  function test_empty_list() {
    $this->assertEqual('[]', $this->render_list(array(), 'json'));
  }

  function test_list() {
    $this->assertEqual('[1,null,"abc",true]', $this->render_list(array(1, null, 'abc', true), 'json'));
  }

  function test_html_list() {
    $this->assertEqual('["<b>"]', $this->render_list(array('<b>'), 'json'));
  }

  function test_map() {
    $this->assertEqual(
      '{"a":1,"b":null,"c":"abc","d":true}', 
      $this->render_list(array('a'=>1, 'b'=>null, 'c'=>'abc', 'd'=>true), 'json'));
  }

  function test_html_map() {
    $this->assertEqual(
      '{"<b>":"<b>"}', 
      $this->render_list(array('<b>'=>'<b>'), 'json'));
  }
}

?>