<?

function default_renderer($property, $args) {
  if (count($args)!=1) throw new Exception('Function requires one parameter. Provided: ' . count($args));
  if ($property->is_null() || $property->is_empty_string()) return $args[0];
  return $property;
}

?>