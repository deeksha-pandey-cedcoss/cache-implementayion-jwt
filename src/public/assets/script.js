$(document).ready(function () {

});

$("#component").on('change', function () {

    let option = this.value;
    $.ajax({
        url: "abc/assets1",
        type: "POST",
        datatype: "json",
        data: { "data": option },
        success: function (result) {
            $("#actionn").html(result);
        }

    })


})
