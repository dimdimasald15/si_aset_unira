function capitalize(r) {
  let strVal = '';
  r = r.split(' ');
  for (var t = 0; t < r.length; t++) {
    strVal += r[t].substring(0, 1).toUpperCase() + r[t].substring(1, r[t].length) + ' ';
  }
  return strVal;
}

const renderFormatTime = (data, type, full, meta) => {
  if (!data || data == "0000-00-00 00:00:00") return '-';
  const dateParts = data.split(/[- :]/);
  const [year, month, day, hours, minutes, seconds] = dateParts.map(part => parseInt(part));
  const options = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
  };
  return new Date(year, month - 1, day, hours, minutes, seconds).toLocaleDateString('id-ID', options);
};

function set_tahun() {
  var skrg = new Date(Date.now());
  var end = skrg.getFullYear()
  var html = `<option value="">Semua Tahun</option>`
  for (let i = end; i >= 1990; i--) {
    html += `<option value="${i}">${i}</option>`
  }

  $("#selecttahun").html(html)
}

function set_bulan() {
  var namaBulan = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];
  var html = `<option value="">Semua Bulan</option>`;

  for (let i = 0; i < namaBulan.length; i++) {
    html += `<option value="${i + 1}">${namaBulan[i]}</option>`;
  }

  $("#selectbulan").html(html);
}