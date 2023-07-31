function capitalize(r) {
  let strVal = '';
  r = r.split(' ');
  for (var t = 0; t < r.length; t++) {
    strVal += r[t].substring(0, 1).toUpperCase() + r[t].substring(1, r[t].length) + ' ';
  }
  return strVal;
}
