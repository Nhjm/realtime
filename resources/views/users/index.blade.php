@extends('layouts.app')

@section('content')
    <div class="container">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Thêm mới</button>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>IMAGE</th>
                    <th>EMAIL</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody">
                @foreach ($users as $item)
                    <tr id="id_{{ $item->id }}">
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td><img class="rounded-circle object-fit-cover" width="100px" height="100px"
                                src="{{ $item->image }}" alt=""></td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <button class="btn btn-danger btn_xoa" data-bs-toggle="modal" data-bs-target="#modal_destroy"
                                data-id="{{ $item->id }}">Xóa</button>
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal_edit"
                                data-id="{{ $item->id }}">Sửa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm mới</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form" action="{{ route('users.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input name="name" type="text" class="form-control" aria-describedby="nameHelp">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input name="image" type="text" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="add" type="button" class="btn btn-primary">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="modal_edit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal_edit">Edit</h1>
                        <button type="button" id="close_2" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form_update" action="" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="" id="id">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" name="name" type="text" class="form-control"
                                    aria-describedby="nameHelp">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input id="image" name="image" type="text" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="update" type="button" class="btn btn-primary">Sửa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal_destroy" tabindex="-1" aria-labelledby="modal_edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Xóa</h1>
                    <button type="button" id="close_2" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-footer">
                    <button type="button" id="close_modal_destroy" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button id="destroy" type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script type="module">
        const btn_add = document.getElementById('add')

        btn_add.addEventListener('click', (e) => {
            e.preventDefault()

            let form = document.getElementById('form')
            let dataForm = new FormData(form)
            console.log(dataForm);

            fetch(form.action, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: dataForm
                })
                .then(res => {
                    if (!res.ok) {
                        throw new error('lỗi mạng')
                    }
                    return res.json();
                })
                .then(data => {
                    console.log(data.success);
                    if (!data.success) {
                        console.log(Lỗi);
                    }
                    form.reset()
                    document.querySelector('.btn-close').click()
                })
                .catch(err => console.error(err))
        })

        const modal_edit = document.getElementById('modal_edit')
        // console.log(modal_edit);
        modal_edit.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const id = button.getAttribute('data-id')
            console.log(id);

            fetch('{{ route('users.edit') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Lỗi mạng')
                    }
                    return res.json();
                })
                .then(data => {
                    console.log(data);
                    document.getElementById('name').value = data.name
                    document.getElementById('email').value = data.email
                    document.getElementById('image').value = data.image
                    document.getElementById('id').value = data.id
                })
                .catch(err => console.error("lỗi", err))
        })

        const btn_update = document.getElementById('update')

        btn_update.addEventListener('click', (e) => {
            e.preventDefault()

            let form = document.getElementById('form_update')

            fetch("{{ route('users.update') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: document.getElementById('name').value,
                        email: document.getElementById('email').value,
                        image: document.getElementById('image').value,
                        id: document.getElementById('id').value,
                    })
                })
                .then(res => {
                    if (!res.ok) {
                        throw new error('lỗi mạng')
                    }
                    return res.json();
                })
                .then(data => {
                    console.log(data.success);
                    if (!data.success) {
                        console.log(Lỗi);
                    }
                    form.reset()
                    document.querySelector('#close_2').click()
                })
                .catch(err => console.error(err))
        })

        const modal_destroy = document.getElementById('modal_destroy')
        // console.log(modal_edit);
        var id_destroy
        modal_destroy.addEventListener('show.bs.modal', event => {
            let button = event.relatedTarget
            id_destroy = button.getAttribute('data-id')
            console.log(id_destroy);
        })

        document.getElementById('destroy').addEventListener('click', () => {
            fetch('{{ route('users.destroy') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id_destroy
                    })
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Lỗi mạng')
                    }
                    return res.json();
                })
                .then(data => {
                    console.log(data.success);
                    if (!data.success) {
                        console.log('Lỗi controller');
                    }
                    document.querySelector('#close_modal_destroy').click()
                })
                .catch(err => console.error("lỗi", err))
        })


        Echo.channel('users')
            .listen('UserCreated', event => {
                console.log(event);
                let html = `
                    <tr id='id_${event.user.id}'>
                        <td>${event.user.id}</td>
                        <td>${event.user.name}</td>
                        <td><img class="rounded-circle object-fit-cover" width="100px" height="100px" src="${event.user.image}"
                                alt=""></td>
                        <td>${event.user.email}</td>
                        <td>
                            <button class="btn btn-danger btn_xoa" data-bs-toggle="modal" data-bs-target="#modal_destroy"
                                 data-id="${event.user.id}">Xóa</button>
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal_edit"
                                data-id="${event.user.id}">Sửa</button>
                        </td>
                    </tr>`
                let tbody = document.querySelector('#tbody');
                tbody.insertAdjacentHTML('afterbegin', html);
            })
            .listen('UserUpdated', event => {
                console.log(event.user.id);
                let tr = document.querySelector(`#id_${event.user.id}`)
                console.log(tr);
                tr.innerHTML = `
                    <tr id='id_${event.user.id}'>
                        <td>${event.user.id}</td>
                        <td>${event.user.name}</td>
                        <td><img class="rounded-circle object-fit-cover" width="100px" height="100px" src="${event.user.image}"
                                alt=""></td>
                        <td>${event.user.email}</td>
                        <td>
                            <button class="btn btn-danger btn_xoa" data-bs-toggle="modal" data-bs-target="#modal_destroy"
                                 data-id="${event.user.id}">Xóa</button>
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal_edit"
                                data-id="${event.user.id}">Sửa</button>
                        </td>
                    </tr>`
            })
            .listen('UserDeleted', e => {
                document.querySelector(`#id_${e.user.id}`).remove()
            })
    </script>
@endsection
