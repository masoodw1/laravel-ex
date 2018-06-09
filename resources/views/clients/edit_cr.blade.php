@extends('layouts.master')
@section('heading')
    Edit Client Service Request ({{$client->name}})
@stop

@section('content')
   
    <div class="row">
        
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading panel-header">
                    <!-- <h3 class="text-center">Client Service Request(s)</h3> -->
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                    {{ Form::open(array('route' => array('client.update_cr', $client->id))) }}
                        <table class="table table-condensed">
                            <thead>

                            <tr>
                                <td><strong>Component Name</strong></td>
                                <td class="text-center"><strong>Required</strong></td>
                                <!-- <td class="text-center"><strong>Status</strong></td>
                                <td class="text-right"><strong>Remarks</strong></td> -->
                            </tr>

                            </thead>
                            <tbody>
                            

                            @foreach ($fields as $field)
                                <tr>
                                    <td>{{$field['name']}}</td>
                                    <td class="text-center">
                                    <input type="checkbox" name="fieldattr_id[]" value="{{$field['id']}}" {{$field['checked'] or ''}}>
                                    </td>
                                    <!-- <td class="text-center"></td>
                                    <td class="text-right">-</td> -->
                                </tr>
                                
                            @endforeach
                           
                            

                          

                           
                            </tbody>
                        </table>
                        {!! Form::submit('Save', ['class' => 'btn btn-success form-control closebtn']) !!}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
    
        </div>
    </div>

@stop