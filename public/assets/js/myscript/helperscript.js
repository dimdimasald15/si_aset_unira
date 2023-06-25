function capitalize(str) {
  strVal = '';
  str = str.split(' ');
  for (var chr = 0; chr < str.length; chr++) {
    strVal += str[chr].substring(0, 1).toUpperCase() + str[chr].substring(1, str[chr].length) + ' ';
  }
  return strVal;
}
