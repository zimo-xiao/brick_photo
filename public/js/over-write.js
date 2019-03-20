function stringToJson(string) {
  return JSON.stringify(string);
}

function jsonLength(c) {
  var lengthJson = 0;
  for (var i in c) {
    lengthJson++;
  }
  return lengthJson;
}

function jumpTo(u) {
  u.searchParams.forEach((v, k) => {
    $('<input>').attr({
      'name': k,
      'value': v,
      'type': 'hidden'
    }).appendTo('#jump');
  });
  $('#jump').attr('action', u.origin + u.hash).submit();
}