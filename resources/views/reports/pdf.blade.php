<table style="width:300px">
  <tr>
    <th style="width:100px"></th>
    <th style="width:100px"><img src="http://everongroup.in/wp-content/uploads/2018/02/EVERON-FINAL-LOGO.jpg" width="500" alt=""></th>
    <th style="width:100px"></th> 
  </tr>
  <tr>
  <td style="width:100px; color:#fff;">'</td>
    <td style="text-align: center;"><span>{{$address}}</span></td> 
    <td></td>
  </tr>
</table>

<table style="border:1px solid;">
  <tr style="border:1px solid;">
  <td>Ordered By : {{$report[0]->client->name}}</td> 
  <td style="width:300px;">Name of Candidate: {{$report[0]->title}}</td>
  </tr>
  <tr style="border:1px solid;">
  <td>Clietn Code: 00{{$report[0]->client->id}} </td>
  <td>Client Application Ref No: XYZ235225</td>
  </tr>
  <tr style="border:1px solid;">
  <td>Type of Report: STD-4</td>
  <td>EfoRMS Ref No. : 00018201801014255</td>
  </tr>
  <tr style="border:1px solid;">
  <td>Date of Order : {{$report[0]->created_at}}</td>
  <td>Date of Complete :</td>
  </tr>
</table>
<br>
<table style="border:1px solid; width:500">
<tr>
<th>Service Offered</th>
<th>Client Request Order</th>
<th>Status</th>
<th>Remarks</th>
</tr>
@foreach ($display_fields as $df)
  <tr>
  <td>{{$df['services_offered']}}</td> 
  <td>{{$df['client_request_order']}}</td> 
  <td>{{$df['Status']}}</td> 
  <td>{{$df['Remarks']}}</td> 
  </tr>
@endforeach
</table>




