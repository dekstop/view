<?

class StripTagsRendererTest extends RendererUnitTestCase {
  
  function test_strip_tags() {
    // plain string
    $this->assertEqual('abc', $this->render('abc', 'strip_tags'));
    // with tags
    $this->assertEqual('ac', $this->render('a<b>c', 'strip_tags'));
    $this->assertEqual('ac', $this->render('a<b>c</b>', 'strip_tags'));
    // unclosed tag
    $this->assertEqual('a', $this->render('a<bc', 'strip_tags'));
  }

  function test_null() {
   $this->assertEqual(null, $this->render(null, 'strip_tags'));
  }

  function test_empty_string() {
    $this->assertEqual('', $this->render('', 'strip_tags'));
  }

  function test_multibyte() {
    $this->assertEqual('池田亮司', $this->render('<b>池田亮司</b>', 'strip_tags'));
    $this->assertEqual('池司', $this->render('池<田亮>司', 'strip_tags'));
  }
}
?>