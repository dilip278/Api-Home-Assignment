@extends('layouts.app')

@section('style')
<style>
    input, select {
        margin-bottom:40px;
    }
    .btn {
        margin:10px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <!-- Title -->
                <div class="card-header col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>Edit User: {{$user->name}}</h1>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                <a class="btn btn-primary float-right" href="{{ route('users.index') }}"> Cancel</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger float-right" onclick="return confirm('Are you sure?')" class="dropdown-item">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="text" class="form-control" name="images" hidden>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{$user->email}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" name="phone"  value="{{$user->phone}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-control select2" id="role" name="role" style="width: 100%;">
                                        <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : ''}}>Admin</option>
                                        <option value="Manager" {{ $user->role == 'Manager' ? 'selected' : ''}}>Manager</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password <i>Leave as is if no change</i></label>
                                    <input type="password" class="form-control" name="password" value="{{$user->password}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password <i>Leave as is if no change</i></label>
                                    <input type="password" class="form-control" name="confirm_password" value="{{$user->password}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_disabled">Disable User</label>
                                    <select class="form-control select2" id="is_disabled" name="is_disabled" style="width: 100%;">
                                        <option value="1" {{ $user->is_disabled? 'selected' : ''}}>Yes</option>
                                        <option value="0" {{ !$user->is_disabled? 'selected' : ''}}>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
