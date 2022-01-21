$(document).ready(function() {
    $('#submit_profile_post').click(function() {

        $.ajax({
            type: "POST",
            url: "include/submit_profile.php",
            data: $('form.profile_post').serialize(),
            success: function(msg) {
                $("#post_form").modal('hide');
                location.reload();
            },
            error: function() {
                alert('Failure');
            }
        });

    });
});