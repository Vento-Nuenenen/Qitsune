@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Rangliste</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="rank table-responsive">
                        <h1>Aktuelle Rangliste:</h1>
                        <table class="table table-hover table-responsive">
                            <tr>
                                <th>
                                    Rang
                                </th>
                                <th>
                                    Vorname
                                </th>
                                <th>
                                    Pfadiname
                                </th>
                                <th>
                                    Nachname
                                </th>
                                <th>
                                    Punkte
                                </th>
                            </tr>
                            @section('dynamicRanking')
                                @for($i = 0; $i < $userRank; ++$i)
                                    @php ($j = $i)
                                    <tr>
                                        <td>{{ ++$j }}</td>
                                        <td>{{ $rankArray[$i]['prename'] }}</td>
                                        <td>{{ $rankArray[$i]['scoutname'] }}</td>
                                        <td>{{ $rankArray[$i]['surname'] }}
                                        <td>{{ $rankArray[$i]['rank'] }}</td>
                                    </tr>
                                @endfor
                            @show
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	setInterval(function(){ updateRanking(); }, 20000);

	function updateRanking(){
		$.ajax({
			url: '/ajax/ranking',
			type: 'get',
			success: function(data) {
				console.log('Reload suceed!');
			}
		});
	}
</script>
@endsection
