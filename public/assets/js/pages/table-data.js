$(document).ready(function() {

    //editables
    $.fn.editable.defaults.mode = 'inline';
    $('#table td a').editable({
        url: '/post',
        type: 'text',
        pk: 1,
        name: 'username',
        title: 'Enter username'
    });

    var tbl = $('#table').DataTable({
        bProcessing: true,
        serverSide: true,
        ajax: {
            url: "/grid/raw-materials",
            type: "post"
        },

        columns: [
            { "data": "code" },
            { "data": "item" },
            { "data": "category" },
            { "data": "price" },
            { "data": "type" },
            { "data": "vat" }
        ],
        columnDefs: [

        ]
    });

});