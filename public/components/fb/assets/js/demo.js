jQuery(function($) {
  var fields = [{
    label: 'Text Input',
    attrs: {
      type: 'text',
      class: 'icon-text'
    }
  }];
  

  // var replaceFields = [
  //   {
  //     type: 'textarea',
  //     subtype: 'tinymce',
  //     label: 'tinyMCE',
  //     required: true,
  //   }
  // ];

  var actionButtons = [{
    id: 'smile',
    className: 'btn btn-success',
    label: '😁',
    type: 'button',
    events: {
      click: function() {
        alert('😁😁😁 !SMILE! 😁😁😁');
      }
    }
  }];

  var templates = {
    // starRating: function(fieldData) {
    //   return {
    //     field: '<span id="'+fieldData.name+'">',
    //     onRender: function() {
    //       $(document.getElementById(fieldData.name)).rateYo({rating: 3.6});
    //     }
    //   };
    // }
  };

  // var inputSets = [{
  //       label: 'User Details',
  //       icon: '👨',
  //       name: 'user-details', // optional
  //       showHeader: true, // optional
  //       fields: [{
  //         type: 'text',
  //         label: 'First Name',
  //         className: 'form-control'
  //       }, {
  //         type: 'select',
  //         label: 'Profession',
  //         className: 'form-control',
  //         values: [{
  //           label: 'Street Sweeper',
  //           value: 'option-2',
  //           selected: false
  //         }, {
  //           label: 'Brain Surgeon',
  //           value: 'option-3',
  //           selected: false
  //         }]
  //       }, {
  //         type: 'textarea',
  //         label: 'Short Bio:',
  //         className: 'form-control'
  //       }]
  //     }, {
  //       label: 'User Agreement',
  //       fields: [{
  //         type: 'header',
  //         subtype: 'h3',
  //         label: 'Terms & Conditions',
  //         className: 'header'
  //       }, {
  //         type: 'paragraph',
  //         label: 'Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.',
  //       }, {
  //         type: 'paragraph',
  //         label: 'Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.',
  //       }, {
  //         type: 'checkbox',
  //         label: 'Do you agree to the terms and conditions?',
  //       }]
  //     }];

  var typeUserDisabledAttrs = {
    autocomplete: ['access']
  };

  var typeUserAttrs = {
    text: {
      className: {
        label: 'Information Type',
        options: {
          'title': 'Title',
          'details': 'Details'
        },
        style: 'border: 1px dotted black'
      }
    },
    textarea: {
      className: {
        label: 'Information Type',
        options: {
          'title': 'Title',
          'details': 'Details'
        },
        style: 'border: 1px dotted black'
      }
    },
    select: {
      className: {
        label: 'Information Type',
        options: {
          'title': 'Title',
          'details': 'Details'
        },
        style: 'border: 1px dotted black'
      }
    }
  };

  // test disabledAttrs
  var disabledAttrs = [];

  var fbOptions = {
    subtypes: {
      text: ['datetime-local']
    },
    onSave: function(e, formData) {
      toggleEdit();
      $('.render-wrap').formRender({
        formData: formData,
        templates: templates
      });
      window.sessionStorage.setItem('formData', JSON.stringify(formData));
    },
    stickyControls: {
      enable: true
    },
    sortableControls: true,
    
    templates: templates,
    inputSets: false,
    
    typeUserDisabledAttrs: typeUserDisabledAttrs,
    fields: fields,
    disableInjectedStyle: false,
    
    disableFields: ['autocomplete', 'button', 'paragraph', 'hidden', 'checkbox-group', 'text'],
    
    
    disabledFieldButtons: {
      text: ['copy']
    },
    roles: roles
    
    // controlPosition: 'left'
    // disabledAttrs:['class']
  };
  // console.log(roles);
  var formData = window.sessionStorage.getItem('formData');
  var editing = true;

  if (formData) {
    fbOptions.formData = JSON.parse(formData);
  }

  /**
   * Toggles the edit mode for the demo
   * @return {Boolean} editMode
   */
  function toggleEdit() {
    document.body.classList.toggle('form-rendered', editing);
    return editing = !editing;
  }

  var setFormData = '[{"type":"text","label":"Full Name","subtype":"text","className":"form-control","name":"text-1476748004559"},{"type":"select","label":"Occupation","className":"form-control","name":"select-1476748006618","values":[{"label":"Street Sweeper","value":"option-1","selected":true},{"label":"Moth Man","value":"option-2"},{"label":"Chemist","value":"option-3"}]},{"type":"textarea","label":"Short Bio","rows":"5","className":"form-control","name":"textarea-1476748007461"}]';

  var formBuilder = $('.build-wrap').formBuilder(fbOptions);
  var fbPromise = formBuilder.promise;

  document.getElementById('getJSON').addEventListener('click', function() {
      // alert();
       form_data = formBuilder.actions.getData('json', true);
       field_id = $('#ts_id').val();
      
      // console.log();
        $.ajax({
          type: "POST",
          url: '/formattribute/formlayout',
          data: {
            "_token": crsf_token,
            "form_data": form_data,
            "field_id": field_id
        },
          success: function( msg ) {
              console.log( msg );
              swal('Form Layout has been saved Sucessfully!', {
                icon: "success",
              });
          }
      });
      
    });

    // document.getElementById('resetDemo').addEventListener('click', function() {
    //   window.sessionStorage.removeItem('formData');
    //   location.reload();
    // });

  document.getElementById('edit-form').onclick = function() {
    toggleEdit();
  };
});
