@extends('layouts.app')

@section('content')
    @livewire('chat.chat-room', ['conversation' => $conversation])
@endsection
