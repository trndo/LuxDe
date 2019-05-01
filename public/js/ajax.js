let formValidFast = false;
let formValid = {
    full: false,
    phone: false,
    name: false
};

function sendMail(action) {
    $('#preloader').show();
    $.ajax({
        method : 'POST',
        url : action,
        data : {
            email: action === '/sendFast' ? document.getElementById('fast').value : document.getElementById('full').value,
            name: document.getElementById('name').value,
            phone: document.getElementById('phone').value
        },
        error: function(error){
            alert('Уппс..Что-то пошло не так.Порпробуйте позже.');
        },
        success: function (res) {
            $('#preloader').hide();
            alert('Ваше сообщение отправлено '+res.mail);
        }
    })
}
$(document).ready(function () {
   $('#phone').mask('+38(000)000-00-00', {placeholder: "+38(___)___-__-__"});
   $('#sendFast').click(function () {
       if (formValidFast) {
           sendMail('/sendFast');
           $('#fast').val('');
       }
   });
    $('#send').click(function () {
        if (formValid.name && formValid.phone && formValid.full) {
            sendMail('/send')
            $('#name').val('');
            $('#phone').val('');
            $('#full').val('');
        }
    });
    $('#fast').blur(function () {
        let email = $(this).val();

        if (!/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/.test(email)){
            $(this).addClass('invalid');
            $('.emailFast').css('display','block');
        } else {
            $(this).removeClass('invalid');
            $('.emailFast').css('display','none');
            formValidFast = true;
        }
    });
    $('#name').blur(function () {
        let name = $(this).val();

        if (!name){
            $(this).addClass('invalid');
            $('#invName').css('display','block');
        } else {
            $(this).removeClass('invalid');
            $('#invName').css('display','none');
            formValid.name = true;
        }
    });
    $('#phone').blur(function () {
        let phone = $(this).val();

        if (!phone){
            $(this).addClass('invalid');
            $('#invPhone').css('display','block');
        } else {
            $(this).removeClass('invalid');
            $('#invPhone').css('display','none');
            formValid.phone = true;
        }
    });
    $('#full').blur(function () {
        let full = $(this).val();

        if (!/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/.test(full)){
            $(this).addClass('invalid');
            $('#invEmail').css('display','block');
        } else {
            $(this).removeClass('invalid');
            $('#invEmail').css('display','none');
            formValid.full = true;
        }
    });
});
