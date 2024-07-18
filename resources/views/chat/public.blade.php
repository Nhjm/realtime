@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                {{-- @dd($user) --}}
                <div class="row">
                    @foreach ($user as $item)
                        <div class="col-md-12 mt-4">
                            <span style="position: absolute;" class="status d-none badge bg-success"
                                id="id_{{ $item->id }}">On</span>
                            <a href="{{ route('chat_private', $item->id) }}"
                                class="d-flex justify-content-start align-items-center">
                                <img class="rounded-circle object-fit-cover me-2" width="100px" height="100px"
                                    src="{{ $item->image }}" alt="">
                                <h4>{{ $item->name }}</h4>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-8 p-5">
                <div
                    class="p-4 chat w-100 h-25 border border-3 border-primary rounded-top border-bottom-0 overflow-y-scroll">
                </div>
                <div class="d-flex">
                    <input class="form-control" type="text" name="" id="input_chat">
                    <button id="btn_send" type="button" class="btn btn-success" type="submit">Gửi</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <a id="url" href="{{ route('send_message') }}" alt=""></a>
    <script>
        const url = document.getElementById('url').href;
        const id_user = "{{ Auth::user()->id }}"
    </script>
    @vite('resources/js/public.js')

    {{-- <script type="module">
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
                if (event.user.id == '{{ Auth::user()->id }}') {
                    message.classList.add('text-end')
                }
                chat.appendChild(message)
            })

        function send() {
            let message = input_chat.value.trim()

            if (message === '') {
                return
            }

            fetch('{{ route('send_message') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

        input_chat.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Ngăn chặn hành động mặc định của phím Enter
                console.log('gửi');
                send(); // Gọi hàm gửi tin nhắn khi nhấn Enter
            }
        });

        btn_send.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('gửi');
            send(); // Gọi hàm gửi tin nhắn khi nhấn nút "Gửi"
        });
    </script> --}}
@endsection
