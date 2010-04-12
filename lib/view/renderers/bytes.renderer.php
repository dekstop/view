<?

function bytes_renderer($property, $encoder, $args) {
  if ($property->is_null()) return Sandbox::wrap(null, $encoder);
  $bytes = $property->raw();
  if (!is_numeric($bytes)) return Sandbox::wrap(null, $encoder);
  $format = '%d';
  $units = array('byte', 'KB', 'MB', 'GB', 'TB', 'PB');
  $scale = 0;
  while ($bytes >= 1024 && $scale<(count($units)-1)) {
    $bytes /= 1024.0;
    $scale++;
    $format = '%.2f';
  }
  return Sandbox::wrap(sprintf($format, $bytes) . ' ' . $units[$scale], $encoder);
}

?>