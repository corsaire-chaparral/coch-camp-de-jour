<div role="dialog"  class="modal fade " style="display: none;">
    {!! Form::model($ticket, ['url' => route('postDeleteTicket', ['ticket_id' => $ticket->id, 'event_id' => $event->id]), 'class' => 'ajax']) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    @lang("ManageEvent.delete_ticket", ["title"=>$ticket->title])</h3>
            </div>
            <div class="modal-body">
                <div class="content">
                    <h4>{{$ticket->title}}</h4>
                    <p>@lang('ManageEvent.delete_are_you_sure')</p>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
                {!! Form::button(trans("basic.cancel"), ['class'=>"btn modal-close btn-default",'data-dismiss'=>'modal']) !!}
                {!! Form::submit(trans("basic.delete"), ['class'=>"btn btn-danger"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
