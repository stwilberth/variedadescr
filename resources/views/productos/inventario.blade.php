@extends('layouts.app')
@section('content')
<div class="container"> 
<panel-admin slug-data=""></panel-admin>
<inven-comp productos-data="{{json_encode($productos)}}"></inven-comp>

</div>
@endsection