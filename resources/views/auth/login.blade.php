@extends('templates.base')
@section('title', 'Login')
@section('content')
  <section class="container my-12">
    <form action="{{ route('login') }}" method="post">
      @csrf
      <input type="email" name="email" id="email" placeholder="email">
      <input type="password" name="password" id="password" placeholder="password">
      <button type="submit">Login</button>
    </form>
  </section>
@endsection