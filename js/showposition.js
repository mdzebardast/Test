jQuery.fn.showposition = function () {
     var parent=$(this).parent();
     var positionname=$('#positionname').val();
     var streetname=$('#streetname').val();
     var streetid=$('#streetid').val();
     var groupid=$('#groupid').val();

/*     $('#result').append(positionname);
     $('#result').append(streetname);*/
     $.post("cp/actions.php", {
                streetname: streetname,
                streetid: streetid,
                groupid: groupid,
                positionname: positionname,
                act:3,
                from:2
            }, function (data) {
                if (data.error) {  //error
                    alert("You can not search!");
                } else {

                    $('#result').html(data);
                    //$('#result').html("zebar");

                }

            },'text');
			//$(this).parent().html('<p>Zebardast</p>');
}
