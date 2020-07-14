function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};
    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}


function block() {
  var base_url  = window.location.origin;
  $.blockUI({ message : "<img src='"+base_url+"/codeigneter-3.1.11/AdminLTE3/images/load.gif' width='160px' height='160px' />",  css: { border: 'none', background: 'none' }  });
  //setTimeout(unBlock, 5000); 
  // var base_url  = window.location.origin;
  //   $('#preload').block({
  //      message: "<div class='loader'><img src='"+base_url+"/codeigneter-3.1.11/AdminLTE3/images/load2.gif' width='120px' height='120px' /></div>",  css: { border: 'none', background: 'none'} 
  //   });

}

function unBlock() {
  $.unblockUI();
  //$('#preload').unblock();
}

function callpage(id, clsp, nvitem=''){ 
    //alert(id);
    if(id != ""){
    	var base_url  = window.location.origin;
        var dataString = 'content='+id;
        block();
        $.ajax({
            type : "POST",
            url  : id,
            data : dataString,
            success: function(result){
            	    //$("#load-content").hide();
            	    unBlock();
                    $("#body-ctntl").html(result);
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    
                    //active class a
                    $('a.active').removeClass('active');
                    $('#'+clsp).addClass('active');
                    //
                    

                    //active class li
                  //   if(nvitem != ""){
	                 //    $('li').removeClass('active');
	                 //    $('#'+nvitem).addClass('active');
	                 // }
                    //

                    //document.getElementById(clsp).classList.add('active');
                	//$(this).addClass('active');

                }});
    }
    else{
        alert("Ooops Terjadi Kesalahan, Silahkan Coba Lagi Nanti.");
    }
}


function blockForm(param){
	var base_url  = window.location.origin;
	$('#'+param).block({
       message: "<img src='"+base_url+"/codeigneter-3.1.11/AdminLTE3/images/load2.gif' width='120px' height='120px' />",  css: { border: 'none', background: 'none' } 
    });
}

function unblockForm(param) {
 	$('#'+param).unblock();
}



//get merk
function getMerk(id) {
    $("#addmerk").modal('show');
    //if(id > 0){
        //var base_url = window.location.origin;
        //alert(id);
        $.ajax({
            type: "GET",
            url : "merk/viewMerk/view/"+id,
            success: function(data) {
                $("#id").val(data.MerkID);
                $("#merk").val(data.MerkName);
                $("#merk").focus();
            }
        });
    //}
    return false;
}



function merkSave() {
    //e.preventDefault();
    var f_asal  = $("#f_merk");
    var form    = getFormData(f_asal);

    //idx vlue
    var merk    = $("#merk").val();

    if(merk == ""){
        $("#notif-merk").show("slow");
        $('#notif-merk').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Merk Name</div>');   
        $('#notif-merk').delay(2000).hide(2000);
        $("#merk").focus();
    }
    else{
        blockForm("blokform");
        $.ajaxFileUpload({
            url             : 'merk/viewMerk/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        $('#addmerk').modal('toggle');
                        unblockForm("blokform");
                        callpage("merk/viewMerk", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else {
                        $("#notif-merk").show("slow");
                        unblockForm("blokform");
                        $('#notif-merk').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> Failed To Save</div>');
                        $('#notif-merk').delay(3000).hide(2000);
                    }
            }
        });

    }

    return false;
}


