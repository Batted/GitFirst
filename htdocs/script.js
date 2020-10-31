function valid (form){
    var fail = false;
    var login = form.login.value;
    var password = form.password.value;
    var RePassword = form.RePassword.value;
    var email = form.email.value;
    var adr_pattern = /[0-9a-z_-]+@[0-9a-z_-]+\.[a-z]{2,5}$/i;

    if (login == "" || login == " ")
        fail = "Логин не введен";
    else if (password == "" || password == " ")
        fail = "Пароль не введен";
    else if (password != RePassword)
        fail = "Пароли не совпадают";
    else if (adr_pattern.test(email) == false)
        fail = "Email введен неправильно";


    if (fail)
    alert (fail);

    else
        window.location ="http://google.com";
}

function valids (authform){
    var fail = false;
    var login = authform.login.value;
    var password = authform.password.value;

    if (login == "" || login == " ")
        fail = "Логин не введен";
    else if (password == "")
        fail = "Пароль не введен";


    if (fail)
    alert (fail);

    else
        window.location ="http://google.com";
}


function validfeedback (feedback){
    var fail = false;
    var subject = feedback.subject.value;
    var email = feedback.email.value;
    var adr_pattern = /[0-9a-z_-]+@[0-9a-z_-]+\.[a-z]{2,5}$/i;
    var name = feedback.name.value;
    var message = feedback.message.value;

    if (subject == "" || subject == " ")
        fail = "Тема не введена";
    else if (adr_pattern.test(email) == false)
        fail ="Email введен неправильно";
    else if (name == "" || name == " ")
        fail ="Имя не введено";
    else if (message == "" || message == " ")
        fail ="Введите сообщение";

    if (fail)
    alert (fail);

    else
        window.location ="http://google.com";

}