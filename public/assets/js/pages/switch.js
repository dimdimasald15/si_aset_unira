/**
 *  Light Switch @version v0.1.4
 */

(function () {
  let lightSwitch = document.getElementById('lightSwitch');
  if (!lightSwitch) {
    return;
  }

  /**
   * @function darkmode
   * @summary: changes the theme to 'dark mode' and save settings to local stroage.
   * Basically, replaces/toggles every CSS class that has '-light' class with '-dark'
   */
  function darkMode() {
    document.querySelectorAll('.bg-light').forEach((element) => {
      element.className = element.className.replace(/-light/g, '-dark');
    });

    document.querySelectorAll('.link-dark').forEach((element) => {
      element.className = element.className.replace(/link-dark/, 'text-white');
    });

    document.body.classList.add('bg-dark');

    if (document.body.classList.contains('text-dark')) {
      document.body.classList.replace('text-dark', 'text-light');
    } else {
      document.body.classList.add('text-light');
    }

    // Tables
    var tables = document.querySelectorAll('table');
    var cards = document.querySelectorAll('.card');
    var cardheaders = document.querySelectorAll('.card-header');
    var cardbodies = document.querySelectorAll('.card-body');
    var headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
    var navbar = document.querySelectorAll('.navbar');

    // Add classes to tables
    tables.forEach((table) => {
      table.classList.add('table-dark', 'text-white');
    });

    // Add classes to navbar
    navbar.forEach((nav) => {
      nav.classList.add('bg-dark', 'text-white');
    });

    // Add classes to cards
    cards.forEach((card) => {
      card.classList.add('bg-dark', 'text-white');
    });

    // Add classes to card headers
    cardheaders.forEach((header) => {
      header.classList.add('bg-dark', 'text-white');
    });

    // Add classes to card bodies
    cardbodies.forEach((body) => {
      body.classList.add('bg-dark', 'text-white');
    });

    // Add classes to headings
    headings.forEach((heading) => {
      heading.classList.add('text-white');
    });

    // set light switch input to true
    if (!lightSwitch.checked) {
      lightSwitch.checked = true;
    }
    localStorage.setItem('lightSwitch', 'dark');
  }

  /**
   * @function lightmode
   * @summary: changes the theme to 'light mode' and save settings to local stroage.
   */
  function lightMode() {
    document.querySelectorAll('.bg-dark').forEach((element) => {
      element.className = element.className.replace(/-dark/g, '-light');
    });

    document.querySelectorAll('.text-white').forEach((element) => {
      element.className = element.className.replace(/text-white/, 'link-dark');
    });

    document.body.classList.add('bg-light');

    if (document.body.classList.contains('text-light')) {
      document.body.classList.replace('text-light', 'text-dark');
    } else {
      document.body.classList.add('text-dark');
    }

    // Tables
    var tables = document.querySelectorAll('table');
    for (var i = 0; i < tables.length; i++) {
      if (tables[i].classList.contains('table-dark')) {
        tables[i].classList.remove('table-dark');
      }
    }
    // cards
    var cards = document.querySelectorAll('.card');
    for (var i = 0; i < cards.length; i++) {
      if (cards[i].classList.contains('bg-dark')) {
        cards[i].classList.remove('bg-dark');
      }
    }

    if (lightSwitch.checked) {
      lightSwitch.checked = false;
    }
    localStorage.setItem('lightSwitch', 'light');
  }

  /**
   * @function onToggleMode
   * @summary: the event handler attached to the switch. calling @darkMode or @lightMode depending on the checked state.
   */
  function onToggleMode() {
    if (lightSwitch.checked) {
      darkMode();
    } else {
      lightMode();
    }
  }

  /**
   * @function getSystemDefaultTheme
   * @summary: get system default theme by media query
   */
  function getSystemDefaultTheme() {
    const darkThemeMq = window.matchMedia('(prefers-color-scheme: dark)');
    if (darkThemeMq.matches) {
      return 'dark';
    }
    return 'light';
  }

  function setup() {
    var settings = localStorage.getItem('lightSwitch');
    if (settings == null) {
      settings = getSystemDefaultTheme();
    }

    if (settings == 'dark') {
      lightSwitch.checked = true;
    }

    lightSwitch.addEventListener('change', onToggleMode);
    onToggleMode();
  }

  setup();
})();
