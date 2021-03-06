<script>
//    $(document).ready(function () {
//        var panels = $('.user-infos');
//        var panelsButton = $('.dropdown-user');
//        panels.hide();
//
//        //Click dropdown
//        panelsButton.click(function () {
//            //get data-for attribute
//            var dataFor = $(this).attr('data-for');
//            var idFor = $(dataFor);
//
//            //current button
//            var currentButton = $(this);
//            idFor.slideToggle(400, function () {
//                //Completed slidetoggle
//                if (idFor.is(':visible'))
//                {
//                    currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
//                }
//                else
//                {
//                    currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
//                }
//            })
//        });
//
//
//        $('[data-toggle="tooltip"]').tooltip();
//
//        $('button').click(function (e) {
//            e.preventDefault();
//            alert("This is a demo.\n :-)");
//        });
//    });

    $(function () {

        $('#open-modalEdit').click(function (e) {
            $('#modalEdit').modal('show');
        });

        $('#formUserChangePassword').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: $("#src").val() + '/controllers/user/user_controller.php',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function (result) {
                elem = jQuery.parseJSON(result);
                showAlertGeneral(elem.title, elem.msg, elem.type);

                if (elem.type == 'success') {
                    $('#modalEdit').modal('hide');
                    setTimeout(function () {
                        showLoginScreen($("#src").val());
                    }, 2000);
                }

            });

        });

        $('#formNames').submit(function (e) {  
            e.preventDefault();
            $.ajax({
                url: $("#src").val() + '/controllers/user/user_controller.php',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false
            }).done(function (response) { 
                console.log(response); 
                elemt = JSON.parse(response);
                showAlertGeneral(elemt.title, elemt.msg, elemt.type);

                if(elemt.type == 'success'){
                    $('#modalEdit').modal('hide');
                }
            });
        });

    });

    function check_change_passwords(){
        if ($('#new_password').val().trim() == '' || $('#new_check_password').val().trim() == '' || $('#old_password').val().trim() == '') {
            showAlertGeneral("Erro", "Preencha os campos corretamente.", "error");
            return false;
        } 
        else {
            if ($('#new_password').val() === $('#new_check_password').val()) {
                $('#formUserChangePassword').submit();
                return true;
            }
            else {
                showAlertGeneral("Error", "Passwords do not match!", "error");
                return false;
            }
        }
    }

    function check_change_names(){
        if($("#new-first-name").val() != '' || $('#new-last-name').val() != '' || $('#new-email').val() != ''){
            $('#formNames').submit();
            return true;
        }
        else{
            showAlertGeneral("Error", "Please, fill in at least one field", "error");
            return false;
        }
    }
</script>
