import './bootstrap';
window.$ = window.jQuery = require('jquery');

import $ from 'jquery';
window.$ = window.jQuery = $;


$('#my-table').DataTable({
    paging: true,
    searching: true,
    ordering: true,
    lengthChange: true,
    pageLength: 10
});


