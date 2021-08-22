@extends('layouts.app')

@section('style')
<style>
    input, select {
        margin-bottom:40px;
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
                            <h1>Add New User</h1>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-danger float-right" href="{{ route('users.index') }}"> Cancel</a>
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
                    <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="text" class="form-control" name="images" hidden>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" name="phone"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-control select2" id="role" name="role" style="width: 100%;">
                                        <option value="Manager">Manager</option>
                                        <option value="Packer">Packer</option>
                                        <option value="Scanner">Scanner</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea class="form-control" name="note" rows="4" cols="50"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password"/>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
