import './bootstrap';
import $ from 'jquery';
import dt from 'datatables.net-bs5';

window.$ = window.jQuery = $;
dt(window, $); // init DataTables with Bootstrap 5