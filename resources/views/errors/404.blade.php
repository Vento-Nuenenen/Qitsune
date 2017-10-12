@extends('layouts.app')

@section('template_title')
	404 | Not found.
@endsection

@section('content')
	<div class="container">
		<div class="content">
			<div class="title">Error 404</div>
			<div class="title">Not found.</div>
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