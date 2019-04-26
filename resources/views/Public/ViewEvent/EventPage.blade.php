@extends('Public.ViewEvent.Layouts.EventPage')

@section('content')
    @include('Public.ViewEvent.Partials.EventHeaderSection')
    @include('Public.ViewEvent.Partials.EventTicketsSection')
    {{-- Hide Description --}}
    {{-- @include('Public.ViewEvent.Partials.EventDescriptionSection') --}}
    {{-- Hide Share --}}
    {{-- @include('Public.ViewEvent.Partials.EventShareSection') --}}
    {{-- Hide Map --}}
    {{-- @include('Public.ViewEvent.Partials.EventMapSection') --}}
    @include('Public.ViewEvent.Partials.EventOrganiserSection')
    @include('Public.ViewEvent.Partials.EventFooterSection')
@stop

