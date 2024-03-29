<div class="panel panel-default event">
    <div class="panel-heading" data-style="background-color: {{{$event->bg_color}}};background-image: url({{{$event->bg_image_url}}}); background-size: cover;">
        <div class="event-date">
            {{-- Camp de jour: inverser day/month pour français --}}
            <div class="day">
                {{$event->start_date->format('d')}}
            </div>
            <div class="month">
                {{strtoupper(explode("|", trans("basic.months_short"))[$event->start_date->format('n')])}}
            </div>
        </div>
        <ul class="event-meta">
            <li class="event-title">
                <a title="{{{$event->title}}}" href="{{route('showEventDashboard', ['event_id'=>$event->id])}}">
                    {{{ Str::limit($event->title, $limit = 75, $end = '...') }}}
                </a>
            </li>
            <li class="event-organiser">
                Par <a href='{{route('showOrganiserDashboard', ['organiser_id' => $event->organiser->id])}}'>{{{$event->organiser->name}}}</a>
            </li>
        </ul>

    </div>

    <div class="panel-body">

        @if(!$event->is_live)
            <span class="label label-default" title="{{ @trans("ManageEvent.event_not_live") }}">
                <span class="status status-neutral"></span>
                @lang('basic.offline')
            </span>
        @else
            <span class="label label-default">
                <span class="status status-success"></span>
                @lang('basic.online')
            </span>
        @endif
        <ul class="nav nav-section nav-justified mt5 mb5">
            <li>
                <div class="section">
                    <h4 class="nm">{{ $event->tickets->sum('quantity_sold') }}</h4>
                    <p class="nm text-muted">@lang("Event.tickets_sold")</p>
                </div>
            </li>

            <li>
                <div class="section">
                    <h4 class="nm">{{ $event->getEventRevenueAmount()->display() }}</h4>
                    <p class="nm text-muted">@lang("Event.revenue")</p>
                </div>
            </li>
        </ul>
    </div>
    <div class="panel-footer">
        <ul class="nav nav-section nav-justified">
            <li>
                <a href="{{route('showEventCustomize', ['event_id' => $event->id])}}">
                    <i class="ico-edit"></i> @lang("basic.edit")
                </a>
            </li>

            <li>
                <a href="{{route('showEventDashboard', ['event_id' => $event->id])}}">
                    <i class="ico-cog"></i> @lang("basic.manage")
                </a>
            </li>

            <li style="text-align: center">

                <button
                    data-modal-id='DeleteEvent'
                    data-href="{{route('showDeleteEvent', ['event_id'=>$event->id])}}"
                    class='loadModal btn btn-danger' type="button"
                >
                    <i class="ico-trash"></i>
                    @lang("basic.delete")
                </button>
            </li>
        </ul>
    </div>
</div>
