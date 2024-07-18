@extends('layouts.app')

@section('content')
    <div class="container">
        @session('message')
            <div class="alert alert-success">
                <li>Tạo nhóm thành công</li>
            </div>
        @endsession
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tạo nhóm
        </button>

        <div class="row">
            <div class="col-md-6">
                <h1 class="text-center">Nhóm của bạn</h1>
                @foreach ($my_group_chats as $item)
                    <a href="{{ route('chat_group', $item->id) }}"><button class="btn btn-success">{{ $item->name }}
                        </button> </a>
                @endforeach
            </div>
            {{-- @dd($group_chats) --}}
            <div class="col-md-6">
                <h1 class="text-center">Bạn là thành viên</h1>
                @foreach ($group_chats as $item)
                    <a href="{{ route('chat_group', $item->GroupChat->id) }}"><button class="btn btn-success">{{ $item->GroupChat->name }}
                        </button> </a>
                @endforeach
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tạo nhóm</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('create_group_chat') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div>
                                <label for="" class="form-label">Tên nhóm</label>
                                <input class="form-control" type="text" name="name" id="">
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Trưởng nhóm</label>
                                <input class="form-control" type="text" value="{{ Auth::user()->name }}" disabled>
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Thành viên</label>
                                <select name="user_id[]" id="" class="form-control" multiple>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tạo nhóm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
