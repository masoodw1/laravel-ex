
@extends('layouts.master')

@section('heading')

@stop

@section('content')
@push('scripts')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush

    <div class="row">
        @include('partials.clientheader')
        @include('partials.userheader')
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-primary shadow">
    
    <div class="panel-heading"><p>{{$tasks->title}}</p></div>
        <div class="panel-body">
            <p>{{$tasks->description }}</p>
            <p class="smalltext">{{ __('Created at') }}:
                {{ date('d F, Y, H:i:s', strtotime($tasks->created_at))}}
                @if($tasks->updated_at != $tasks->created_at)
                    <br/>{{ __('Modified') }}: {{date('d F, Y, H:i:s', strtotime($tasks->updated_at))}}
                @endif</p>
            </div>
        </div>
        
        @foreach ($case_fields as $field)
        <div class="panel panel-default shadow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <p>{{$field['type']}}</p>
                        </div>
                        
                        <div id="bx{{$field['data'][0]->id}}">
                            <div class="col-md-2">
                                <button 
                                type="button" 
                                class="btn btn-default form-control"
                                style="background:#ddd;"
                                >
                                    <i class="fa fa-pencil"> Edit</i>  
                                </button>
                            </div>    
                            <?php if($field['data'][0]->status==0){ ?>
                            <div class="col-md-2">
                                <button 
                                type="button" 
                                class="btn btn-success form-control"
                                value="{{$field['data'][0]->id}}"
                                onClick="approveField(this)">
                                
                                <i class="fa fa-check"> Approve</i>
                                </button>
                            </div>    
                            <div class="col-md-2">
                                <button 
                                type="button" 
                                class="btn btn-danger form-control"
                                value="{{$field['data'][0]->id}}"
                                onClick="rejectField(this)">
                                
                                    <i class="fa fa-close"> Reject</i>  
                                </button>
                            </div>   
                            <?php } else { echo '<span style="padding-top:15px; color:red;">Marked as Rejected</span>'; } ?>
                        </div> 
                    </div>    
                </div>
                <div class="panel-body">
                    @foreach ($field['data'] as $data)
                    <h5>{{$data->name}}</h5> {{$data->value}} <br>
                    @endforeach
                    <p style="color:red;"></p>
            
                </div>
            </div>
        @endforeach

         @if(Entrust::can('enter-data'))
                            <button {{ $tasks->canUpdateInvoice() == 'true' ? '' : 'disabled'}}
                                value="add_time_modal" data-toggle="modal" data-target="#ModalAddField"
                                type="button" 
                                class="btn btn-default form-control"
                                style="background:#ddd;"
                            >
                                <i class="fa fa-plus"></i> Add Data
                            </button>
           @endif             
            @include('partials.comments', ['subject' => $tasks])
            
        </div>
        <div class="col-md-3">
            <div class="sidebarheader">
                <p>{{ __('Task information') }}</p>
            </div>
            <div class="sidebarbox">
                <p>{{ __('Assigned') }}:
                    <a href="{{route('users.show', $tasks->user->id)}}">
                        {{$tasks->user->name}}</a></p>
                <p>{{ __('Created at') }}: {{ date('d F, Y, H:i', strtotime($tasks->created_at))}} </p>

                @if($tasks->days_until_deadline)
                    <p>{{ __('Deadline') }}: <span style="color:red;">{{date('d, F Y', strTotime($tasks->deadline))}}

                            @if($tasks->status == 1)({!! $tasks->days_until_deadline !!})@endif</span></p>
                    <!--Remove days left if tasks is completed-->

                @else
                    <p>{{ __('Deadline') }}: <span style="color:green;">{{date('d, F Y', strTotime($tasks->deadline))}}

                            @if($tasks->status == 1)({!! $tasks->days_until_deadline !!})@endif</span></p>
                    <!--Remove days left if tasks is completed-->
                @endif

                @if($tasks->status == 1)
                    {{ __('Status') }}: {{ __('Open') }}
                @else
                    {{ __('Status') }}: {{ __('Closed') }}
                @endif
            </div>
            @if($tasks->status == 1)

                {!! Form::model($tasks, [
               'method' => 'PATCH',
                'url' => ['tasks/updateassign', $tasks->id],
                ]) !!}
                {!! Form::select('user_assigned_id', $users, null, ['class' => 'form-control ui search selection top right pointing search-select', 'id' => 'search-select']) !!}
                {!! Form::submit(__('Assign user'), ['class' => 'btn btn-primary form-control closebtn']) !!}
                {!! Form::close() !!}

                {!! Form::model($tasks, [
          'method' => 'PATCH',
          'url' => ['tasks/updatestatus', $tasks->id],
          ]) !!}

                {!! Form::submit(__('Close task'), ['class' => 'btn btn-success form-control closebtn']) !!}
                {!! Form::close() !!}

            @endif
            <div class="sidebarheader">
                <p>Status Management</p>
            </div>
            <table class="table table_wrapper ">
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>Status</th>
                </tr>
                <tbody>
               @foreach($invoice_lines as $invoice_line)
                    <tr>
                        <td style="padding: 5px">{{$invoice_line->title}}</td>
                        <td style="padding: 5px">{{$invoice_line->quantity}} </td>
                    </tr>
                @endforeach
     
                </tbody>
            </table>
            <br/>
            <button type="button" {{ $tasks->canUpdateInvoice() == 'true' ? '' : 'disabled'}} class="btn btn-primary form-control" value="add_time_modal" data-toggle="modal" data-target="#ModalTimer" >
                Update Status
            </button>
            @if($tasks->invoice)
                <!-- <a href="/invoices/{{$tasks->invoice->id}}">See the invoice</a> -->
                <a href="/reports/{{$tasks->invoice->id}}">View Full Report</a>
            @endif 
            <div class="activity-feed movedown">
                @foreach($tasks->activity as $activity)
                    <div class="feed-item">
                        <div class="activity-date">{{date('d, F Y H:i', strTotime($activity->created_at))}}</div>
                        <div class="activity-text">{{$activity->text}}</div>

                    </div>
                @endforeach
            </div>

            @include('invoices._invoiceLineModal', ['title' => $tasks->title, 'id' => $tasks->id, 'type' => 'task'])
        </div>
    </div>
