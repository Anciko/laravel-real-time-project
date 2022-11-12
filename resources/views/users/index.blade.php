@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('Real Time Notification') }}
                    </div>
                </div>


                <div class="card shadow my-3">
                    <div class="card-header">{{ __('User Lists') }}</div>
                    <ul id="users" class="mt-2">

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        window.axios.get('api/users')
            .then((response) => {
                console.log(response);
                let usersUl = document.querySelector('#users');
                let users = response.data;

                users.forEach((user, ind) => {
                    let userLi = document.createElement('li');
                    userLi.setAttribute('id', user.id);
                    userLi.innerText = user.name;

                    usersUl.appendChild(userLi);
                })
            });

        window.Echo.channel('users')
            .listen('UserCreated', (e) => {
                console.log(e);

                let usersUl = document.querySelector('#users');
                let userLi = document.createElement('li');
                userLi.setAttribute('id', e.user.id);
                userLi.innerText = e.user.name;

                usersUl.appendChild(userLi);
            })
            .listen('UserUpdated', (e) => {
                let userLi = document.getElementById(e.user.id)
                userLi.innerText = e.user.name;
            })
            .listen('UserDeleted', (e) => {
                let userLi = document.getElementById(e.user.id);
                userLi.parentNode.removeChild(userLi);
            })
    </script>
@endpush
