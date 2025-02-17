$(document).ready(function() {
    $(".menu-link").click(function(e) {
        e.preventDefault();
        var page = $(this).data("page");

        // Load selected page dynamically
        $("#dynamic-content").load(page);
    });
});
