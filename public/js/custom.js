/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//function searchTable(inputVal)
//{
//	var table = $('#tblData');
//	table.find('tr').each(function(index, row){
//            var allCells = $(row).find('td');
//	    if(allCells.length > 0){
//		var found = false;
//		allCells.each(function(index, td){
//                    var regExp = new RegExp(inputVal, 'i');
//                    if(regExp.test($(td).text())){
//                       found = true;
//                       return false;
//                    }
//		});
//		if(found == true)$(row).show();else $(row).hide();
//	    }
//	});
//}
//
//    (function($){
//
//        $(document).ready(function(){
//                alert("Ttest");
//                
//            });
//
//    })(jQuery);

$(function(){
    
    /*
     * Hide all elements
     */
    
    $('div[title="success"]').hide();
    $('div[title="warning"]').hide();
    $(".msgcontainer").hide();
    
    
    // Switch among tabs
    $("a[data-toggle='tab']").click(function(){
        $(".tab-pane").hide();
        $($(this).attr("href")).show();
    });
    
    
    
    //Reset modal form
    $('#formmodal').on('hide.bs.modal', function () {
        document.getElementById('formsubmit').reset();
        $("form[name='formsubmit'] select").removeAttr("readonly");
        $('div[title="warning"]').html("");
        $('div[title="warning"]').hide();
        $('div[title="success"]').html(""); 
        $('div[title="success"]').hide();
    });
    
     //Select and deselect all
    $('input[name="selecttall"]').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
    

        $("select[name='pageitems']").change(function(){
             $("input[name='itemcount']").val($("select[name='pageitems'] option:selected").val());
             $("form[name='frmsearch']").submit();
        });
                
    
    //Submit auto register form
    $("#auto-register").click(function(e){
        e.preventDefault();
        var checkboxcount = 0;
        $(".checkbox").each(function(index){
            if($(this).is(":checked")){
                checkboxcount++;
            }
        });

        if(!checkboxcount){
           $(".msgcontainer").html("<span class='glyphicon glyphicon-remove'></span> Select atleast one student.");
           $(".msgcontainer").show();
           return false;
        }
        $(".msgcontainer").hide();
        $("#frmauto-register").submit();
    });

    //Call searchable table
    $('#searchable').dataTable();
    
    //Use ajax to submit form
    $("form[name='formsubmit']").unbind('submit').submit(function(){
        var formdata  =  $("form[name='formsubmit']").serialize();

        //if not call by ajax
        //submit to showformAction
        if (is_xmlhttprequest == 0) 
            return true;
        //if by ajax
        //check by ajax : validatepostajaxAction
        $.post(urlform,formdata, function(msg){
//                alert(msg);
//                return false;
                 if(msg['success']){   
                    $('div[title="warning"]').html("");
                    $('div[title="warning"]').hide();
                    $('div[title="success"]').html(msg['msg']); 
                    $('div[title="success"]').show();
                    location.reload();
                 }else{
                    $('div[title="success"]').hide();
                    $('div[title="success"]').html("");
                    $('div[title="warning"]').html(msg['msg']); 
                    $('div[title="warning"]').show();
                 } 
                 
                 if(msg['processed']){
                     $("#progress").html("");
                     location.reload();
                 }
                 
         }, 'JSON');
        
        
        
        return false;
    });
    
    //Use ajax to submit form
    $("#formallocate").unbind('submit').submit(function(){
        var formdata  =  $("#formallocate").serialize();
        //if not call by ajax
        //submit to showformAction
        if (is_xmlhttprequest == 0) 
            return true;
        //if by ajax
        //check by ajax : validatepostajaxAction
        $.post(formurl,formdata, function(msg){
//                 alert(msg);
//                 return false;
                 if(msg['success']){   
                    $("#warning-assign").html("");
                    $("#warning-assign").hide();
                    $('#success-assign').html(msg['msg']); 
                    $('#success-assign').show();
                    location.reload();
                 }else{
                    $('#success-assign').hide();
                    $("#success-assign").html("");
                    $('#warning-assign').html(msg['msg']); 
                    $('#warning-assign').show();
                 }      
         }, 'JSON');
         
        return false;
    });
    
    /*
     * Submit form with POST and FILES data
     */
    //Use ajax to submit form
    $("#formfile").unbind('submit').submit(function(){
        var formdata  =  $("#formfile").serialize();
        //if not call by ajax
        //submit to showformAction
        if (is_xmlhttprequest == 0) 
            return true;
        //if by ajax
        //check by ajax : validatepostajaxAction
        $.post(formurl,formdata, function(msg){
                 alert(msg);
                 return false;
                 if(msg['success']){   
                    $("#warning-assign").html("");
                    $("#warning-assign").hide();
                    $('#success-assign').html(msg['msg']); 
                    $('#success-assign').show();
                    location.reload();
                 }else{
                    $('#success-assign').hide();
                    $("#success-assign").html("");
                    $('#warning-assign').html(msg['msg']); 
                    $('#warning-assign').show();
                 }      
         }, 'TEXT');
         
        return false;
    });
    
    
    
    
});    

