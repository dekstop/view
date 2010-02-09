<?

class ClassWithProperties {
  private $a = 1;
  public $b = 2;
  public $c = array('a', 'b', 'c');
}

class ClassWithMethods {
  private function privateMethod() { return 1; }
  public function getOne() { return 1; }
  public function getMany() { return array(1, 2, 3); }
  public function getArg($arg) { return $arg; }
}

class PropertyObjectTest extends UnitTestCase {
  
  function test_null() {
    $p = new PropertyObject(null);
    $this->assertNull($p->raw());
  }

  function test_private_property() {
    // FIXME: this test fails to catch the "Fatal error: Cannot access private property ClassWithProperties::$a"
    // $p = new PropertyObject(new ClassWithProperties());
    // $this->expectError();
    // $a = $p->a; // private field
  }

  function test_public_property() {
    $p = new PropertyObject(new ClassWithProperties());

    $this->assertEqual(new Property(2), $p->b);
    $this->assertEqual(2, $p->b->raw());

    $this->assertEqual(new PropertyList(array('a', 'b', 'c')), $p->c);
    $this->assertEqual(array('a', 'b', 'c'), $p->c->raw());
  }
      
  function test_add_property() {
    $p = new PropertyObject(new ClassWithProperties());

    $p->x = 3;
    $this->assertEqual(new Property(3), $p->x);
    $this->assertEqual(3, $p->x->raw());

    $p->y = array(1, 2, 3);
    $this->assertEqual(new PropertyList(array(1, 2, 3)), $p->y);
    $this->assertEqual(array(1, 2, 3), $p->y->raw());
  }
      
  function test_update_property() {
    $p = new PropertyObject(new ClassWithProperties());
    $p->b = 3; // field already exists
    $this->assertEqual(new Property(3), $p->b);
    $this->assertEqual(3, $p->b->raw());

    $p = new PropertyObject(new ClassWithProperties());
    $p->b = array(1, 2, 3); // field already exists
    $this->assertEqual(new PropertyList(array(1, 2, 3)), $p->b);
    $this->assertEqual(array(1, 2, 3), $p->b->raw());
  }
  
  function test_private_method() {
    $p = new PropertyObject(new ClassWithMethods());
    $this->expectError();
    $a = $p->privateMethod(); // private method
  }
  
  function test_method_call() {
    $p = new PropertyObject(new ClassWithMethods());
    
    $this->assertEqual(new Property(1), $p->getOne());
    $this->assertEqual(1, $p->getOne()->raw());
    
    $this->assertEqual(new PropertyList(array(1, 2, 3)), $p->getMany());
    $this->assertEqual(array(1, 2, 3), $p->getMany()->raw());
    
    $this->assertEqual(new Property('abc'), $p->getArg('abc'));
    $this->assertEqual('abc', $p->getArg('abc')->raw());
  }

  function test_nosuchmethod_exception() {
    $p = new PropertyObject(new ClassWithMethods());
    $this->expectException();
    $p->method_which_does_not_exist();
  }

  function test_is_null() {
    $p = new PropertyObject(null);
    $this->assertEqual(true, $p->is_null());

    $p = new PropertyObject(new ClassWithProperties());
    $this->assertEqual(false, $p->is_null());
  }
}

?>