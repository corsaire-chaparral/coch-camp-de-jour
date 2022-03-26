<div role="dialog"  class="modal fade " style="display: none;">
    {!! Form::model($event, ['url' => route('postDeleteEvent', ['event_id' => $event->id]), 'class' => 'ajax reset closeModalAfter']) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-calendar"></i>
                    @lang("ManageEvent.delete_event", ["title"=>$event->title])</h3>
            </div>
            <div class="modal-body">
                <div class="content">
                    <h4>{{$event->title}}</h4>
                    <p>@lang('ManageEvent.delete_event_are_you_sure')</p>
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
