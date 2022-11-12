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

                        <a href="{{ route('users.index') }}">Show Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        Echo.private('notifications') // channel name in the event
            .listen('UserSessionChanged', (e) => {
                console.log(e);
                const notificationElement = document.getElementById('notification');
                notificationElement.innerText = e.message;

                notificationElement.classList.remove('invisible');
                notificationElement.classList.remove('alert-success');
                notificationElement.classList.remove('alert-danger');

                notificationElement.classList.add('alert-' + e.type);
            });
    </script>
@endpush
