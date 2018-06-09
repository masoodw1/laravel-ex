///
///
///
///

function jsonToForm(elem, json){
   
   
    var obj = $.parseJSON(json);
    console.log('default object now passing to makeform function');
    console.log(obj);
    var myform = '';
    $.each(obj, function( key, value ) {
        
        myform += '<div class="form-group">'+makeForm(value)+"</div>";
      });


    //--------------------------render----------------------//
      elem.html(myform);
      console.log(myform);

    // makeFromJSON(obj);
    //-----------------------------------------------------//



}

///
///
///
///

function makeForm(html){
  
  switch(html.type) {
    case "date":
    field =  '<input type="date" class="'+html.className+'" name="'+html.Highlight+'['+html.name+']" placeholder="'+html.lable+'">' ;
        break;
    case "textarea":
        field =  '<textarea class="form-control" name="'+html.Highlight+'['+html.name+']" placeholder="'+html.lable+'"></textarea>' ;
        break;
    case "select":
        selectOpen =  '<select class="form-control" name="'+html.Highlight+'['+html.name+']">';
        options = makeOptions(html.options, 'select');
        selectClose = '</select>';
        field = selectOpen + " " + options + " " + selectClose;
        break;
    case "file":
        field = '<input type="file" class="form-control" name="'+html.Highlight+'['+html.name+']">';
        break;
    default:
        field =  '<input type="text" class="form-control" name="'+html.Highlight+'['+html.name+']" placeholder="'+html.lable+'">' ;
    }

    return field;
}

///
///
///
///
function makeOptions(data, defult){ 
    var options = '<option selected disabled>'+defult+'</option>';
    $.each(data, function( key, value ) {
        options += '<option>'+value+'</option>';
      });
      return options;
}

