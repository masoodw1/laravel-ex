
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('components/fb/assets/css/demo.css') }}">
  <link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.css">

  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  
</head>

<body style="padding-right: 20px; padding-left: 20px;">
    <style>
     .ui-sortable {
         min-height:100px !important;
     }
    </style>
  <div class="content" style="padding-top:0;">
  <a href="{{ url()->previous() }}" class="btn btn-default" style="color:#fff; background:#4C4C4C; margin-top:15px; padding-bottom:10px;"> <- Back</a>


    <h1>Case Form Builder</h1>
    <select class="form-control" name="type"
     onchange="typeSelect_builder()" id="ts_id"
     style="margin-bottom:5em;">
                <option selected disabled> Select Component to buid a form layout </opton>
                @foreach($field_types as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
    </select>
    <div id="fullwrap" style="display:none;">
    <div id="stage1" class="build-wrap"></div>
    <form class="render-wrap"></form>
    <button id="edit-form">Edit Form</button>
    <div class="action-buttons">
      
      <!-- <button id="showData" type="button">Show Data</button>
      <button id="clearFields" type="button">Clear All Fields</button>
      <button id="getData" type="button">Get Data</button>
      <button id="getXML" type="button">Get XML Data</button> -->
      
      <!-- <button id="getJS" type="button">Get JS Data</button>
      <button id="setData" type="button">Set Data</button>
      <button id="addField" type="button">Add Field</button>
      <button id="removeField" type="button">Remove Field</button>
      <button id="testSubmit" type="submit">Test Submit</button> -->
      
      
      <input type="hidden"  id="setLanguage" value="en-US">
      
    </div>
  </div>
</div>
<button id="getJSON" class="btn btn-primary" style="width:60%;" type="button">Save Form Layout</button>
      <button id="resetDemo" class="btn btn-danger" style="width:39%;" type="button">Reset Form Layout</button>
  <script>
      crsf_token = "{{ csrf_token() }}";
  </script>
  <script type="text/javascript" src="{{ URL::asset('components/fb/assets/js/vendor.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('components/fb/assets/js/form-builder.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('components/fb/assets/js/form-render.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('components/sweetalert/swal.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.js"></script>
  <script type="text/javascript" src="{{ URL::asset('components/fb/assets/js/demo.js') }}"></script>
  
  <script>
      var times_selected = 0;
     function typeSelect_builder(){
        var selected_id =  $('#ts_id').val();
        // console.log(selected_id);
        
        
        if(times_selected>0){
          alert('are you sure you want to re selected a component?');
             
            
            window.sessionStorage.removeItem('formData');
            $('#fullwrap').show();
            
        }
        else if(times_selected===0){
            $('#fullwrap').show();
            $( "#fullwrap:last-child button" ).hide();
        }
        times_selected++;
        
     }

     
    //  function confirm_typeSelect(){
    //      r = confirm("Press a button!");
    //     if (r == true) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    //  }

    // $( "#fullwrap:last-child button:first" ).hide(); $( "#fullwrap:last-child button:first" ).next().hide(); $( "#fullwrap:last-child button:first" ).next().next().hide();
   

  </script>

  <script>
  <?php
  $myroles =array();
  foreach($roles as $role){
    $myroles[$role->id] = $role->name;
  }
  //print_r(json_encode($myroles));
?>
  var roles = <?php print_r(json_encode($myroles)); ?>;
  </script>



</body>

</html>
