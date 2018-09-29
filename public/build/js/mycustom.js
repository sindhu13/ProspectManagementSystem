$("#spk_unit").on("change", function () {
    let unitid = $(this).val();
    let colorid = $("#spk_color").val();
    let url = '/stocks/getChassis?unitid='+ unitid +'&colorid='+ colorid;
    let target = '#spk_stock';
    console.log(url);

    dynamicDropdown(target, unitid, colorid);
});

$("#spk_color").on("change", function () {
    let colorid = $(this).val();
    let unitid = $("#spk_unit").val();
    let url = '/stocks/getChassis?unitid='+ unitid +'&colorid='+ colorid;
    let target = '#spk_stock';
    console.log(url);

    dynamicDropdown(target, unitid, colorid);
});

$('#modaltest').off('click').on('click', function () {
    var token = $("input[name='_token']").val();
    let $select = $('.modal-body-prospect');
    let id = 3;
    $.ajax({
        url: "/prospects/show/",
        method: 'POST',
        data: {id:id, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

$('#salesPerLeasingSearchId').on('change', function(){
    var token = $("input[name='_token']").val();
    let branch_id = $('#salesPerLeasingSearchId').val();
    let year = $('#salesPerLeasingSearchYear').val();
    let $select = $('.x_content');
    $.ajax({
        url: "/sales/salesperleasingajax/",
        method: 'POST',
        data: {branch_id:branch_id, yearsearch:year, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

$('#salesPerLeasingSearchYear').on('change', function(){
    var token = $("input[name='_token']").val();
    let branch_id = $('#salesPerLeasingSearchId').val();
    let year = $('#salesPerLeasingSearchYear').val();
    let $select = $('.x_content');
    $.ajax({
        url: "/sales/salesperleasingajax/",
        method: 'POST',
        data: {branch_id:branch_id, yearsearch:year, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

$('#salesPerColorSearchId').on('change', function(){
    var token = $("input[name='_token']").val();
    let branch_id = $('#salesPerColorSearchId').val();
    let year = $('#salesPerColorSearchYear').val();
    let $select = $('.x_content');
    $.ajax({
        url: "/sales/salespercolorajax/",
        method: 'POST',
        data: {branch_id:branch_id, yearsearch:year, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

$('#salesPerColorSearchYear').on('change', function(){
    var token = $("input[name='_token']").val();
    let branch_id = $('#salesPerColorSearchId').val();
    let year = $('#salesPerColorSearchYear').val();
    let $select = $('.x_content');
    $.ajax({
        url: "/sales/salespercolorajax/",
        method: 'POST',
        data: {branch_id:branch_id, yearsearch:year, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

$('#salesPerModelSearchId').on('change', function(){
    var token = $("input[name='_token']").val();
    let branch_id = $('#salesPerModelSearchId').val();
    let year = $('#salesPerModelSearchYear').val();
    let $select = $('.x_content');
    $.ajax({
        url: "/sales/salespermodelajax/",
        method: 'POST',
        data: {branch_id:branch_id, yearsearch:year, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

$('#salesPerModelSearchYear').on('change', function(){
    var token = $("input[name='_token']").val();
    let branch_id = $('#salesPerModelSearchId').val();
    let year = $('#salesPerModelSearchYear').val();
    let $select = $('.x_content');
    $.ajax({
        url: "/sales/salespermodelajax/",
        method: 'POST',
        data: {branch_id:branch_id, yearsearch:year, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

$('#salesPerformanceSearchId').on('change', function(){
    var token = $("input[name='_token']").val();
    let branch_id = $('#salesPerformanceSearchId').val();
    let year = $('#salesPerformanceSearchYear').val();
    let $select = $('.x_content');
    $.ajax({
        url: "/sales/salesperformanceajax/",
        method: 'POST',
        data: {branch_id:branch_id, yearsearch:year, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

$('#salesPerformanceSearchYear').on('change', function(){
    var token = $("input[name='_token']").val();
    let branch_id = $('#salesPerformanceSearchId').val();
    let year = $('#salesPerformanceSearchYear').val();
    let $select = $('.x_content');
    $.ajax({
        url: "/sales/salesperformanceajax/",
        method: 'POST',
        data: {branch_id:branch_id, yearsearch:year, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

$('#salesActivitySearchId').on('change', function(){
    var token = $("input[name='_token']").val();
    let branch_id = $('#salesActivitySearchId').val();
    let year = $('#salesActivitySearchYear').val();
    let $select = $('.x_content');
    $.ajax({
        url: "/sales/salesactivityajax/",
        method: 'POST',
        data: {branch_id:branch_id, yearsearch:year, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

$('#salesActivitySearchYear').on('change', function(){
    var token = $("input[name='_token']").val();
    let branch_id = $('#salesActivitySearchId').val();
    let year = $('#salesActivitySearchYear').val();
    let $select = $('.x_content');
    $.ajax({
        url: "/sales/salesactivityajax/",
        method: 'POST',
        data: {branch_id:branch_id, yearsearch:year, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
});

function dynamicDropdown(selector, unitid, colorid){
    var token = $("input[name='_token']").val();
    let $select = $(selector);
    $.ajax({
        url: "/stocks/getChassis/",
        method: 'POST',
        data: {unitid:unitid, colorid:colorid, _token:token},
        success: function(data) {
            $select.html('');
            $select.html(data.options);
        }
    });
}
