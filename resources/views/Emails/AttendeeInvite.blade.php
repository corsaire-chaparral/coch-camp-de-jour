@extends('en.Emails.Layouts.Master')

@section('message_content')
Bonjour {{$attendee->first_name}},<br><br>

Vous avez été invité(e) à l’événement suivant : <b>{{$attendee->order->event->title}}</b>.<br/>

<br><br>
Merci,
<br><br>

<em>L’équipe du Corsaire-Chaparral</em>
@stop
