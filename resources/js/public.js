
const input_chat = document.getElementById('input_chat')
const btn_send = document.getElementById('btn_send')

input_chat.focus();

Echo.join('chat')
    .here(users => {
        //khi mình vào trong kênh chat
        //sẽ trả lại các toàn bộ users đang ở trong kênh chat
        console.log(users, 'here');
        users.forEach(item => {
            document.getElementById(`id_${item.id}`)?.classList.remove('d-none')
            console.log(document.getElementById(`id_${item.id}`))
            // let user_online = document.getElementById(`id_${item.id}`)
            // if (user_online) user_online.classList.remove('d-none')
        });
    }).joining(user => {
        //mình đang trong kênh chat
        //trả lại thông tin user khi có người mới truy cập vào chát
        console.log(user, 'join');
        document.getElementById(`id_${user.id}`)?.classList.remove('d-none')
    }).leaving(user => {
        //mình đang trong kênh chat
        //trả lại thông tin user khi có người mới truy cập thoát chát
        console.log(user, 'leave');
        document.getElementById(`id_${user.id}`)?.classList.add('d-none')

    }).listen('UserOnlined', event => {
        console.log(event);
        let chat = document.querySelector('.chat')
        let message = document.createElement('p')
        message.textContent = `${event.user.name}: ${event.message}`
        if (event.user.id == id_user) {
            message.classList.add('text-end')
        }
        chat.appendChild(message)
    })

function send() {
    let message = input_chat.value.trim()

    if (message === '') {
        return
    }

    // fetch('{{ route('send_message') }}', {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            message: message
        })
    })
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(data => {
            console.log(data);
            input_chat.value = ''
            input_chat.focus()
        })
        .catch(err => console.error('Fetch Error:', err))

}

input_chat.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault(); // Ngăn chặn hành động mặc định của phím Enter
        console.log('gửi');
        send(); // Gọi hàm gửi tin nhắn khi nhấn Enter
    }
});

btn_send.addEventListener('click', function (e) {
    e.preventDefault();
    console.log('gửi');
    send(); // Gọi hàm gửi tin nhắn khi nhấn nút "Gửi"
});
