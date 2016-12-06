/* Use this script if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'IcoMoon\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-home' : '&#x21;',
			'icon-user' : '&#x22;',
			'icon-locked' : '&#x23;',
			'icon-comments' : '&#x24;',
			'icon-comments-2' : '&#x25;',
			'icon-out' : '&#x26;',
			'icon-redo' : '&#x27;',
			'icon-undo' : '&#x28;',
			'icon-file-add' : '&#x29;',
			'icon-plus' : '&#x2a;',
			'icon-pencil' : '&#x2b;',
			'icon-pencil-2' : '&#x2c;',
			'icon-folder' : '&#x2d;',
			'icon-folder-2' : '&#x2e;',
			'icon-picture' : '&#x2f;',
			'icon-pictures' : '&#x30;',
			'icon-list-view' : '&#x31;',
			'icon-power-cord' : '&#x32;',
			'icon-cube' : '&#x33;',
			'icon-puzzle' : '&#x34;',
			'icon-flag' : '&#x35;',
			'icon-tools' : '&#x36;',
			'icon-cogs' : '&#x37;',
			'icon-cog' : '&#x38;',
			'icon-equalizer' : '&#x39;',
			'icon-wrench' : '&#x3a;',
			'icon-brush' : '&#x3b;',
			'icon-eye' : '&#x3c;',
			'icon-checkbox-unchecked' : '&#x3d;',
			'icon-checkbox' : '&#x3e;',
			'icon-checkbox-partial' : '&#x3f;',
			'icon-star' : '&#x40;',
			'icon-star-2' : '&#x41;',
			'icon-star-3' : '&#x42;',
			'icon-calendar' : '&#x43;',
			'icon-calendar-2' : '&#x44;',
			'icon-help' : '&#x45;',
			'icon-support' : '&#x46;',
			'icon-warning' : '&#x48;',
			'icon-checkmark' : '&#x47;',
			'icon-cancel' : '&#x4a;',
			'icon-minus' : '&#x4b;',
			'icon-remove' : '&#x4c;',
			'icon-mail' : '&#x4d;',
			'icon-mail-2' : '&#x4e;',
			'icon-drawer' : '&#x4f;',
			'icon-drawer-2' : '&#x50;',
			'icon-box-add' : '&#x51;',
			'icon-box-remove' : '&#x52;',
			'icon-search' : '&#x53;',
			'icon-filter' : '&#x54;',
			'icon-camera' : '&#x55;',
			'icon-play' : '&#x56;',
			'icon-music' : '&#x57;',
			'icon-grid-view' : '&#x58;',
			'icon-grid-view-2' : '&#x59;',
			'icon-menu' : '&#x5a;',
			'icon-thumbs-up' : '&#x5b;',
			'icon-thumbs-down' : '&#x5c;',
			'icon-cancel-2' : '&#x49;',
			'icon-plus-2' : '&#x5d;',
			'icon-minus-2' : '&#x5e;',
			'icon-key' : '&#x5f;',
			'icon-quote' : '&#x60;',
			'icon-quote-2' : '&#x61;',
			'icon-database' : '&#x62;',
			'icon-location' : '&#x63;',
			'icon-zoom-in' : '&#x64;',
			'icon-zoom-out' : '&#x65;',
			'icon-expand' : '&#x66;',
			'icon-contract' : '&#x67;',
			'icon-expand-2' : '&#x68;',
			'icon-contract-2' : '&#x69;',
			'icon-health' : '&#x6a;',
			'icon-wand' : '&#x6b;',
			'icon-refresh' : '&#x6c;',
			'icon-vcard' : '&#x6d;',
			'icon-clock' : '&#x6e;',
			'icon-compass' : '&#x6f;',
			'icon-address' : '&#x70;',
			'icon-feed' : '&#x71;',
			'icon-flag-2' : '&#x72;',
			'icon-pin' : '&#x73;',
			'icon-lamp' : '&#x74;',
			'icon-chart' : '&#x75;',
			'icon-bars' : '&#x76;',
			'icon-pie' : '&#x77;',
			'icon-dashboard' : '&#x78;',
			'icon-lightning' : '&#x79;',
			'icon-move' : '&#x7a;',
			'icon-next' : '&#x7b;',
			'icon-previous' : '&#x7c;',
			'icon-first' : '&#x7d;',
			'icon-last' : '&#xe000;',
			'icon-loop' : '&#xe001;',
			'icon-shuffle' : '&#xe002;',
			'icon-arrow-first' : '&#xe003;',
			'icon-arrow-last' : '&#xe004;',
			'icon-arrow-up' : '&#xe005;',
			'icon-arrow-right' : '&#xe006;',
			'icon-arrow-down' : '&#xe007;',
			'icon-arrow-left' : '&#xe008;',
			'icon-arrow-up-2' : '&#xe009;',
			'icon-arrow-right-2' : '&#xe00a;',
			'icon-arrow-down-2' : '&#xe00b;',
			'icon-arrow-left-2' : '&#xe00c;',
			'icon-play-2' : '&#xe00d;',
			'icon-menu-2' : '&#xe00e;',
			'icon-arrow-up-3' : '&#xe00f;',
			'icon-arrow-right-3' : '&#xe010;',
			'icon-arrow-down-3' : '&#xe011;',
			'icon-arrow-left-3' : '&#xe012;',
			'icon-printer' : '&#xe013;',
			'icon-color-palette' : '&#xe014;',
			'icon-camera-2' : '&#xe015;',
			'icon-file' : '&#xe016;',
			'icon-file-remove' : '&#xe017;',
			'icon-copy' : '&#xe018;',
			'icon-cart' : '&#xe019;',
			'icon-basket' : '&#xe01a;',
			'icon-broadcast' : '&#xe01b;',
			'icon-screen' : '&#xe01c;',
			'icon-tablet' : '&#xe01d;',
			'icon-mobile' : '&#xe01e;',
			'icon-users' : '&#xe01f;',
			'icon-briefcase' : '&#xe020;',
			'icon-download' : '&#xe021;',
			'icon-upload' : '&#xe022;',
			'icon-bookmark' : '&#xe023;',
			'icon-out-2' : '&#xe024;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; i < els.length; i += 1) {
		el = els[i];
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^s'"]+/);
		if (c) {
			addIcon(el, icons[c[0]]);
		}
	}
};