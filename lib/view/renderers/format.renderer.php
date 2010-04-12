<?

function format_renderer($property, $encoder, $args) {
  if (count($args)!=1) throw new Exception('Function requires one parameter. Provided: ' . count($args));
  return Sandbox::wrap(sprintf($args[0], $property->raw()), $encoder);
}

?>