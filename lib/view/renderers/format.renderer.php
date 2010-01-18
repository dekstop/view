<?

function format_renderer($property, $args) {
  if (count($args)!=1) throw new Exception('Function requires one parameter. Provided: ' . count($args));
  return sprintf($args[0], $property->raw());
}

?>