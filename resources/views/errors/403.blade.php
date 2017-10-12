@extends('layouts.app')

@section('template_title')
	403 | Forbidden.
@endsection

@section('content')
	<div class="container">
		<div class="content">
			<div class="title">Forbidden.</div>
		</div>
	</div>

	<style>
		.title {
			font-size: 6em;
			margin-top: 10%;
			margin-bottom: 10%;
			text-align: center;
		}
	</style>
@endsection