<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
<<<<<<< HEAD
=======

Broadcast::channel('App.User.{role}', function ($user, $role) {
    return (int) $user->role === (int) $role;
});
>>>>>>> fd930b6d1b0828fd3371a8ae67e1f189ab314e01
