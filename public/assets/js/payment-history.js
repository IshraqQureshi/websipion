"use strict";
$(function () {

    var url = $('#PayhistoryTable').attr('data-URL');
    var dataTable = $('#PayhistoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        searching: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'userID', name: 'userID' },
            { data: 'InvoiceNumber', name: 'InvoiceNumber' },
            { data: 'packagesID', name: 'packagesID' },
            { data: 'transactionID', name: 'transactionID' },
            { data: 'totalPayment', name: 'totalPayment' },
            { data: 'paymentMode', name: 'paymentMode' },
            { data: 'transactionTime', name: 'transactionTime' },
            { data: 'action', name: 'action', className: 'action text-end' },
        ]
});

$('#PayhistoryTable_filter').hide();

$('#PayhistorySearch').on('keyup', function () {
    dataTable.search(this.value).draw();
});

});