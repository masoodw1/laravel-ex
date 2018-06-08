
function typeSelect(json){
    
    pointer = $("#ts_id").val()-1;
    
    structData = json[pointer].form_struc;
    
    // jsonToForm($("#formStuct"), structData);
    makeFromJSON(structData, $("#formStuct"));
    
}


function makeFromJSON(json, elem){
    console.log('obj from makeForm funciton')
    var escapeEl = document.createElement('textarea'),
    code = document.getElementById(elem),
    escapeHTML = function(html) {
      escapeEl.textContent = html;
      return escapeEl.innerHTML;
    },
    formData = json,
    addLineBreaks = function(html) {
      return html.replace(new RegExp('&gt; &lt;', 'g'), '&gt;\n&lt;').replace(new RegExp('&gt;&lt;', 'g'), '&gt;\n&lt;');
    };

  // Grab markup and escape it
  var $markup = $('<div/>');
  $markup.formRender({formData});

  // set < code > innerHTML with escaped markup
  elem.html($markup[0].innerHTML);
// console.log($markup[0].innerHTML);

//   hljs.highlightBlock(code);
}