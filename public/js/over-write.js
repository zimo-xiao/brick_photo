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
  u.searchParams.set('anchor', '1');
  u.searchParams.forEach((v, k) => {
    $('<input>').attr({
      'name': k,
      'value': v,
      'type': 'hidden'
    }).appendTo('#jump');
  });
  $('#jump').attr('action', u.origin).submit();
}

function jumpToAnchor() {
  document.getElementById('anchor').scrollIntoView();
}​