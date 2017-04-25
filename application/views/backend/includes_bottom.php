
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
    </script>>
<?php } ?> 
