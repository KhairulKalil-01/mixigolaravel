var themeprimary = localStorage.getItem("themeprimary") || '#1a7cbc';
var themesecondary = localStorage.getItem("themesecondary") || '#f07521';
var themesuccess = localStorage.getItem("themesuccess") || '#83C31B';
var themeinfo = localStorage.getItem("themeinfo") || '#18a0fb';
var themewarning = localStorage.getItem("themewarning") || '#FFC261';

window.Codexdmeki = {
	themeprimary: themeprimary,
	themesecondary: themesecondary,
	themesuccess: themesuccess,
	themeinfo: themeinfo,
	themewarning: themewarning,
};

// Theme Setting
var dark_mode 			= false;  // true | false
var sidebar_darkmode  	= false; // true | false
var sidebar_compact 	= false;  // true | false
var rtl_mode 			= false;  // true | false