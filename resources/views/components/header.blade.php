<!-- resources/views/components/header.blade.php -->

<div class="header">
    <h1 class="title">Nombre de la Aplicación</h1>
    <div class="user-info">
        <span class="username">{{-- {{ Auth::user()->name }} --}}Luis FM</span> <!-- Descomenta esto -->
        <a href="{{-- {{ route('logout') }} --}}" class="logout-button">Cerrar sesión</a> <!-- Descomenta esto -->
    </div>
</div>