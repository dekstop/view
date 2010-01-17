<?

function bytes_renderer($property, $args) {
  if ($property->is_null()) return null;
  $bytes = $property->raw();
  if (!is_numeric($bytes)) return null;
  $format = '%d';
  $units = array('byte', 'KB', 'MB', 'GB', 'TB', 'PB');
  $scale = 0;
  while ($bytes >= 1024 && $scale<(count($units)-1)) {
    $bytes /= 1024.0;
    $scale++;
    $format = '%.2f';
  }
  return sprintf($format, $bytes) . ' ' . $units[$scale];
}

?>