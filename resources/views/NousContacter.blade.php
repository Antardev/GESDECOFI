@extends('welcome')
@section('content')
<div class="hero-section" style="position: relative; text-align: center; height: calc(100vh - 60px); overflow: hidden;">
    <img src="{{ asset('assets/img/1.png') }}" alt="Bienvenue" style="width: 100%; height: 100%; max-height: 600px; object-fit: cover;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; background-color: rgba(0, 0, 0, 0.7); padding: 30px; border-radius: 10px;">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color:blanchedalmond;">{{__('message.contact_us')}}</h1>
        <p style="font-size: 1.2rem; color: #bebcbc;">{{__('message.for_any_question_contact')}}</p>
        <form action="" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">{{__('message.email')}}</label>
                @if (auth()->check())
                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" readonly>
                    @else
                    <input type="email" class="form-control" id="email" name="email" placeholder="{{__('message.enter_your_mail')}}" required>
                @endif
        
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">{{__('message.Message')}}</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{__('message.send')}}</button>
    </div>
@endsection