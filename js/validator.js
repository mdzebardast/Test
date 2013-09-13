
function validate(e){
    //alert("Runnig");
    if(e==""){
        error="Please fill email!";
        //alert(error);
    }
    return error;
}

function resure(link){
	question = confirm("مطمئن هستيد که ميخواهيد اين گزینه را پاک کنید؟")
	if (question !="0"){
		top.location = link
	}
}
