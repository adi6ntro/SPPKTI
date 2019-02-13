    <?php if($this->session->userdata('logged_in')){ ?>
      </section>
    </div>
      <?php if($this->uri->segment(2) != "attempt"){ ?>
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; 2017 <a href="#">SPPKTI</a>.</strong> All rights reserved.
    </footer>
    </div>
    <?php
      }
    }
    ?>
    <script src="<?php echo base_url(); ?>assets/select2/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/daterangepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url();?>assets/iCheck/icheck.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/Chart.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/fastclick.js"></script>
    <script src="<?php echo base_url();?>assets/js/app.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/pace.min.js"></script>
    <?php if($this->uri->segment(2) != "kompetensi"){ ?>
      <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <?php } ?>
    <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-fileupload.js"></script>
    <script>
      $("#skema-select").on('change', function(){
        $(".sideBySide").empty();
        $.ajax({
          'url' : "<?php echo base_url();?>rule/get_table/"+$(this).val(),
          'method' : 'get',
          'success' : function(ab) {
            $(".sideBySide").html(ab);
            $(".source, .target").sortable({
              connectWith: ".connected"
            });
          }
        });
      });
      $(".saveRelasi").click(function(e) {
        e.preventDefault();
        var items = [];
        $(".sideBySide .target li").each(function() {
          //items.push(item);
          items.push($(this).attr('data-id'));
        });
        $.ajax({
          'url' : "<?php echo base_url();?>rule/update_relasi/"+$("#skema-select").val(),
          'method' : 'post',
          'data' : 'data='+JSON.stringify(items),
          success : function(ab) {
            console.log(ab);
          }
        }).fail(function(e) {
          console.log(e);
        });
      });
      $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
        Pace.restart();
      });
      $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
      });
      $(document).ready(function() {
        //Initialize Select2 Elements
        $('.thumbnailok').hover(
            function () {
                $(this).find('.captionok').slideDown(250); //.fadeIn(250)
            },
            function () {
                $(this).find('.captionok').slideUp(250); //.fadeOut(205)
            }
        );
        $(".select2").select2();
        $('#sim').dataTable( {
          "searching": false,
          "bSort" : false
        } );
        $("#tabel").DataTable();
        var oTable = $('#soal').DataTable({
          stateSave: true
        });
        var allPages = oTable.cells( ).nodes( );
        $('#selectAll').click(function () {
          if ($(this).hasClass('allChecked')) {
            $(allPages).find('input[type="checkbox"]').prop('checked', false);
          } else {
            $(allPages).find('input[type="checkbox"]').prop('checked', true);
          }
          $(this).toggleClass('allChecked');
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });
        $('#reservationtime').daterangepicker({
          timePicker: true, timePickerIncrement: 30,
          format: 'MM/DD/YYYY h:mm A'
        });
      });
      jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value !== "";
      }, "Space is not allowed");
      jQuery.validator.addMethod("regex",function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
      }, "Please check your input");
      $.validator.setDefaults({
        highlight: function(element) {
          $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
          $(element).closest('.form-group').removeClass('has-error');
          $(element).closest('.form-group').addClass('has-success');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
          if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
          } else {
            error.insertAfter(element);
          }
        }
      });
      $("#formlogin").validate({
  			rules: {
          /*first_name: {
            regex: "^[A-Z][-a-zA-Z ,.'-]+$"
          },
          last_name: {
            regex: "^[A-Z][-a-zA-Z ,.'-]+$"
          },*/
          username: {
  					noSpace: true,
  					regex: "^[a-zA-Z0-9._-\\s]{1,40}$",
            remote: {
              url: "<?php echo site_url();?>login/uname",
              type: "post",
              data: {
                login: function(){
                  return $('#formlogin :input[name="username"]').val();
                }
              }
            }
  				},
          email: {
            remote: {
              url: "<?php echo site_url();?>/login/umail",
              type: "post",
              data: {
                login: function(){
                  return $('#formlogin :input[name="email"]').val();
                }
              }
            }
  				},
  				conf_password: {
  					equalTo: "#password"
  				},
        },
        onfocusout: function (element){
          if (!this.checkable(element) && (element.name in this.submitted || !this.optional(element))){
            var currentObj = this;
            var currentElement = element;
            var delay = function () { currentObj.element(currentElement); };
            setTimeout(delay, 0);
          }
        },
        messages:{
          first_name:{
            regex: "first letter capitalized"
          },
          last_name:{
            regex: "first letter capitalized"
          },
          username:{
            remote: jQuery.validator.format("username is unavailable")
          },
          email:{
            remote: jQuery.validator.format("email is unavailable")
          }
        }
      });
      $("#formuser").validate({
  			rules: {
          username: {
  					noSpace: true,
  					regex: "^[a-zA-Z0-9._-\\s]{1,40}$",
            remote: {
              url: "<?php echo site_url();?>users/uname/<?php echo ($this->uri->segment(3) == "profile")?'1':'0'; ?>",
              type: "post",
              data: {
                login: function(){
                  return $('#formuser :input[name="username"]').val();
                }
              }
            }
  				},
          email: {
            remote: {
              url: "<?php echo site_url();?>/users/umail/<?php echo ($this->uri->segment(3) == "profile")?'1':'0'; ?>",
              type: "post",
              data: {
                login: function(){
                  return $('#formuser :input[name="email"]').val();
                }
              }
            }
  				}
        },
        onfocusout: function (element){
          if (!this.checkable(element) && (element.name in this.submitted || !this.optional(element))){
            var currentObj = this;
            var currentElement = element;
            var delay = function () { currentObj.element(currentElement); };
            setTimeout(delay, 0);
          }
        },
        messages:{
          username:{
            remote: jQuery.validator.format("username is unavailable")
          },
          email:{
            remote: jQuery.validator.format("email is unavailable")
          }
        }
      });
    </script>
  </body>
</html>
