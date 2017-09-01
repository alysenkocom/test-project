
$("#form-create-album").on("beforeSubmit",function(e) {
    e.preventDefault();

    var ajaxUrl = "/gallery/create";
    jQuery.ajax({
        url: ajaxUrl,
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            $("#modal-create-album").modal("hide");
            $.pjax.reload({container: "#ajax-body"});
        },
        error: function(response) {
            $("#modal-create-album").modal("hide");
        }
    });

    return false;
});
