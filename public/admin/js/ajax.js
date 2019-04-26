function sendMail(action) {
    $.ajax({
        method : 'POST',
        url : action,
        data : {
            email: action === '/sendFast' ? document.getElementById('fast').value : document.getElementById('full').value,
            name: document.getElementById('name').value,
            phone: document.getElementById('phone').value
        },
        success: function (res) {
            alert('Ваше сообщение отправлено '+res.mail);
        }
    })
}
$(document).ready(function () {
   $('#sendFast').click(function () {
       sendMail('/sendFast')
   });
    $('#send').click(function () {
        sendMail('/send')
    });
});