/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    $("form").submit(function () {
        $.ajax({
            dataType: "json",
            url: $("form").attr("action"),
            data: $('form').serialize(),
            async: true,
            method: $("form").attr("method"),
            success: function (json) {
                if (json.error) {
                    alert("Ошибка" + json.error)
                } else {
                    $("div#result").html(json.amount);
                }

            },
            error: function (xhr, status, error) {
                alert(status);
            }
        });
        return false;
    });

    $("#crossdomainButton").click(function () {
        $.ajax({
            type: "POST",
            crossDomain: true,
            dataType: "jsonp",
            url: "http://localhost:8888" + $("form").attr("action"),
            data: $('form').serialize(),
            async: true,
            success: function (json) {
                if (json.error) {
                    alert("Ошибка" + json.error)
                } else {
                    $("div#result").html(json.amount);
                }

            },
            error: function (xhr, status, error) {
                alert(status);
            }
        });
        return false;
    });

});