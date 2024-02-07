"use strict";
$(function () {
    var name = $('.domainGet').text();
    var url = $('#CrawlDetailsTable').attr('data-URL') + '?name=' + name.trim();
    var dataTable = $('#CrawlDetailsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        searching: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'websiteID', name: 'websiteID' },
            { data: 'frequency', name: 'frequency' },
            { data: 'crawlTime', name: 'crawlTime' },
            { data: 'status', name: 'status' },
        ]
    });

    $('#CrawlDetailsTable_filter').hide();


    $('#CrawlDetailsSearch').on('keyup', function () {
        dataTable.search(this.value).draw();
    });


});