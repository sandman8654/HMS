
<!-- Bottom Scripts -->
<script src="assets/js/gsap/main-gsap.js"></script>
<script src="assets/js/jquery-ui/jquery-ui-1.12.1/jquery-ui.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>
<script src="assets/js/bootstrap-switch.min.js"></script>
<script src="assets/js/toastr.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/fullcalendar/fullcalendar.min.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="assets/js/fileinput.js"></script>
<script src="assets/js/wysihtml5/wysihtml5-0.4.0pre.min.js"></script>
<script src="assets/js/wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="assets/js/jquery.multi-select.js"></script>
<script src="assets/js/jquery.knob.js"></script>
<script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
<script src="assets/js/jquery.inputmask.bundle.min.js"></script>
<script src="assets/js/daterangepicker/moment.min.js"></script>
<script src="assets/js/daterangepicker/daterangepicker.js"></script>

<link rel="stylesheet" href="assets/js/dropzone/dropzone.css">
<script src="assets/js/dropzone/dropzone.js"></script>

<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/datatables/TableTools.min.js"></script>
<script src="assets/js/dataTables.bootstrap.js"></script>
<script src="assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
<script src="assets/js/datatables/lodash.min.js"></script>
<script src="assets/js/datatables/responsive/js/datatables.responsive.js"></script>
<script src="assets/js/select2/select2.min.js"></script>

<script src="assets/js/neon-calendar.js"></script>
<script src="assets/js/neon-chat.js"></script>
<script src="assets/js/neon-custom.js"></script>
<script src="assets/js/neon-demo.js"></script>
<script src="assets/js/neon-notes.js"></script>
<script src="assets/js/jquery.form.js"></script>
<script src="assets/js/jquery-confirm/jquery-confirm.min.js"></script>
<script src="assets/js/ajax-form-submission.js"></script>
<script src="assets/js/functions.js"></script>

<script>
 //   $(".html5editor").wysihtml5();
</script>

<?php if ($this->session->flashdata('message') != ""){ ?>
    <script>
        toastr.info('<?php echo $this->session->flashdata('message');?>');
        <?php $this->session->set_flashdata('message', "");?>
    </script>>
<?php } ?> 
<script>

    // Numeric only control handler
jQuery.fn.ForceNumericOnly =
    function()
    {
        return this.each(function()
        {
            $(this).keydown(function(e)
            {
                var key = e.charCode || e.keyCode || 0;
                // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                // home, end, period, and numpad decimal
                return (
                    key == 8 || 
                    key == 9 ||
                    key == 13 ||
                    key == 46 ||
                    key == 110 ||
                    key == 190 ||
                    (key >= 35 && key <= 40) ||
                    (key >= 48 && key <= 57) ||
                    (key >= 96 && key <= 105));
            });
        });
    };

/*
* age calculator
*/
function age(d1){
    var birthdate = d1, // in   "mm/dd/yyyy" format
        now = new Date(),
        nowDateString = [now.getMonth()+1,now.getDate(),now.getYear()+1900].join("/");
    var nowdate = nowDateString; // in   "mm/dd/yyyy" format
    var x = birthdate.split("/");    
    var y = nowdate.split("/");
    var bdays = x[1];
    var bmonths = x[0];
    var byear = x[2];
    //alert(bdays);
    var sdays = y[1];
    var smonths = y[0];
    var syear = y[2];
    //alert(sdays);

    if(sdays < bdays)
    {
        sdays = parseInt(sdays) + 30;
        smonths = parseInt(smonths) - 1;
        //alert(sdays);
        var fdays = sdays - bdays;
        //alert(fdays);
    }
    else{
        var fdays = sdays - bdays;
    }

    if(smonths < bmonths)
    {
        smonths = parseInt(smonths) + 12;
        syear = syear - 1;
        var fmonths = smonths - bmonths;
    }
    else
    {
        var fmonths = smonths - bmonths;
    }

    var fyear = syear - byear;
    return fyear+' years '+fmonths+' months '+fdays+' days';
}
</script>

