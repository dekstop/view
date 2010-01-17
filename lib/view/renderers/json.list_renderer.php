<?

function json_list_renderer($list, $args) {
  return json_encode($list->raw());
}

?>