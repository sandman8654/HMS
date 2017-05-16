/*
*   
*   author: robin san
*   date: 2017.4.13
*
*/

//submit billing items to db
/*
*   params: 
*   afterCallback - after success this function will called
*   data -  data for inserting
*/
function submitBill(data,afterCallback){
    if (data["recepId"].length>0){
        $.ajax({
            url:data.url,
            data:data,
            type:"POST",
            success:function(res){
                if(res=="success"){
                    $.alert("Transactions are created successfully","Success").close(function(){
                        $.isFunction(afterCallback)&&afterCallback();
                    });
                    
                }else{
                    $.alert("While creating the transaction, some errors raised!","Error");
                }
            }
        });
    }else{
        $.alert("Please first register current reception.","Error");
    }
};
// send patient to branch(triage, consultation, lab, rad ...)
/*
*   params: 
*   data -  data for inserting
*/

function sendToBranch(data,afterCallback){
     $.ajax({
        url:data.url,
        data:data,
        type:"POST",
        success:function(res){
            if(res=="success"){
                $.alert("Patient sent successfully","Success");
                $.isFunction(afterCallback)&&afterCallback();
            }else{
                $.alert("While sending patient to Triage, some errors raised!","Error");
            }
        }
    });
}
/*
* submit payment information for patient
*/
function submitPayment(data){
    $.ajax({
        url:data.url,
        data:data,
        type:"POST",
        success:function(res){
            if(res=="success"){
                $.alert("Payment submitted successfully","Success");
                $.isFunction(afterCallback)&&afterCallback();
            }else{
                $.alert("While submitting payment, some errors raised!","Error");
            }
        }
    });
}
