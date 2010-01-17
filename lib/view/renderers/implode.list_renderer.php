<?

function implode_list_renderer($list, $args) {
  return implode(htmlentities($args[0], ENT_QUOTES, 'UTF-8'), $list->values());
}

?>