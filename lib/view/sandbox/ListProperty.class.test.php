<?

class ListPropertyTest extends ViewUnitTestCase {
  
  function test_null() {
    // $this->expectError();
    // $p = new ListProperty(null, $this->getEncoder());
  }

  function test_empty_array() {
    $p = new ListProperty(array(), $this->getEncoder());
    $this->assertEqual(0, count($p));
    $this->assertEqual(0, $p->count());
    $this->assertEqual('', (string)$p);
    $this->assertEqual(array(), $p->raw());
    //$this->assertEqual(array(), $p->keys());
    $this->assertEqual(array(), $p->values());
  }

  function test_array() {
    $list = array(1, 2, 'a');
    $p = new ListProperty($list, $this->getEncoder());
    // wrap
    //$this->assertEqual(array($this->wrap(0), $this->wrap(1), $this->wrap(2)), $p->keys());
    $this->assertEqual(array($this->wrap(1), $this->wrap(2), $this->wrap('a')), $p->values());
    // count
    $this->assertEqual(3, count($p));
    $this->assertEqual(3, $p->count());
    // print
    $this->assertEqual('1, 2, a', (string)$p);
    // raw access
    $this->assertEqual($list, $p->raw());
    // index
    $this->assertEqual(1, $p[0]->raw());
    $this->assertEqual(2, $p[1]->raw());
    $this->assertEqual('a', $p[2]->raw());
  }

  function test_array_append() {
    $list = array(1, 2, 'a');
    $p = new ListProperty($list, $this->getEncoder());
    $p[] = 'b';
    $this->assertEqual(4, $p->count());
    $this->assertEqual('b', $p[3]->raw());
  }

  function test_array_iterate() {
    $list = array(1, 2, 'a');
    $p = new ListProperty($list, $this->getEncoder());
    foreach ($p as $v) {
      $this->assertEqual($list[0], $v->raw());
      array_shift($list); // note: clearing $list here
    }
    $this->assertEqual(0, count($list), 'Did not iterate over all items.'); 
  }

  function test_map() {
    $map = array('a' => 1, 'b' => 2, 'c' => 'a');
    $p = new ListProperty($map, $this->getEncoder());
    // wrap
    //$this->assertEqual(array($this->wrap(0), $this->wrap(1), $this->wrap(2)), $p->keys());
    $this->assertEqual(array($this->wrap(1), $this->wrap(2), $this->wrap('a')), $p->values());
    // count
    $this->assertEqual(3, count($p));
    $this->assertEqual(3, $p->count());
    // print
    $this->assertEqual('1, 2, a', (string)$p);
    // raw access
    $this->assertEqual($map, $p->raw());
    // index
    $this->assertEqual(1, $p['a']->raw());
    $this->assertEqual(2, $p['b']->raw());
    $this->assertEqual('a', $p['c']->raw());
    // object syntax
    $this->assertEqual(1, $p->a->raw());
    $this->assertEqual(2, $p->b->raw());
    $this->assertEqual('a', $p->c->raw());
  }
  
  function test_map_append() {
    $map = array('a' => 1, 'b' => 2, 'c' => 'a');
    $p = new ListProperty($map, $this->getEncoder());
    $p['d'] = 'b';
    $this->assertEqual(4, $p->count());
    $this->assertEqual('b', $p['d']->raw());
    $this->assertEqual('b', $p->d->raw());
  }
  
  function test_map_iterate() {
    $map = array('a' => 1, 'b' => 2, 'c' => 'a');
    $p = new ListProperty($map, $this->getEncoder());
    foreach ($p as $k=>$v) {
      $this->assertEqual($map[$k], $v->raw());
      unset($map[$k]); // note: clearing $map here
    }
    $this->assertEqual(0, count($map), 'Did not iterate over all items. Number of unvisited items: ' . count($map)); 
  }

  function test_nested_array() {
    $p = new ListProperty(array(), $this->getEncoder());
    $p->a = array();
    $p->a['b'] = 'c';
    $this->assertEqual(1, $p->count());
    $this->assertEqual(1, $p->a->count());
    $this->assertEqual('c', $p->a['b']->raw());
    $this->assertEqual('c', $p->a->b->raw());
  }
  
  function test_unknown_renderer_exception() {
    $p = new ListProperty(array('a'=>1), $this->getEncoder());
    $this->expectException();
    $p->renderer_which_does_not_exist();
  }

  function test_is_null() {
    $p = new ListProperty(null, $this->getEncoder());
    $this->assertEqual(true, $p->is_null());
    $p = new ListProperty(array(), $this->getEncoder());
    $this->assertEqual(false, $p->is_null());
    $p = new ListProperty(array(null), $this->getEncoder());
    $this->assertEqual(false, $p->is_null());
  }

  function test_is_array() {
    $p = new ListProperty(null, $this->getEncoder());
    $this->assertEqual(false, $p->is_array());
    $p = new ListProperty(array(null), $this->getEncoder());
    $this->assertEqual(true, $p->is_array());
    $p = new ListProperty(array('a'=>1), $this->getEncoder());
    $this->assertEqual(true, $p->is_array());
  }

  function test_is_empty() {
    $p = new ListProperty(null, $this->getEncoder());
    $this->assertEqual(true, $p->is_empty());
    $p = new ListProperty(array(), $this->getEncoder());
    $this->assertEqual(true, $p->is_empty());
    $p = new ListProperty(array(null), $this->getEncoder());
    $this->assertEqual(false, $p->is_empty());
    $p = new ListProperty(array(false), $this->getEncoder());
    $this->assertEqual(false, $p->is_empty());
    $p = new ListProperty(array(1234567890=>'sdfa'), $this->getEncoder());
    $this->assertEqual(false, $p->is_empty());
  }
}

?>