<?

function date_renderer($property, $args) {
  if ($property->is_null()) return null;

  $timestamp = null;
  if (is_numeric($property->raw())) {
    // it is a number or numeric string, we handle it as timestamp
    $timestamp = (int)$property->raw();  
  } else {
    // strtotime should handle it
    $timestamp = strtotime($property->raw());
    if ($timestamp == -1 || $timestamp === false) {
      // strtotime() was not able to parse $string
        return null;
    }
  }
  
  if (count($args)!=1) throw new Exception('Function requires one parameter. Provided: ' . count($args));
  return date($args[0], $timestamp);
}

?>