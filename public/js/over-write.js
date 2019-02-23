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