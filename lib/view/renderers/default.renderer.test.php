<?

class DefaultRendererTest extends RendererUnitTestCase {
  
  function test_default() {
    $this->assertEqual('abc', $this->render('abc', 'default', 'my_default_string'));
    $this->assertEqual('my_default_string', $this->render(null, 'default', 'my_default_string'));
    $this->assertEqual('my_default_string', $this->render('', 'default', 'my_default_string'));
    $this->assertEqual(null, $this->render(null, 'default', null));
  }
  
  function test_no_args() {
    $this->expectException();
    $this->render('abc', 'default');
  }
}
?>