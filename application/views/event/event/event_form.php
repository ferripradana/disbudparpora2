        <link href="<?php echo base_url('assets/css/select/select2.min.css') ?>" rel="stylesheet">
        <script src="<?php echo base_url('assets/js/select/select2.full.js') ?>"></script>
        <h2 style="margin-top:0px">Event <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	   
	    <div class="form-group">
                <label for="varchar">Nama Event<?php echo form_error('name') ?></label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Nama" value="<?php echo $name; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">Tanggal Mulai <?php echo form_error('tglmulai') ?></label>
                <input type="text" class="form-control" name="tglmulai" id="tglmulai" placeholder="Tgl Mulai" value="<?php echo  $tglmulai; ?>" />
            </div>
	    <div class="form-group">
                <label for="date">Tanggal Selesai <?php echo form_error('tglselesai') ?></label>
                <input type="text" class="form-control" name="tglselesai" id="tglselesai" placeholder="Tgl Selesai" value="<?php echo ($tglselesai!='00/00/0000')?$tglselesai:'' ; ?>" />
      </div>

      <div class="form-group">
              <label for="int">Tingkat  <?php echo form_error('tingkat') ?></label>
               <select class="select2_single form-control" name="tingkat" id="tingkat" tabindex="-1">
                      <?php 
                        foreach ($tingkatan_option as $key => $value) {
                            if ($tingkat==$key) {
                        ?>
                                 <option value="<?php echo $key ?>" selected><?php echo $value; ?></option>
                        <?php                              
                            }else{
                          ?>
                                 <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                            <?php         
                            }
                      ?>  

                      <?php
                        }
                       ?>  
                </select>
      </div>

       <div class="form-group">
                <label for="varchar">Tanggal Mulai Pendaftaran <?php echo form_error('tglmulai_pendaftaran') ?></label>
                <input type="text" class="form-control" name="tglmulai_pendaftaran" id="tglmulai_pendaftaran" placeholder="Ttglmulai_pendaftaran" value="<?php echo  $tglmulai_pendaftaran; ?>" />
            </div>
      <div class="form-group">
                <label for="date">Tanggal Selesai Pendaftaran <?php echo form_error('tglselesai_pendaftaran') ?></label>
                <input type="text" class="form-control" name="tglselesai_pendaftaran" id="tglselesai_pendaftaran" placeholder="tglselesai_pendaftaran" value="<?php echo ($tglselesai_pendaftaran!='00/00/0000')?$tglselesai_pendaftaran:'' ; ?>" />
      </div>

       <div class="form-group">
                <label for="date">Status Pendaftaran<?php echo form_error('status_pendaftaran') ?></label>
                <select class="select2_single form-control" name="status_pendaftaran" id="status_pendaftaran" tabindex="-1">
                        <option value="1" <?php echo ($status_pendaftaran==1)? "selected" : '' ?> >Open</option>
                        <option value="0"  <?php echo ($status_pendaftaran==0)? "selected" : '' ?> >Close</option>
                </select>
      </div>

       <div class="form-group">
                <label for="date">Klasemen<?php echo form_error('klasmen') ?></label>
                <select class="select2_single form-control" name="klasmen" id="klasmen" tabindex="-1">
                         <option value="1"  <?php echo ($klasmen==1)? "selected" : '' ?> >Ya</option>
                        <option value="0" <?php echo ($klasmen==0)? "selected" : '' ?> >Tidak</optio>
                </select>
      </div>

	     


        <br>   
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('event') ?>" class="btn btn-default">Cancel</a>
	</form>
    <script type="text/javascript">
         $(document).ready(function(){
                 $(".select2_single").select2({
                            placeholder: "Select a state",
                            allowClear: true
                        });
                     $('#tglmulai').daterangepicker({
                                singleDatePicker: true,
                                showDropdowns: true,
                                calender_style: "picker_5",
                              
                                 format: 'DD/MM/YYYY',
                            }, function (start, end, label) {
                                 console.log(start.toISOString(), end.toISOString(), label);
                            });
                        $('#tglselesai').daterangepicker({
                                singleDatePicker: true,
                                showDropdowns: true,
                                calender_style: "picker_5",
                              
                                 format: 'DD/MM/YYYY',
                            }, function (start, end, label) {
                                 console.log(start.toISOString(), end.toISOString(), label);
                            });

                       $('#tglmulai_pendaftaran').daterangepicker({
                                singleDatePicker: true,
                                showDropdowns: true,
                                calender_style: "picker_5",
                              
                                 format: 'DD/MM/YYYY',
                            }, function (start, end, label) {
                                 console.log(start.toISOString(), end.toISOString(), label);
                            });
                        $('#tglselesai_pendaftaran').daterangepicker({
                                singleDatePicker: true,
                                showDropdowns: true,
                                calender_style: "picker_5",
                              
                                 format: 'DD/MM/YYYY',
                            }, function (start, end, label) {
                                 console.log(start.toISOString(), end.toISOString(), label);
                            });  
                
            });


    </script>