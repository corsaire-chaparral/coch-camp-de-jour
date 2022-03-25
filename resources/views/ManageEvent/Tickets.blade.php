@extends('Shared.Layouts.Master')

@section('title')
    @parent
    @lang("Ticket.event_tickets")
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('page_title')
    <i class="ico-ticket mr5"></i>
    @lang("Ticket.event_tickets")
@stop

@section('head')
    <script>
        $(function () {
            $('.sortable').sortable({
                handle: '.sortHandle',
                forcePlaceholderSize: true,
                placeholderClass: 'col-md-4 col-sm-6 col-xs-12',
            }).bind('sortupdate', function (e, ui) {

                var data = $('.sortable .ticket').map(function () {
                    return $(this).data('ticket-id');
                }).get();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('postUpdateTicketsOrder' ,['event_id' => $event->id]) }}',
                    dataType: 'json',
                    data: {ticket_ids: data},
                    success: function (data) {
                        showMessage(data.message);
                    },
                    error: function (data) {
                        showMessage(lang("whoops2"));
                    }
                });
            });
        });
    </script>
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_header')
    <div class="col-md-9">
        <!-- Toolbar -->
        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group btn-group-responsive">
                <button data-modal-id='CreateTicket'
                        data-href="{{route('showCreateTicket', array('event_id'=>$event->id))}}"
                        class='loadModal btn btn-primary' type="button"><i class="ico-ticket"></i> @lang("Ticket.create_ticket")
                </button>
            </div>
            @if(false)
                <div class="btn-group btn-group-responsive ">
                    <button data-modal-id='TicketQuestions'
                            data-href="{{route('showTicketQuestions', array('event_id'=>$event->id))}}" type="button"
                            class="loadModal btn btn-primary">
                        <i class="ico-question"></i> @lang("Ticket.questions")
                    </button>
                </div>
                <div class="btn-group btn-group-responsive">
                    <button type="button" class="btn btn-primary">
                        <i class="ico-tags"></i> @lang("Ticket.coupon_codes")
                    </button>
                </div>
            @endif
        </div>
        <!--/ Toolbar -->
    </div>
    <div class="col-md-3">
        {!! Form::open(array('url' => route('showEventTickets', ['event_id'=>$event->id,'sort_by'=>$sort_by]), 'method' => 'get')) !!}
        <div class="input-group">
            <input name='q' value="{{$q or ''}}" placeholder="@lang("Ticket.search_tickets")" type="text" class="form-control">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
            {!!Form::hidden('sort_by', $sort_by)!!}
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('content')
    @if($tickets->count())
        <div class="row">
            <div class="col-md-3 col-xs-6">
                <div class='order_options'>
                    <span class="event_count">@lang("Ticket.n_tickets", ["num"=>$tickets->count()])</span>
                </div>
            </div>
            <div class="col-md-2 col-xs-6 col-md-offset-7">
                <div class='order_options'>
                    {!! Form::select('sort_by_select', $allowed_sorts, $sort_by, ['class' => 'form-control pull right']) !!}
                </div>
            </div>
        </div>
    @endif
    <!--Start ticket table-->
    <div class="row sortable">
        @if($tickets->count())

            @foreach($tickets as $ticket)
                <div id="ticket_{{$ticket->id}}" class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="panel panel-default ticket" data-ticket-id="{{$ticket->id}}">
                        <div class="panel-heading">

                            <h3 class="panel-title ellipsis">
                                <i class="ico-ticket ticket_icon mr5 ellipsis"></i>
                                {{$ticket->title}}
                            </h3>

                            <div class="sortHandle" title="@lang("basic.drag_to_reorder")">
                                <i class="ico-paragraph-justify"></i>
                            </div>
                        </div>
                        <div class='panel-body'>

                            <section class="ticket-meta">
                                {{ ($ticket->is_free) ? trans("Order.free") : money($ticket->price, $event->currency) }}

                                @if($ticket->is_hidden)
                                    <span class="muted" style="opacity: .35; pointer-events: none; margin: 0 .5rem;">|</span>
                                    <i title="@lang("Ticket.this_ticket_is_hidden")"
                                       class="ico-eye-blocked"></i>
                                @endif

                                <span class="muted" style="opacity: .35; pointer-events: none; margin: 0 .5rem;">|</span>

                                @if($ticket->sale_status === config('attendize.ticket_status_on_sale'))
                                    @if($ticket->is_paused)
                                        <span class="label label-warning">
                                            <i class="ico-warning"></i>
                                            @lang("Ticket.ticket_sales_paused")
                                        </span>
                                    @else
                                        <span class="label label-success">
                                            @lang("Ticket.on_sale")
                                        </span>
                                    @endif
                                @elseif($ticket->sale_status === config('attendize.ticket_status_after_sale_date'))
                                    <span class="label label-default">
                                        <i class="ico-clock"></i>
                                        @lang("Public_ViewEvent.sales_have_ended")
                                    </span>
                                @else
                                    <span class="label label-default">
                                        {{\App\Models\TicketStatus::find($ticket->sale_status)->name}}
                                    </span>
                                @endif
                            </section>

                            <ul class="nav nav-section nav-justified mt10 mb5">
                                <li>
                                    <div class="section">
                                        <h4 class="nm">
                                            {{ $ticket->quantity_sold }}
                                        </h4>

                                        <p class="nm text-muted">@lang("Ticket.sold")</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="section">
                                        <h4 class="nm">
                                            {{ ($ticket->quantity_available === null) ? '∞' : $ticket->quantity_remaining }}

                                            @if($ticket->quantity_available)
                                                <small style="font-size: 11px;">
                                                    / {{ $ticket->quantity_available  }}
                                                </small>
                                            @endif
                                        </h4>

                                        <p class="nm text-muted">@lang("Ticket.remaining")</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="section">
                                        <h4 class="nm hint--top">
                                            {{-- Sales revenue + organiser fees - Partial Refunds --}}
                                            {{ $ticket->getTicketRevenueAmount()->display() }}
                                        </h4>
                                        <p class="nm text-muted">@lang("Ticket.revenue")</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="panel-footer" style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 4px; justify-content: flex-end;">

                            <button class="btn btn-sm btn-default loadModal"
                                    data-modal-id='ticket-{{ $ticket->id }}'
                                    data-href="{{ route('showEditTicket', ['event_id' => $event->id, 'ticket_id' => $ticket->id]) }}"
                            >
                                <i title="@lang("Ticket.basic.edit")"
                                   class="ico-pencil"></i>
                                &#32;&#32;
                                @lang("basic.edit")
                            </button>

                            @if($ticket->sale_status === config('attendize.ticket_status_on_sale'))
                                @if($ticket->is_paused)
                                    <span class="pauseTicketSales btn btn-sm btn-success"
                                          data-id="{{$ticket->id}}"
                                          data-route="{{route('postPauseTicket', ['event_id'=>$event->id])}}">
                                        <i class="ico-play4"></i> @lang("Ticket.resume")
                                    </span>
                                @else
                                    <span class="pauseTicketSales btn btn-sm btn-warning"
                                          data-id="{{$ticket->id}}"
                                          data-route="{{route('postPauseTicket', ['event_id'=>$event->id])}}">
                                <i class="ico-pause"></i> @lang("Ticket.pause")
                            </span>
                                @endif
                            @endif

                            <button class="btn btn-sm btn-danger loadModal"
                                    data-modal-id='ticket-{{ $ticket->id }}'
                                    data-href="{{ route('showDeleteTicket', ['event_id' => $event->id, 'ticket_id' => $ticket->id]) }}"
                            >
                                <i title="@lang("Ticket.basic.delete")"
                                   class="ico-cancel-circle"></i>
                                &#32;&#32;
                                @lang("basic.delete")
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @if($q)
                @include('Shared.Partials.NoSearchResults')
            @else
                @include('ManageEvent.Partials.TicketsBlankSlate')
            @endif
        @endif
    </div><!--/ end ticket table-->
    <div class="row">
        <div class="col-md-12">
            {!! $tickets->appends(['q' => $q, 'sort_by' => $sort_by])->render() !!}
        </div>
    </div>
@stop
