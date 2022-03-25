@extends('Public.ViewEvent.Layouts.EmbeddedEventPage')

@section('content')
    @include('Public.ViewEvent.Partials.EventTicketsSection')
@stop

@section('page-footer')
    @include('Public.ViewEvent.Embedded.Partials.PoweredByEmbedded')
@stop
