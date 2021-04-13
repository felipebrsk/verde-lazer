@extends('backend.layouts.master')
@section('title', '| Centro de mensagens')

@section('content')
    <div class="card">
        <h5 class="card-header">Mensagem</h5>
        <div class="card-body">
            @if ($message)
                @if ($message->photo)
                    <img src="{{ $message->photo }}" class="rounded-circle " style="margin-left:44%;">
                @else
                    <img src="{{ asset('backend/img/avatar.png') }}" class="rounded-circle " style="margin-left:44%;">
                @endif
                <div class="py-4">From: <br>
                    Nome: {{ $message->name }}<br>
                    E-mail: {{ $message->email }}<br>
                    Telefone: {{ $message->phone }}
                </div>
                <hr />
                <h5 class="text-center" style="text-decoration:underline"><strong>Assunto: </strong>
                    {{ $message->subject }}
                </h5>
                <p class="py-5">{{ $message->message }}</p>
            @endif
        </div>
    </div>
@endsection
