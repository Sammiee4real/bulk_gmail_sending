 <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Are you sure you want to logout?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="./logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>


  

   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<!--//Metis Menu -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" type="text/javascript"></script>

<script type="text/javascript">
     
     
    function deleteRowwIncome(position){
        $("#pos"+position).remove();
        var currcount = $('#counterr').val();
        var newccount = currcount - 1;
        console.log(newccount);
      
          /////reset to disabled incase there is cancellation
              if(newccount == 0){
                // document.getElementById("cmd_add_entries").style.visibility = 'none';
                 document.getElementById("cmd_entries").disabled = true;
              }

        document.getElementById("counterr").value = newccount;
        document.getElementById("counterr2").textContent = newccount;
    }


    function deleteRowwExpense(position){
        $("#pos"+position).remove();
        var currcount = $('#counterr').val();
        var newccount = currcount - 1;
        console.log(newccount);
      
          /////reset to disabled incase there is cancellation
              if(newccount == 0){
                // document.getElementById("cmd_add_entries").style.visibility = 'none';
              document.getElementById("cmd_entries").disabled = true;
              }

        document.getElementById("counterr").value = newccount;
        document.getElementById("counterr2").textContent = newccount;
    }



    document.getElementById("cmd_entries").disabled = true;
    // document.getElementById("cmd_entries").disabled = true;
    // document.getElementById("cmd_add_entries").style.visibility = 'none';



</script>

  <script type="text/javascript">
    $(document).ready(function () {

         // toastr.info('Page Loaded!');
         $('.js-example-basic-single').select2();
         $('.js-example-basic-multiple').select2();
         $('.js-example-basic-multiple2').select2();



           var products_list = $('#products_table').DataTable({
          "scrollX": true,
          "processing": true,
          "serverSide": true,
          "ajax": "server_tables/view_products.php",
          // 'pagingType': 'numbers'
            // "order": [[ 2, "asc" ]],
            // "columnDefs": [
            // { "render": products_list,
            // "data": null,         
            // "targets": [0], "width": "9%", "targets": 0 },
            // ]
          } );

               var all_sns = $('#all_sns_tbl').DataTable({
              "scrollX": true,
              "processing": true,
              "serverSide": true,
              "ajax": "server_tables/view_sns_filter.php",
              // 'pagingType': 'numbers'
                // "order": [[ 2, "asc" ]],
                // "columnDefs": [
                // { "render": all_sns,
                // "data": null,         
                // "targets": [0], "width": "9%", "targets": 0 },
                // ]
          } );



          //  function products_list(data, type, full) {
          // return '<a href="./edit_acct_item.php?iid='+full[0]+'" class="btn btn-sm btn-primary">Hide/Show</a>';
          // }


          $(".js-example-tokenizer").select2({
          tags: true,
          tokenSeparators: [',', ' '],
          
          });


          $(".js-example-tokenizer2").select2({
          tags: true,
          tokenSeparators: [',', ' ']
          });

           $(".js-example-tokenizer3").select2({
          tags: true,
          tokenSeparators: [',', ' ']
          });



          // $('#example').DataTable();
          // $('.example').DataTable();

          // js-example-basic-multiple
          $('.logintest').click(function (e) {
          e.preventDefault();
          toastr.error("Testing lllllll", "Caution!");
          });

        

        $('#cmd_admin_login').click(function (e) {
            e.preventDefault();

            $.ajax({
            url:"../ajax/admin_login.php",
            method: "POST",
            data:$('#login_form_admin').serialize(),
            beforeSend: function(){
            //$(this).html('loading...');
            $("#cmd_admin_login").attr('disabled', true);
            $("#cmd_admin_login").text('logging in...');
            },
            success:function(data){
            //alert(data);
            if(data == 200){

            toastr.success("Admin Login was successful...", "Success!");
            setTimeout( function(){ window.location.href = "home.php"; }, 2000);



            }else{
            toastr.error(data, "Caution!");


            }

            $('#cmd_admin_login').attr('disabled', false);
            $('#cmd_admin_login').text('Login');

            }


            });

            });



     $('#add_sender_emails').click(function (e) {
          e.preventDefault();

          var countter = $('#counterr').val();
          //var disp = parseInt(countter) + 1;
          if(countter >= 12){
            alert('Maximum entries per time is 12');
          }else{
              build_form = '<tr id="pos'+countter+'">';
            
                   build_form +='</select><td><input type="text"  class="form-control form-control-sm"  id="sender_email_'+countter+'" name="sender_email_'+countter+'" placeholder="sender_email"  ></td><td><input type="text"  class="form-control form-control-sm"  id="sender_pass_'+countter+'" name="sender_pass_'+countter+'" placeholder="sender_password"  ></td><td><button id="'+countter+'" class="btn btn-danger btn-sm countersss" onClick="event.preventDefault();deleteRowwExpense('+countter+');">X</button></td>';
                    build_form += '</tr>';
                  countter++;
                  $('#counterr').val(countter);
                  $('#counterr2').text(countter);
                  document.getElementById("cmd_entries").disabled = false;
                  // document.getElementById("cmd_add_entries").style.visibility = 'block';

                  $('.add_input_div').append(""+build_form+"");
          }
    });

      $('#cmd_entries').click(function (e) {
          e.preventDefault();
        
                $.ajax({
                url:"ajax/add_sender_ids.php",
                method: "POST",
                data:$('#add_sender_emails_form').serialize(),
                beforeSend: function(){
                     $("#cmd_entries").attr('disabled', true);
                     $("#cmd_entries").text('Please wait...');     
                },
                success:function(data){
                  if(data == 200){
                       toastr.success(data, "Success!"); 
                        // setTimeout( function(){ window.location.href = "log_income.php"; }, 2000);
                  }else{
                       toastr.info(data, "Caution!"); 
                       //setTimeout( function(){ window.location.href = "add_sender_emails.php"; }, 2000);
                  }    
                }
              });
                   
    });


            $('#cmd_login').click(function (e) {
            e.preventDefault();

            $.ajax({
            url:"ajax/login.php",
            method: "POST",
            data:$('#login_form').serialize(),
            beforeSend: function(){
            //$(this).html('loading...');
            $("#cmd_login").attr('disabled', true);
            $("#cmd_login").text('logging in...');
            },
            success:function(data){
            //alert(data);
            if(data == 200){

            toastr.success("Login was successful...", "Success!");
            setTimeout( function(){ window.location.href = "home.php"; }, 2000);



            }else{
            toastr.error(data, "Caution!");


            }

            $('#cmd_login').attr('disabled', false);
            $('#cmd_login').text('Login');

            }


            });

            });



});


</script>

</body>

</html>