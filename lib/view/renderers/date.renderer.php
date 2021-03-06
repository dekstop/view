<?

// TODO: how can we ensure that this is not affected by system timezone?
// (we should always assume UTC)
// atm tests seem to fail in non-UTC timezones...?!
function date_renderer($property, $encoder, $args) {
  if ($property->is_null()) return Sandbox::wrap(null, $encoder);

  $timestamp = null;
  if (is_numeric($property->raw())) {
    // it is a number or numeric string, we handle it as timestamp
    $timestamp = (int)$property->raw();  
  } else {
    // strtotime should handle it
    $timestamp = strtotime($property->raw());
    if ($timestamp == -1 || $timestamp === false) {
      // strtotime() was not able to parse $string
        return Sandbox::wrap(null, $encoder);
    }
  }
  
  if (count($args)!=1) throw new Exception('Function requires one parameter. Provided: ' . count($args));
  return Sandbox::wrap(date($args[0], $timestamp), $encoder);
}

?>