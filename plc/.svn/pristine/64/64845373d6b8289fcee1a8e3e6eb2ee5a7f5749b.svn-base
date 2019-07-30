<script type="text/javascript">
function uploadfile(formgrid, grid, formAction, url){
  var obj = $('#'+formgrid);
  var j=0;
  var x=0;
    var formData = new FormData();
    var formDataUpload = new FormData();


    var params = $(obj).serializeArray(); 
    $.each(params, function (i, val) {
        formData.append(val.name, val.value); 
        
    });


    var paramsKet = $(obj).find(".fileKet").serializeArray(); 
    var paramsFileid = $(obj).find(".fileid").serializeArray(); 
    
    var keyket = '';
    var fileidid = '';

    //Addupload data ajah
    
    $.each($(obj).find("input[type='file']"), function(i, tag) {
      /*alert('file ke '+i);*/


        $.each($(tag)[0].files, function(i, file) {

          if(x<=20){ 
            //alert('upload ke '+x);
              formDataUpload.append(tag.name, file);

              $.each(paramsKet, function (ii, val) {
                  var keyket = val.name;
                  if(ii >= x){
                    //alert(' file ke'+x+'ket ke '+ii+' val '+val.value);
                    formDataUpload.append(val.name, val.value);
                  }

              });

              $.each(paramsFileid, function (ii, val) {
                  var fileidid = val.name;
                  if(ii >= x){
                    //alert(' file ke'+x+'ket ke '+ii+' val '+val.value);
                    formDataUpload.append(val.name, val.value);
                  }

              });

              $.ajax({
                  url: formAction,
                  type: 'POST',
                  xhr: function() {  // Custom XMLHttpRequest
                      var myXhr = $.ajaxSettings.xhr();
                      if(myXhr.upload){ // Check if upload property exists
                          myXhr.upload.addEventListener('progress',progress, false); 
                      }
                      return myXhr;
                  },
                  success: function(data) {
                    formDataUpload.delete(tag.name);  
                    //formDataUpload.delete(keyket);  

                    $.each(paramsKet, function (ii, val) {
                          formDataUpload.delete(val.name);
                    });


                   var o = $.parseJSON(data);
                    /*$(".Dialog").dialog('close');*/
                    _custom_alert(o.message,'info','info', grid, 1, 20000);
                    $.get(url, function(data) {
                      $('div#form_'+grid).html(data);
                      $('#grid_'+grid).trigger('reloadGrid');
                    });

                  },
                  // Form data
                  data: formDataUpload,
                  cache: false,
                  contentType: false,
                  processData: false,
                  async: false
              });
          }
            formDataUpload.delete(tag.name);  
            //formDataUpload.delete(keyket);  

        });
        x++;
    });
    //Tidak Include data lain

    
 

    if(j>=100000000){
      _custom_alert("Maximal keselurah size upload 100MB, Mohon Upload secara bertahap!",'info','info', grid, 1, 20000);
      return false;
    }
    if(x>=20){
      alert("Jumlah upload file melebihi 20, file yang akan di simpan 20 file teratas!");
    }
     
    //return false;
    /*waitDialog("Waiting... Upload File...");
    $.ajax({
       url: formAction,
       type: 'POST',
       xhr: function() {  // Custom XMLHttpRequest
           var myXhr = $.ajaxSettings.xhr();
           if(myXhr.upload){ // Check if upload property exists
               myXhr.upload.addEventListener('progress',progress, false); 
           }
           return myXhr;
       },
       success: function(data) {
           var o = $.parseJSON(data);
           $(".Dialog").dialog('close');
        _custom_alert(o.message,'info','info', grid, 1, 20000);
        $.get(url, function(data) {
          $('div#form_'+grid).html(data);
          $('#grid_'+grid).trigger('reloadGrid');
        });
       },
       // Form data
       data: formDataUpload,
       cache: false,
       contentType: false,
       processData: false
     });*/
 
}

function uploadCustomGrid(formgrid, grid, formAction, url){
    var obj = $('#'+formgrid);
    var j=0;    
    var x=1;                       
    var formData = new FormData();
    $.each($(obj).find("input[type='file']"), function(i, tag) {
        $.each($(tag)[0].files, function(i, file) {
            if(x<=20){
                formData.append(tag.name, file);
                j += file.size;
            }
            
        });
        x++;
    }); 
    if(j>=100000000){
        _custom_alert("Maximal keselurah size upload 100MB, Mohon Upload secara bertahap!",'info','info', grid, 1, 20000);
        return false;
    }
    if(x>=20){
        alert("Jumlah upload file melebihi 20, file yang akan di simpan 20 file teratas!");
    }
    var params = $(obj).serializeArray();
    $.each(params, function (i, val) {
        formData.append(val.name, val.value);
    });
   
    //return false;
    waitDialog("Waiting... Upload File...");
    $.ajax({
        url: formAction,  
        type: 'POST',
        xhr: function() {  // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // Check if upload property exists
                myXhr.upload.addEventListener('progress',progress, false); 
            }
            return myXhr;
        },                      
        success: function(data) {
                var o = $.parseJSON(data);  
                $(".Dialog").dialog('close');                                                           
                _custom_alert(o.message,'info','info', grid, 1, 20000);
                $.get(url, function(data) {
                    $('div#form_'+grid).html(data);
                    $('#grid_'+grid).trigger('reloadGrid');
                });
        },
        // Form data
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function progress(e){
  if(e.lengthComputable){
        $('#progress').attr({value:e.loaded,max:e.total});
    }
}
function waitDialog(h3=''){
  console.log('RaidenArmy');
  $(".Dialog").dialog({
    title: "Uploading File...",
    autoOpen: true,
         resizable: false,
         height:350,
         width:350,
    hide: {
      effect: "explode",
      duration: 500
    },
         modal: true,
    open:function(){
       h2 = (h3 == "") ? "Proccess Uploading ..." : h3;
       $("#h3").html(h2);
    },
    close : function(){
      $(this).dialog("destroy");
    }
    });
}
</script>
<?php $imgurl = base_url().'assets/images/e-load.gif';?>
<div class="Dialog" style="display: none">
  <div  style="margin: 0px 0px">
    <img alt="" src="<?php echo $imgurl; ?>"  /><br/>
    <span id="span"> </span>
    <h3 id = "h3">J u s t  a m i n u t e ...</h3>
    <progress id = "progress" ></progress>
  </div>
</div>
