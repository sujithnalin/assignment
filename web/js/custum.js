/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $('#appbundle_employee_mapDepartment').change(function () {
        var v = $('#appbundle_employee_mapDepartment').val();
        var url = '/sub_department';

        $.post(url, {'dpt': v}, function (jsonResult) {
            var result = $.parseJSON(jsonResult);
            var subDpt="";
            $.each(result, function (k, v) {
                subDpt +='<option value="'+v.id+'">'+ v.subDepartmentName+'</option>';
            });
             $("#appbundle_employee_subDepartment").html("");            
             $("#appbundle_employee_subDepartment").html(subDpt);            

        });


    });
});


