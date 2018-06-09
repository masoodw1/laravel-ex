@extends('layouts.master')

@section('content')

    <div class="row">
        
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading panel-header">
                    <h3 class="text-center"><strong>Summary of Service Requests</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>

                            <tr>
                                <td><strong>Service Offered</strong></td>
                                <td class="text-center"><strong>Client Request Order</strong></td>
                                <td class="text-center"><strong>Status</strong></td>
                                <td class="text-right"><strong>Remarks</strong></td>
                            </tr>

                            </thead>
                            <tbody>
                            
                            
                            @foreach ($feld_types as $field)
                                <tr>
                                    <td>{{$field['name']}}</td>
                                    <td class="text-center">,-</td>
                                    <td class="text-center"></td>
                                    <td class="text-right">-</td>
                                </tr>
                                
                            @endforeach

                            <!-- <tr>
                                <td class="emptyrow"></i></td>
                                <td class="emptyrow"></td>
                                <td class="emptyrow text-center"><strong>{{ __('Total') }}</strong></td>
                                <td class="emptyrow text-right"></td>
                            </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           
                <button type="button" class="btn btn-primary form-control" data-toggle="modal"
                        data-target="#ModalTimer">
                        {{ __('Insert new item') }}
                    
                </button>
           
        </div>

        <div class="col-md-4">
            <div class="sidebarbox">
                <div class="sidebarheader">
                    <p>Invoice information</p>
                </div>
                
                <br/><br/>

            <button type="button" class="btn btn-success form-control closebtn" value="add_time_modal" data-toggle="modal" data-target="#SendInvoiceModalConfirm" >
                Forward Report to QC
            </button>

                </div>
                 



    </div>
    </div>
    </div>


@endsection