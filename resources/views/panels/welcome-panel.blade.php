@php
    $levelAmount = 'level';

    if (Auth::User()->level() >= 2) {
        $levelAmount = 'levels';
    }
@endphp

<div class="panel panel-primary @role('admin', true) panel-info  @endrole">
    <div class="panel-heading">
        Welcome {{ Auth::user()->name }}
    </div>
    <div class="panel-body">
        Test
    </div>
</div>
