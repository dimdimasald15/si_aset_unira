import { barang } from "./app/barang.js";
import { util } from "./app/util.js";
import { auth } from "./app/auth.js";
import { gedung } from "./app/gedung.js";
import { ruang } from "./app/ruang.js";
import { kategori } from "./app/kategori.js";
import { unit } from "./app/unit.js";
import { anggota } from "./app/anggota.js";
import { selectOption } from "./app/selectOption.js";
import { peminjaman } from "./app/peminjaman.js";
import { notification } from "./notification.js";
import { kodebrg } from "./app/kodebarang.js";

window.barang = barang;
window.util = util;
window.auth = auth;
window.selectOption = selectOption;
window.pinjam = peminjaman;
window.kodebrg = kodebrg;
window.gedung = gedung;
window.ruang = ruang;
window.anggota = anggota;
window.unit = unit;
window.kategori = kategori;
window.notif = notification;