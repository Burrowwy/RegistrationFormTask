$(document).ready(function(){
    $('#registrationForm').submit(function(e){
        e.preventDefault(); 
        // Валидация на стороне клиента
        var email = $('#email').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirmPassword').val();

        if (email.indexOf('@') === -1) {
            $('#registrationError').text('Email должен содержать @');
        } else if (password !== confirmPassword) {
            $('#registrationError').text('Пароли не совпадают');
        } else {
            // Отправка формы при помощи AJAX
            $.ajax({
                type: 'POST',
                url: 'registrationController.php',
                data: $('#registrationForm').serialize(),
                success: function(response){
                    $message = JSON.parse(response);

                    if($message.userExists){
                        $('#registrationError').text($message.message);
                    }else{
                        $('#registrationResult').text($message.message);
                        document.getElementById('form-container').style.display = 'none';
                    }       
                }
            });
            
        }
    });
});