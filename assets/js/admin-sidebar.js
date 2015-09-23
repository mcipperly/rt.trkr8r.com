function respMenu(window, document) {

    var wrap = document.getElementById('admin-wrap'),
        sidebar = document.getElementById('admin-sidebar'),
        toggleMenu = document.getElementById('toggle-menu');

    function toggleClass(element, className) {
        var classes = element.className.split(/\s+/),
            length = classes.length,
            i = 0;

        for(; i < length; i++) {
          if (classes[i] === className) {
            classes.splice(i, 1);
            break;
          }
        }
        // The className is not found
        if (length === classes.length) {
            classes.push(className);
        }

        element.className = classes.join(' ');
    }

    toggleMenu.onclick = function (e) {
        var active = 'active';

        e.preventDefault();
        toggleClass(wrap, active);
        toggleClass(sidebar, active);
        toggleClass(toggleMenu, active);
    };

};