function merkDelete(id) {
    if (confirm('Are You Sure Delete..?')) {
        $.ajax({
            type: "GET",
            url: "merk/viewMerk/delete/"+id,
            success: function(response) {
                if (response.status == "ok") {
                    callpage("merk/viewMerk", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-trash"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                } else {
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}


//get customer
function getCar(id) {
    $("#addcar").modal('show');

        var base_url = window.location.origin;
        //alert(idcust);

    // SELECT CarID, CarName, CarCat, CarNumber, CarSeat, CarBuyYear, CarImage, MerkID, 
    // DailyRentalFee, DailyRentalFines, IsActive, EntryDate, EntryBy, LastUpdateDate, LastUpdateBy FROM M_MasterCar WHERE 1
        $.ajax({
            type: "GET",
            url : "car/ViewCar/view/"+id,
            success: function(data) {
                $("#id").val(data.CarID);
                $("#carname").val(data.CarName);
                $("#carcat").val(data.CarCat);
                $("#carnumber").val(data.CarNumber);
                $("#carseat").val(data.CarSeat);
                $("#carbuy").val(data.CarBuyYear);
                $("#merkid").val(data.MerkID);
                $("#dailyfee").val(data.DailyRentalFee);
                $("#dailyfines").val(data.DailyRentalFines);
                if(data.IsActive == "N"){
                    $("#viewinfo").html('<font color="red"><i style="font-size: 12px;">*Car is deleted</i></font>');
                }
                else{
                    $("#viewinfo").html('');
                }
                //$("#userfile").val(data.OrderImage);

                if(id != 0){
                    $("#viewgambar").html("<img src='"+base_url+"/codeigneter-3.1.11/upload/car/"+data.CarImage+"' width='80' height='90'>");
                }
                else{
                    $("#viewgambar").html("");
                }

                $("#carname").focus();
            }
        });

    return false;
}

//customer save
function CarSave() {
    //e.preventDefault();
    var f_asal  = $("#f_car");
    var form    = getFormData(f_asal);

    //idx vlue
    var carname     = $("#carname").val();
    var carcat      = $("#carcat").val();
    var carnumber   = $("#carnumber").val();
    var carseat     = $("#carseat").val();
    var carbuy      = $("#carbuy").val();
    var dailyfee    = $("#dailyfee").val();
    var dailyfines  = $("#dailyfines").val();

    var imgbrh      = $("#userfile").val();
    var idx         = $("#id").val();

    if(carname == ""){
        $("#notif-car").show("slow");
        $('#notif-car').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Car Name</div>');   
        $('#notif-car').delay(2000).hide(2000);
        $("#carname").focus();
    }
    else if(carcat == ""){
        $("#notif-car").show("slow");
        $('#notif-car').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Car Cat</div>');    
        $('#notif-car').delay(2000).hide(2000);
        $("#carcat").focus();
    }
    else if(carnumber == ""){
        $("#notif-car").show("slow");
        $('#notif-car').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Car Number</div>');  
        $('#notif-car').delay(2000).hide(2000);
        $("#carnumber").focus();
    }
    else if(carseat == ""){
        $("#notif-car").show("slow");
        $('#notif-car').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Car Seat</div>');    
        $('#notif-car').delay(2000).hide(2000);
        $("#carseat").focus();
    }
    else if(carbuy == ""){
        $("#notif-car").show("slow");
        $('#notif-car').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Car Buy Year</div>');    
        $('#notif-car').delay(2000).hide(2000);
        $("#carbuy").focus();
    }
    else if(dailyfee == ""){
        $("#notif-car").show("slow");
        $('#notif-car').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert DailyRentalFee</div>');    
        $('#notif-car').delay(2000).hide(2000);
        $("#dailyfee").focus();
    }
    else if(dailyfines == ""){
        $("#notif-car").show("slow");
        $('#notif-car').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert DailyRentalFines</div>');    
        $('#notif-car').delay(2000).hide(2000);
        $("#dailyfines").focus();
    }
    else if(imgbrh == "" && idx == 0){
        $("#notif-car").show("slow");
        $('#notif-car').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Upload Car Image file format .jpg .png</div>'); 
        $('#notif-car').delay(2000).hide(2000);
        $("#userfile").focus();
    }
    else{
        blockForm("blokform");
        $.ajaxFileUpload({
            url             : 'car/viewCar/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        $('#addcar').modal('toggle');
                        unblockForm("blokform");
                        //$('#getserviceimage').modal('hide');
                        callpage("car/viewCar", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else {
                        //$('#konfirmasi').html('<div class="alert alert-danger">Failed To Save</div>');
                        $("#notif-car").show("slow");
                        unblockForm("blokform");
                        $('#notif-car').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> '+d.msg+'</div>');
                        $('#notif-car').delay(3000).hide(2000);
                        $("#"+d.focus).focus();
                    }

                    
            }
        });

    }
    return false;
}


function CarDelete(id) {
    if (confirm('Are You Sure Delete..?')) {
        $.ajax({
            type: "GET",
            url: "car/viewCar/delete/"+id,
            success: function(response) {
                if (response.status == "ok") {
                    callpage("car/viewCar", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-trash"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                } else {
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}



//get customer
function getDriver(id) {
    $("#adddriver").modal('show');
    //if(id > 0){
        var base_url = window.location.origin;
        var idcust   = $('#numberingdriv').val();

        //alert(idcust);
        $.ajax({
            type: "GET",
            url : "driver/viewDriver/view/"+id,
            success: function(data) {
                $("#id").val(data.DriverID);
                if(id != 0){
                    $("#driverid").val(data.DriverID);
                }
                else{
                    $("#driverid").val(idcust);   
                }
                $("#drivername").val(data.DriverName);
                $("#mobphone").val(data.MobilePhone);
                $("#homephone").val(data.HomePhone);
                $("#identityid").val(data.IdentityID);
                $("#addres").val(data.Address);
                $("#email").val(data.Email);
                if(data.IsActive == "N"){
                    $("#viewinfo").html('<font color="red"><i style="font-size: 12px;">*Driver is deleted</i></font>');
                }
                else{
                    $("#viewinfo").html('');
                }
                $("#dailyfee").val(data.DailyDrivingCosts);

                if(id != 0){
                    $("#viewgambar").html("<img src='"+base_url+"/codeigneter-3.1.11/upload/driver/"+data.DriverImage+"' width='80' height='90'>");
                }
                else{
                    $("#viewgambar").html("");
                }

                $("#drivername").focus();
            }
        });
    //}
    return false;
}


//driver save
function DriverSave() {
    //e.preventDefault();
    var f_asal  = $("#f_driver");
    var form    = getFormData(f_asal);

    //idx vlue
    var driv        = $("#driverid").val();
    var drivname    = $("#drivername").val();
    var mobphone    = $("#mobphone").val();
    var homephone   = $("#homephone").val();
    var identityid  = $("#identityid").val();
    var addres      = $("#addres").val();
    var dailyfee    = $("#dailyfee").val();
    var email       = $("#email").val();

    var imgbrh      = $("#userfile").val();
    var idx         = $("#id").val();

    if(driv == ""){
        $("#notif-driver").show("slow");
        $('#notif-driver').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Driver ID</div>');   
        $('#notif-driver').delay(2000).hide(2000);
        $("#driverid").focus();
    }
    else if(drivname == ""){
        $("#notif-driver").show("slow");
        $('#notif-driver').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Driver Name</div>');    
        $('#notif-driver').delay(2000).hide(2000);
        $("#drivername").focus();
    }
    else if(mobphone == ""){
        $("#notif-driver").show("slow");
        $('#notif-driver').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert MobilePhone</div>');  
        $('#notif-driver').delay(2000).hide(2000);
        $("#mobphone").focus();
    }
    else if(homephone == ""){
        $("#notif-driver").show("slow");
        $('#notif-driver').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert HomePhone</div>');    
        $('#notif-driver').delay(2000).hide(2000);
        $("#homephone").focus();
    }
    else if(identityid == ""){
        $("#notif-driver").show("slow");
        $('#notif-driver').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert IdentityID</div>');    
        $('#notif-driver').delay(2000).hide(2000);
        $("#identityid").focus();
    }
    else if(addres == ""){
        $("#notif-driver").show("slow");
        $('#notif-driver').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Address</div>');    
        $('#notif-driver').delay(2000).hide(2000);
        $("#addres").focus();
    }
    else if(email == ""){
        $("#notif-driver").show("slow");
        $('#notif-driver').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Email</div>');    
        $('#notif-driver').delay(2000).hide(2000);
        $("#email").focus();
    }
     else if(dailyfee == ""){
        $("#notif-driver").show("slow");
        $('#notif-driver').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Daily Driver Costs</div>');    
        $('#notif-driver').delay(2000).hide(2000);
        $("#dailyfee").focus();
    }
    else if(imgbrh == "" && idx == 0){
        $("#notif-driver").show("slow");
        $('#notif-driver').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Upload Customer Image file format .jpg .png</div>'); 
        $('#notif-driver').delay(2000).hide(2000);
        $("#userfile").focus();
    }
    else{
        blockForm("blokform");
        $.ajaxFileUpload({
            url             : 'driver/viewDriver/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        //$('#konfirmasi').html('<div class="alert alert-success">'+d.msg+'</div>');            
                        //window.location.assign("tampil_service");
                        $('#adddriver').modal('toggle');
                        unblockForm("blokform");
                        //$('#getserviceimage').modal('hide');
                        callpage("driver/viewDriver", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else {
                        //$('#konfirmasi').html('<div class="alert alert-danger">Failed To Save</div>');
                        $("#notif-driver").show("slow");
                        unblockForm("blokform");
                        $('#notif-driver').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> '+d.msg+'</div>');
                        $('#notif-driver').delay(3000).hide(2000);
                        $("#"+d.focus).focus();
                    }

                    
            }
        });

    }
    return false;
}


function driverDelete(id) {
    if (confirm('Are You Sure Delete..?')) {
        $.ajax({
            type: "GET",
            url: "driver/viewDriver/delete/"+id,
            success: function(response) {
                if (response.status == "ok") {
                    callpage("driver/viewDriver", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-trash"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                } else {
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}



//get customer
function getCustomer(id) {
    $("#addcustomer").modal('show');
    //if(id > 0){
        var base_url = window.location.origin;
        var idcust   = $('#numberingcust').val();
        //alert(idcust);
        $.ajax({
            type: "GET",
            url : "customer/viewCustomer/view/"+id,
            success: function(data) {
                $("#id").val(data.OrderID);
                if(id != 0){
                    $("#custid").val(data.OrderID);
                }
                else{
                    $("#custid").val(idcust);   
                }
                $("#custname").val(data.CustomerName);
                $("#mobphone").val(data.MobilePhone);
                $("#homephone").val(data.HomePhone);
                $("#identityid").val(data.IdentityID);
                $("#addres").val(data.Address);
                $("#email").val(data.Email);
                if(data.IsActive == "N"){
                    $("#viewinfo").html('<font color="red"><i style="font-size: 12px;">*customer is deleted</i></font>');
                }
                else{
                    $("#viewinfo").html('');
                }
                //$("#userfile").val(data.OrderImage);

                if(id != 0){
                    $("#viewgambar").html("<img src='"+base_url+"/codeigneter-3.1.11/upload/customer/"+data.OrderImage+"' width='80' height='90'>");
                    $("#gender").val(data.Gender);
                }
                else{
                    $("#viewgambar").html("");
                    $("#gender").val("M");
                }

                $("#custname").focus();
            }
        });
    //}
    return false;
}


//customer save
function CustomerSave() {
    //e.preventDefault();
    var f_asal  = $("#f_customer");
    var form    = getFormData(f_asal);

    //idx vlue
    var custid      = $("#custid").val();
    var custname    = $("#custname").val();
    var mobphone    = $("#mobphone").val();
    var homephone   = $("#homephone").val();
    var identityid  = $("#identityid").val();
    var addres      = $("#addres").val();
    var gender      = $("#gender").val();
    var email       = $("#email").val();

    var imgbrh      = $("#userfile").val();
    var idx         = $("#id").val();

    if(custid == ""){
        $("#notif-customer").show("slow");
        $('#notif-customer').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Customer ID</div>');   
        $('#notif-customer').delay(2000).hide(2000);
        $("#custid").focus();
    }
    else if(custname == ""){
        $("#notif-customer").show("slow");
        $('#notif-customer').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert CustomerName</div>');    
        $('#notif-customer').delay(2000).hide(2000);
        $("#custname").focus();
    }
    else if(mobphone == ""){
        $("#notif-customer").show("slow");
        $('#notif-customer').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert MobilePhone</div>');  
        $('#notif-customer').delay(2000).hide(2000);
        $("#mobphone").focus();
    }
    else if(homephone == ""){
        $("#notif-customer").show("slow");
        $('#notif-customer').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert HomePhone</div>');    
        $('#notif-customer').delay(2000).hide(2000);
        $("#homephone").focus();
    }
    else if(identityid == ""){
        $("#notif-customer").show("slow");
        $('#notif-customer').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert IdentityID</div>');    
        $('#notif-customer').delay(2000).hide(2000);
        $("#identityid").focus();
    }
    else if(addres == ""){
        $("#notif-customer").show("slow");
        $('#notif-customer').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Address</div>');    
        $('#notif-customer').delay(2000).hide(2000);
        $("#addres").focus();
    }
    else if(email == ""){
        $("#notif-customer").show("slow");
        $('#notif-customer').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Email</div>');    
        $('#notif-customer').delay(2000).hide(2000);
        $("#email").focus();
    }
    else if(imgbrh == "" && idx == 0){
        $("#notif-customer").show("slow");
        $('#notif-customer').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Upload Customer Image file format .jpg .png</div>'); 
        $('#notif-customer').delay(2000).hide(2000);
        $("#userfile").focus();
    }
    else{
        blockForm("blokform");
        $.ajaxFileUpload({
            url             : 'customer/viewCustomer/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        //$('#konfirmasi').html('<div class="alert alert-success">'+d.msg+'</div>');            
                        //window.location.assign("tampil_service");
                        $('#addcustomer').modal('toggle');
                        unblockForm("blokform");
                        //$('#getserviceimage').modal('hide');
                        callpage("customer/viewCustomer", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else {
                        //$('#konfirmasi').html('<div class="alert alert-danger">Failed To Save</div>');
                        $("#notif-customer").show("slow");
                        unblockForm("blokform");
                        $('#notif-customer').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> '+d.msg+'</div>');
                        $('#notif-customer').delay(3000).hide(2000);
                        $("#"+d.focus).focus();
                    }

                    
            }
        });

    }
    return false;
}


function CustomerDelete(id) {
    if (confirm('Are You Sure Delete..?')) {
        $.ajax({
            type: "GET",
            url: "customer/viewCustomer/delete/"+id,
            success: function(response) {
                if (response.status == "ok") {
                    callpage("customer/viewCustomer", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-trash"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                } else {
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}



//get payment
function getPaymenttype(id) {
    $("#addpaytype").modal('show');
        $.ajax({
            type: "GET",
            url : "paymenttype/viewPaymenttype/view/"+id,
            success: function(data) {
                $("#id").val(data.PaymentID);
                $("#paytype").val(data.PaymentType);
                $("#paytype").focus();
            }
        });
    //}
    return false;
}



function PaymenttypeSave() {
    //e.preventDefault();
    var f_asal  = $("#f_paytype");
    var form    = getFormData(f_asal);

    //idx vlue
    var paytype    = $("#paytype").val();

    if(paytype == ""){
        $("#notif-paytype").show("slow");
        $('#notif-paytype').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Payment Type</div>');   
        $('#notif-paytype').delay(2000).hide(2000);
        $("#paytype").focus();
    }
    else{
        blockForm("blokform");
        $.ajaxFileUpload({
            url             : 'paymenttype/viewPaymenttype/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        $('#addpaytype').modal('toggle');
                        unblockForm("blokform");
                        callpage("paymenttype/viewPaymenttype", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else {
                        $("#notif-merk").show("slow");
                        unblockForm("blokform");
                        $('#notif-merk').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> Failed To Save</div>');
                        $('#notif-merk').delay(3000).hide(2000);
                    }
            }
        });

    }

    return false;
}


function PaymenttypeDelete(id) {
    if (confirm('Are You Sure Delete..?')) {
        $.ajax({
            type: "GET",
            url: "paymenttype/viewPaymenttype/delete/"+id,
            success: function(response) {
                if (response.status == "ok") {
                    callpage("paymenttype/viewPaymenttype", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-trash"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                } else {
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}



function getRental(id) {
    $("#addrental").modal('show');
    var idrent = $("#numberingrent").val();
        $.ajax({
            type: "GET",
            url : "rental/viewRental/view/"+id,
            success: function(data) {
                $("#id").val(data.RentalID);
                 if(id != 0){
                    $("#rentalid").val(data.RentalID);
                }
                else{
                    $("#rentalid").val(idrent);   
                }
                //$("#rentalid").val(data.RentalID);
                $("#custid").val(data.OrderID);
                $("#custname").val(data.CustomerName);
                $("#carid").val(data.CarID);
                $("#carname").val(data.CarName);
                $("#startdate").val(data.StartDate);
                $("#enddate").val(data.EndDate);
                $("#rentalcost").val(data.RentalCosts);
                $("#paymentid").val(data.PaymentID);
                $("#custid ").focus();

            }
        });
    //}
    return false;
}


//customer save
function RentalSave() {
    //e.preventDefault();
    var f_asal  = $("#f_rental");
    var form    = getFormData(f_asal);

    //idx vlue
    var rentid      = $("#rentalid").val();
    var custid      = $("#custid").val();
    var custname    = $("#custname").val();
    var carid       = $("#carid").val();
    var carname     = $("#carname").val();
    var rentcost    = $("#rentalcost").val();
    var startdate   = $("#startdate").val();
    var enddate     = $("#enddate").val();
    var paymentid   = $("#paymentid").val();


    if(rentid == ""){
        $("#notif-rental").show("slow");
        $('#notif-rental').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert RentalID</div>');   
        $('#notif-rental').delay(2000).hide(2000);
        $("#rentalid").focus();
    }
    else if(custid == ""){
        $("#notif-rental").show("slow");
        $('#notif-rental').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Customer ID</div>');   
        $('#notif-rental').delay(2000).hide(2000);
        $("#custid").focus();
    }
    else if(custname == ""){
        $("#notif-rental").show("slow");
        $('#notif-rental').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert CustomerName</div>');    
        $('#notif-rental').delay(2000).hide(2000);
        $("#custname").focus();
    }
    else if(carid == ""){
        $("#notif-rental").show("slow");
        $('#notif-rental').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert CarID</div>');  
        $('#notif-rental').delay(2000).hide(2000);
        $("#carid").focus();
    }
    else if(carname == ""){
        $("#notif-rental").show("slow");
        $('#notif-rental').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert RentalCosts</div>');    
        $('#notif-rental').delay(2000).hide(2000);
        $("#carname").focus();
    }
    else if(rentcost == ""){
        $("#notif-rental").show("slow");
        $('#notif-rental').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert IdentityID</div>');    
        $('#notif-rental').delay(2000).hide(2000);
        $("#rentalcost").focus();
    }
    else if(startdate == ""){
        $("#notif-rental").show("slow");
        $('#notif-rental').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert StartDate</div>');    
        $('#notif-rental').delay(2000).hide(2000);
        $("#startdate").focus();
    }
    else if(enddate == ""){
        $("#notif-rental").show("slow");
        $('#notif-rental').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert EndDate</div>');    
        $('#notif-rental').delay(2000).hide(2000);
        $("#enddate").focus();
    }
    else if(paymentid == ""){
        $("#notif-rental").show("slow");
        $('#notif-rental').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert PaymentID</div>');    
        $('#notif-rental').delay(2000).hide(2000);
        $("#paymentid").focus();
    }
    else{
        blockForm("blokform");
        $.ajaxFileUpload({
            url             : 'rental/viewRental/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        //$('#konfirmasi').html('<div class="alert alert-success">'+d.msg+'</div>');            
                        //window.location.assign("tampil_service");
                        $('#addrental').modal('toggle');
                        unblockForm("blokform");
                        //$('#getserviceimage').modal('hide');
                        callpage("rental/viewRental", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else if(d.status == 'post') {
                        $('#addrental').modal('toggle');
                        unblockForm("blokform");
                        //$('#getserviceimage').modal('hide');
                        callpage("rental/viewRental", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-warning"><i class="fas fa-info"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else {
                        //$('#konfirmasi').html('<div class="alert alert-danger">Failed To Save</div>');
                        $("#notif-rental").show("slow");
                        unblockForm("blokform");
                        $('#notif-rental').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> '+d.msg+'</div>');
                        $('#notif-rental').delay(3000).hide(2000);
                        $("#"+d.focus).focus();
                    }

                    
            }
        });

    }
    return false;
}



function RentalPost(id) {
    if (confirm('Are You Sure Post Data '+id+' ..?')) {
        $.ajax({
            type: "GET",
            url: "rental/viewRental/post/"+id,
            success: function(response) {
                if (response.status == "ok") {
                    callpage("rental/viewRental", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-check"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                }
                else if (response.status == "post") {
                    //callpage("rental/viewRental", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                }
                 else {
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}



function RentalDelete(id) {
    if (confirm('Are You Sure Delete..?')) {
        $.ajax({
            type: "GET",
            url: "rental/viewRental/delete/"+id,
            success: function(response) {
                if (response.status == "ok") {
                    callpage("rental/viewRental", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-trash"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                }
                else if (response.status == "post") {
                    //callpage("rental/viewRental", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                }
                else {
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}



//return data

function callblur(id) {
    $("#addreturn").modal('show');
    blockForm("blokform");
    //alert("ok");
    //if(id > 0){
        var base_url = window.location.origin;
        $.ajax({
            type: "GET",
            url : "rental/viewRental/view/"+id,
            success: function(data) {
                //$("#rentalid").val(data.RentalID);
                //$("#custid").val(data.OrderID);
                $("#custname").val(data.CustomerName);
                $("#carid").val(data.CarID);
                $("#carname").val(data.CarName);
                $("#startdate").val(data.StartDate);
                $("#enddate").val(data.EndDate);
                $("#driverid").val(data.DriverID);
                $("#dailyrent").val(data.DailyRentalFines);
                $("#dailycost").val(data.DailyDrivingCosts);
                $("#returndate ").focus();

                unblockForm("blokform");
            }
        });
    //}
    return false;
}

function getReturn(id) {
    $("#addreturn").modal('show');
    var idretr = $("#numberingretr").val();
        $.ajax({
            type: "GET",
            url : "returncar/viewReturn/view/"+id,
            success: function(data) {
                $("#id").val(data.ReturnID);
                 if(id != 0){
                    $("#returnid").val(data.ReturnID);
                    $("#returndate ").focus();
                }
                else{
                    $("#returnid").val(idretr); 
                    $("#rentalid ").focus();  
                }
                $("#rentalid").val(data.RentalID);
                $("#returndate").val(data.ReturnDate);
                $("#latecharge").val(data.LateCharge);

                $("#custname").val(data.CustomerName);
                $("#carid").val(data.CarID);
                $("#carname").val(data.CarName);
                $("#startdate").val(data.StartDate);
                $("#enddate").val(data.EndDate);
                $("#driverid").val(data.DriverID);
                $("#dailyrent").val(data.DailyRentalFines);
                $("#dailycost").val(data.DailyDrivingCosts);

            }
        });
    //}
    return false;
}


function ReturnSave() {
    //e.preventDefault();
    var f_asal  = $("#f_retrun");
    var form    = getFormData(f_asal);

    //idx vlue
    var rentid      = $("#rentalid").val();
    var returndate  = $("#returndate").val();
   
    if(rentid == ""){
        $("#notif-return").show("slow");
        $('#notif-return').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert RentalID</div>');   
        $('#notif-return').delay(2000).hide(2000);
        $("#rentalid").focus();
    }
    else if(returndate == ""){
        $("#notif-return").show("slow");
        $('#notif-return').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Return Date</div>');   
        $('#notif-return').delay(2000).hide(2000);
        $("#returndate").focus();
    }
    else{
        blockForm("blokform");
        $.ajaxFileUpload({
            url             : 'returncar/viewReturn/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        //$('#konfirmasi').html('<div class="alert alert-success">'+d.msg+'</div>');            
                        //window.location.assign("tampil_service");
                        $('#addreturn').modal('toggle');
                        unblockForm("blokform");
                        //$('#getserviceimage').modal('hide');
                        callpage("returncar/viewReturn/", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else if(d.status == 'post') {
                        $('#addreturn').modal('toggle');
                        unblockForm("blokform");
                        //$('#getserviceimage').modal('hide');
                        callpage("returncar/viewReturn/", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-warning"><i class="fas fa-info"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else {
                        //$('#konfirmasi').html('<div class="alert alert-danger">Failed To Save</div>');
                        $("#notif-rental").show("slow");
                        unblockForm("blokform");
                        $('#notif-rental').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> '+d.msg+'</div>');
                        $('#notif-rental').delay(3000).hide(2000);
                        $("#"+d.focus).focus();
                    }

                    
            }
        });

    }
    return false;
}


function ReturnPost(id) {
    if (confirm('Are You Sure Post Data '+id+' ..?')) {
        $.ajax({
            type: "GET",
            url: "returncar/viewReturn/post/"+id,
            success: function(response) {
                if (response.status == "ok") {
                    callpage("returncar/viewReturn", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-check"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                }
                else if (response.status == "post") {
                    //callpage("rental/viewRental", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                }
                 else {
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}


function ReturnDelete(id) {
    if (confirm('Are You Sure Delete..?')) {
        $.ajax({
            type: "GET",
            url: "returncar/viewReturn/delete/"+id,
            success: function(response) {
                if (response.status == "ok") {
                    callpage("returncar/viewReturn", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-trash"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                }
                else if (response.status == "post") {
                    //callpage("returncar/viewReturn", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                }
                else {
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}



function UploadImage() {
    var f_asal  = $("#f_admin");
    var form    = getFormData(f_asal);

        $.ajaxFileUpload({
            url             : 'profile/viewProfile/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        //$('#konfirmasi').html('<div class="alert alert-success">'+d.msg+'</div>');            
                        //window.location.assign("tampil_service");
                        //$('#getcaption').modal('toggle');
                        //$('#getserviceimage').modal('hide');
                        callpage("profile/viewProfile", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else {
                        //$('#konfirmasi').html('<div class="alert alert-danger">Failed To Save</div>');
                        $("#notif-admin").show("slow");
                        $('#notif-admin').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> '+d.msg+'</div>');
                        $('#notif-admin').delay(3000).hide(2000);
                        $("#"+d.focus).focus();
                    }

            }
        });

    return false;
}


// function setLateChargeRent(str, edt){
//     alert(daysDifference(str, edt));
//     return daysDifference(str, edt);
// }


// function daysDifference(d0, d1) {
//   var diff = new Date(+d1).setHours(12) - new Date(+d0).setHours(12);
//   return Math.round(diff/8.64e7);
// }



//report
function ReportcarSearch() {
    //e.preventDefault();
    var f_asal  = $("#r_car");
    var form    = getFormData(f_asal);

    //idx vlue
    var carname = $("#carname").val();
    var effdate = $("#effdate").val();
    var merkid  = $("#merkid").val();
   
    if(effdate == ""){
        $("#notif-rpt").show("slow");
        $('#notif-rpt').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Effective Date</div>');   
        $('#notif-rpt').delay(2000).hide(2000);
        $("#effdate").focus();
    }
    // else if(merkid == ""){
    //     $("#notif-rpt").show("slow");
    //     $('#notif-rpt').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert MerkID</div>');   
    //     $('#notif-rpt').delay(2000).hide(2000);
    //     $("#merkid").focus();
    // }
    else{
        block();
        $.ajax({
            url             : 'reportcar/viewReportCar/view', 
            type            : "POST",
            data            : form,
            success : function (result) {
                //alert("ok"); 
                $("#content-rpt").html(result);
                unBlock();       
            }
        });

    }
    return false;
}


function ReportrentSearch() {
    //e.preventDefault();
    var f_asal  = $("#r_rent");
    var form    = getFormData(f_asal);

    //idx vlue
    var sdate  = $("#startdate").val();
    var edate  = $("#enddate").val();
   
    if(sdate == ""){
        $("#notif-rpt").show("slow");
        $('#notif-rpt').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Start Date</div>');   
        $('#notif-rpt').delay(2000).hide(2000);
        $("#startdate").focus();
    }
    else if(edate == ""){
        $("#notif-rpt").show("slow");
        $('#notif-rpt').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert End Date</div>');   
        $('#notif-rpt').delay(2000).hide(2000);
        $("#enddate").focus();
    }
    else{
        block();
        $.ajax({
            url             : 'reportrent/viewReportRent/view', 
            type            : "POST",
            data            : form,
            success : function (result) {
                //alert("ok"); 
                if(result){
                    $("#content-rpt").html(result);
                    unBlock();    
                }
                else{
                    $("#notif-msg").show("slow");
                    unBlock();
                    $('#notif-msg').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Record Not Found </div>');
                    $('#notif-msg').delay(3000).hide(2000);
                    $("#custname").focus();
                }   
            }
            // else {
            //     console.log('gagal'+result);
            // }
        });

    }
    return false;
}




//branch maps
function getUser(id) {
    $("#addformuser").modal('show');
    //if(id > 0){
        //var base_url = window.location.origin;
        var d = new Date(),
                month = '' + (d.getMonth() + 1),
                day   = '' + d.getDate(),
                year  = d.getFullYear();
        
            if (month.length < 2) {
                month = '0' + month;
            }
            if (day.length < 2) {
                day   = '0' + day;
            }
        var todaydate= year+"-"+month+"-"+day;
            
        $.ajax({
            type: "GET",
            url : "user/viewUser/view/"+id,
            success: function(data) {
                $("#id").val(data.AdminID);
                $("#nama").val(data.AdminName);
                if(id != 0){
                    //$("#username").disable();
                    //document.getElementById("username").disabled = true; //disable form
                    //$('#username').prop("disabled", true);
                    $("#username").prop("readonly", true);
                    $("#birthday").val(data.DateOfBirth);
                    $("#supuser").val(data.SuperUser);
                }
                else{
                    document.getElementById("username").disabled = false; //disable form
                    $("#birthday").val(todaydate);
                    $("#supuser").val("N");
                }
                $("#email").val(data.email);
                $("#username").val(data.UserName);
                $("#nama").focus();
            }
        });
    //}
    return false;
}



function UserSave() {
    //e.preventDefault();
    var f_asal  = $("#f_user");
    var form    = getFormData(f_asal);

    //idx vlue
    var adminnm     = $("#nama").val();
    var birthday    = $("#birthday").val();
    var email       = $("#email").val();
    var username    = $("#username").val();
    var password    = $("#password").val();
    var rpassword   = $("#repassword").val();

    if(adminnm == ""){
        $("#notif-user").show("slow");
        $('#notif-user').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Name</div>'); 
        $('#notif-user').delay(2000).hide(2000);
        $("#nama").focus();
    }
    else if(birthday == ""){
        $("#notif-user").show("slow");
        $('#notif-user').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Birthday</div>'); 
        $('#notif-user').delay(2000).hide(2000);
        $("#birthday").focus();
    }
    else if(email == ""){
        $("#notif-user").show("slow");
        $('#notif-user').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Email</div>');    
        $('#notif-user').delay(2000).hide(2000);
        $("#email").focus();
    }
    else if(username == ""){
        $("#notif-user").show("slow");
        $('#notif-user').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert UserName</div>'); 
        $('#notif-user').delay(2000).hide(2000);
        $("#username").focus();
    }
    // else if(password == ""){
    //     $("#notif-user").show("slow");
    //     $('#notif-user').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert password</div>'); 
    //     $('#notif-user').delay(2000).hide(2000);
    //     $("#password").focus();
    // }
    // else if(rpassword == ""){
    //     $("#notif-user").show("slow");
    //     $('#notif-user').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Re password</div>');  
    //     $('#notif-user').delay(2000).hide(2000);
    //     $("#repassword").focus();
    // }
    else{
        blockForm("blokformuser");
        
        $.ajaxFileUpload({
            url             : 'user/viewUser/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        unblockForm("blokformuser");
                        $('#addformuser').modal('toggle');

                        
                        $("#notif-msg").show("slow");
                        callpage("user/viewUser", '', '');
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);
                        //$('#addformuser').modal('hide');

                    } 
                    else {
                        if(d.focus == "repassword"){
                            $("#notif-user").show("slow");
                            unblockForm("blokformuser");
                            $('#notif-user').html('<div class="alert alert-danger">'+d.msg+'</div>');
                            $('#notif-user').delay(3000).hide(2000);
                            $("#repassword").focus();
                        }
                        else{
                            //$('#konfirmasi').html('<div class="alert alert-danger">'+d.msg+'</div>');
                            $("#notif-user").show("slow");
                            unblockForm("blokformuser");
                            $('#notif-user').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> Failed To Save</div>');
                            $('#notif-user').delay(3000).hide(2000);
                        }
                    }
            }
        });
    }

    return false;
}


function UserDelete(id) {
    if (confirm('Are You Sure Delete..?')) {
        $.ajax({
            type: "GET",
            url: "user/viewUser/delete/"+id,
            success: function(response) {
                if (response.status == "ok") {
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    // window.location.assign("tampil_user"); 
                    // $('#notif_user').html('<div class="alert alert-success">'+response.caption+'</div>');    
                    // $("#notif_user").each(function(){
                    //                 var delay = '50000';
                    //                 HideNotif($(this), delay);
                    //             });
                    callpage("user/viewUser", '', '');
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-trash"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);


                } else {
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}


//setupprofile
function StpProfileSave() {
    //e.preventDefault();
    var f_asal  = $("#f_setup");
    var form    = getFormData(f_asal);

    //idx vlue
    var stpidx      = $("#stpidx").val();
    var stpname     = $("#stpname").val();
    var stptitle    = $("#stptitle").val();
    var stpdesc     = $("#stpdesc").val();
    
    var imgbrh      = $("#userfile").val();

    if(stpidx == ""){
        $("#notif-stpprofile").show("slow");
        $('#notif-stpprofile').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Setup ID</div>');   
        $('#notif-stpprofile').delay(2000).hide(2000);
        $("#stpidx").focus();
    }
    else if(stpname == ""){
        $("#notif-stpprofile").show("slow");
        $('#notif-stpprofile').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Setup Name</div>');    
        $('#notif-stpprofile').delay(2000).hide(2000);
        $("#stpname").focus();
    }
    else if(stptitle == ""){
        $("#notif-stpprofile").show("slow");
        $('#notif-stpprofile').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Setup title</div>');  
        $('#notif-stpprofile').delay(2000).hide(2000);
        $("#stptitle").focus();
    }
    else if(stpdesc == ""){
        $("#notif-stpprofile").show("slow");
        $('#notif-stpprofile').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Setup Description</div>');    
        $('#notif-stpprofile').delay(2000).hide(2000);
        $("#stpdesc").focus();
    }
    // else if(imgbrh == ""){
    //     $("#notif-stpprofile").show("slow");
    //     $('#notif-stpprofile').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Upload Profile Setup Image file format .jpg .png</div>'); 
    //     $('#notif-stpprofile').delay(2000).hide(2000);
    //     $("#userfile").focus();
    // }
    else{
        blockForm("blockstp");
        $.ajaxFileUpload({
            url             : 'setupprofile/viewSetupProfile/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        unblockForm("blockstp");
                        //location.href = location.href + "/LoadPage/refresh/setupprofile/viewSetupProfile";
                        //callpage("dasbor/LoadPage/refresh/setupprofile/viewSetupProfile", '', '');
                        //$('#getserviceimage').modal('hide');
                        callpage("setupprofile/viewSetupProfile", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else {
                        //$('#konfirmasi').html('<div class="alert alert-danger">Failed To Save</div>');
                        $("#notif-stpprofile").show("slow");
                        unblockForm("blockstp");
                        $('#notif-stpprofile').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> '+d.msg+'</div>');
                        $('#notif-stpprofile').delay(3000).hide(2000);
                        $("#"+d.focus).focus();
                    }

                    
            }
        });

    }
    return false;
}



function StpLogoSave() {
    //e.preventDefault();
    var f_asal  = $("#f_setupl");
    var form    = getFormData(f_asal);

    //idx vlue
    var stpidx      = $("#stpidx").val();
    
    var imgbrh      = $("#userfile").val();

    if(stpidx == ""){
        $("#notif-stpprofile").show("slow");
        $('#notif-stpprofile').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Setup ID</div>');   
        $('#notif-stpprofile').delay(2000).hide(2000);
        $("#stpidx").focus();
    }
    else if(imgbrh == ""){
        $("#notif-stpprofile").show("slow");
        $('#notif-stpprofile').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Upload Profile Setup Image file format .jpg .png</div>'); 
        $('#notif-stpprofile').delay(2000).hide(2000);
        $("#userfile").focus();
    }
    else{
        blockForm("blockstpl");
        $.ajaxFileUpload({
            url             : 'setuplogo/viewSetupLogo/save', 
            secureuri       : false,
            fileElementId   : 'userfile',
            data            : form,
            dataType        : 'jsonp',
            contentType     : 'text/javascript',
            success : function (data) {
                    var d = JSON.parse(data);
                    if(d.status == 'ok') {
                        unblockForm("blockstpl");
                        //$('#getserviceimage').modal('hide');
                        callpage("setuplogo/viewSetupLogo", '', '');
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+d.msg+'</div>'); 
                        $('#notif-msg').delay(3000).hide(2000);

                    } 
                    else {
                        //$('#konfirmasi').html('<div class="alert alert-danger">Failed To Save</div>');
                        $("#notif-stplogo").show("slow");
                        unblockForm("blockstpl");
                        $('#notif-stplogo').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> '+d.msg+'</div>');
                        $('#notif-stplogo').delay(3000).hide(2000);
                        $("#"+d.focus).focus();
                    }

                    
            }
        });

    }
    return false;
}