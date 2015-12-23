$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$(":input").bind('keyup mouseup', function () {
    alert("changed");
});​