@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
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
                                    <th>
                                        Zeit
                                    </th>
                                </tr>
                                @section('dynamicRanking')
                                    @for($i = 0; $i < $userRank; ++$i)
                                        @php
                                            $j = $i;
                                        @endphp
                                        <tr>
                                            @if(isset($rankArray[$i]['rank']))
                                                <td>{{$rankArray[$i]['rank']}}</td>
                                            @else
                                                <td>{{ ++$j }}</td>
                                            @endif
                                                <td>{{ $rankArray[$i]['first_name'] }}</td>
                                                <td>{{ $rankArray[$i]['scoutname'] }}</td>
                                                <td>{{ $rankArray[$i]['last_name'] }}</td>
                                                <td>{{ $rankArray[$i]['total_points'] }}</td>
                                                @if(isset($rankArray[$i]['end']))
                                                    @php
                                                        $start = \Carbon\Carbon::parse($rankArray[$i]['start']);
                                                        $end = \Carbon\Carbon::parse($rankArray[$i]['end']);
                                                    @endphp
                                                    <td>{{$end->diff($start)->format("%H Stunden, %I Minuten, %S Sekunden")}}</td>
                                                @else
                                                    @php
                                                        $start = \Carbon\Carbon::parse($rankArray[$i]['start']);
                                                        $now = \Carbon\Carbon::now();
                                                    @endphp

                                                    <td>{{$now->diff($start)->format('%H Stunden %I Minuten %S Sekunden')}}</td>
                                                @endif
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
