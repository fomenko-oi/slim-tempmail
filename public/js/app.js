const socket = io.connect(window.websocketUrl);
let userMail = window.userMail;
let isOldTitle = true;
let oldTitle = document.title;
let interval = null;

socket.on('connect', function () {
    console.log(`email.${userMail}`);

    socket.on(`email.${userMail}`, data => {
        console.log(data);
        $('#click-to-refresh').click();
    });
});

$('#click-to-delete').click(e => {
    axios.put('/user/random_email')
        .then(res => {
            const data = res.data;

            if(data.success) {
                setEmail(data.data);
                $('#click-to-refresh').click();
            }
        })
});

$('a.deleteMail').click(e => {
    e.preventDefault();
    const $el = $(e.target).closest('a.deleteMail');

    axios.delete(`${$el.attr('href')}`)
        .then(res => {
            const data = res.data;

            if(data.success) {
                window.history.back();
            }
        })
        .catch(err => {
            alert(err.response.data.message)
        })
});

$('#click-to-refresh').click(e => {
    e.preventDefault();

    axios.post('/user/messages')
        .then(res => {
            const data = res.data;

            if(data.success) {
                showLoader();

                const mailList = $('.maillist');
                const dataList = mailList.find('.inbox-dataList');
                const inboxEmpty = mailList.find('.inbox-empty');

                titleBlink(`${data.count} писем в почтовом ящике`);

                console.log(`${data.count} писем в почтовом ящике`)

                if(data.count > 0) {
                    dataList.html(data.html);
                    dataList.removeClass('hide');
                    inboxEmpty.addClass('hide');
                } else {
                    inboxEmpty.removeClass('hide');
                    dataList.addClass('hide');
                }
            }
        })
});

$('#new_mail').change(e => {
    e.preventDefault();

    const host = $('#domain').val();
    const login = $('#new_mail').val();

    axios.put('/user/set_email', {host, login })
        .then(res => {
            const data = res.data;

            if(data.success) {
                setEmail(`${login}@${host}`);
                showLoader();
                $('#new_mail').val(null);
                $(document).scrollTop(0);
            }
        })
        .catch(err => {
            alert(err.response.data.message)
        })
});

$('#changeForm').submit(e => {
    e.preventDefault();
});

function setEmail(email)
{
    socket.off(`email.${userMail}`);

    $('input#mail').val(email);

    userMail = email.replace('@', '.');

    socket.on(`email.${userMail}`, data => {
        $('#click-to-refresh').click();
    });
}

function showLoader()
{
    const progress = $('#progress');
    const loader = $('#loader');
    loader.show();
    let i = 0;

    let interval = setInterval(() => {
        i++;

        if(i >= 100) {
            clearInterval(interval);
            progress.css('width', 100 + '%');
            progress.css('width', 0 + '%');
            loader.hide();
            return;
        }

        progress.css('width', i + '%');
    }, 5)
}

function titleBlink(newTitle, delay = 700) {
    if(interval) {
        clearInterval(interval);
    }
    interval = setInterval(() => {
        document.title = isOldTitle ? oldTitle : newTitle;
        isOldTitle = !isOldTitle;
    }, delay);
}

$(window).focus(function () {
    clearInterval(interval);
    $('title').text(oldTitle);
});
