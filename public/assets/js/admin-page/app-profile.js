import { profile, PictureUpdate } from "./app/profile.js";
import { util } from "./app/util.js";

window.util = util;
window.profile = profile;
window.updateFoto = PictureUpdate;

$(document).ready(() => {
    profile.initDocReady();
    new PictureUpdate(); // Initialize PictureUpdate when document is ready
});