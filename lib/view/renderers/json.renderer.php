<?

function json_renderer($property, $args) {
  return json_encode($property->raw());
}

?>