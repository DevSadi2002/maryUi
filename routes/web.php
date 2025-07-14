<?php

use App\Livewire\UserList;
use App\Livewire\UserPage;
use Illuminate\Support\Facades\Route;

use Livewire\Volt\Volt;

Volt::route('/', 'users.index');

Route::get('/users/create', UserPage::class)->name('users.create');
Route::get('/users', UserList::class)->name('users');
