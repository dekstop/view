<?

function htmlentities_renderer($property, $args) {
  if ($property->is_null()) return null;
  return htmlentities($property->raw(), ENT_QUOTES, 'UTF-8');
}

?>