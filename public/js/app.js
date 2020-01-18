$('#click-to-delete').click(e => {
    axios.put('/user/random_email')
        .then(res => {
            const data = res.data;

            if(data.success) {
                setEmail(data.data)
            }
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
});

$('#changeForm').submit(e => {
    e.preventDefault();
});

function setEmail(email)
{
    $('input#mail').val(email)
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