<!-- modal add -->
    <div class="modal fade" id="ModalAddField" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                Input New Field
                    </h4>
                
            </div>
            {!! Form::open([
                'method' => 'post',
                'url' => ['tasks/update', $tasks->id],
            ]) !!}

            <div class="modal-body">
            
            
            <div class="form-group">
            {!! Form::label('type', 'Component Type', ['class' => 'control-label']) !!}
            <select class="form-control" name="type" onchange="typeSelect({{$field_types}})" id="ts_id">
                <option selected disabled> Select </opton>
                @foreach($field_types as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>

            </div>
            {{ Form::hidden('task_id', $tasks->id) }}
            <div id='formStuct'></div>
            </div>

            
            <div class="modal-footer">
                <button type="button" class="btn btn-default col-lg-6"
                        data-dismiss="modal">{{ __('Close') }}</button>
                <div class="col-lg-6">
                    {!! Form::submit( 'Submit', ['class' => 'btn btn-success form-control closebtn']) !!}
                </div>
              
            </div>
              {!! Form::close() !!}

              
        </div>
    </div>
</div>


@stop

@push('scripts')

    <script>
        function approveField(elem){
            console.log(elem.value)
            $.ajax({
          type: "POST",
          url: '/update/fieldstatus/2',
          data: {
            "_token": "{{ csrf_token() }}",
            "field_id": elem.value
        },
          success: function( msg ) {
              console.log( msg );
              swal('Approved!', {
                icon: "success",
              });
              $(elem).attr("disabled", "disabled");
              $('#bx'+elem.value).children().hide();
              $('#bx'+elem.value).append('<span style="padding-top:15px; color:green;">Marked as Aprove</span>')
          }
      });
        }
        function rejectField(elem){
            console.log(elem.value)
            $.ajax({
          type: "POST",
          url: '/update/fieldstatus/1',
          data: {
            "_token": "{{ csrf_token() }}",
            "field_id": elem.value
        },
          success: function( msg ) {
              console.log( msg );
              swal('Rejected!', {
                icon: "error",
              });
              $(elem).attr("disabled", "disabled");
              $('#bx'+elem.value).children().hide();
              $('#bx'+elem.value).append('<span style="padding-top:15px; color:red;">Marked as Rejected</span>')
            //   $('bx'+elem.value).append('<button>sent for approval</buton>');
          }
      });
        }
    </script>
    <script src="{{ URL::asset('components/fb/assets/js/form-render.min.js') }}"></script>
@endpush
