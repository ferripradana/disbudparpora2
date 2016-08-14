        <link href="<?php echo base_url('assets/css/select/select2.min.css') ?>" rel="stylesheet">
        <script src="<?php echo base_url('assets/js/select/select2.full.js') ?>"></script>
        <h2 style="margin-top:0px">Atlit Kontingen <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	      <div class="form-group">
              <label for="int">Cabang <?php echo form_error('cabang') ?></label>
               <select class="select2_single form-control" name="cabang" id="cabang"  tabindex="-1">
                      <?php 
                        foreach ($cabang_option as $key => $value) {
                            if ($cabang==$key) {
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
                                            
            <label> Kelas Cabang  </label>
                <select class="select2_multiple form-control" id="kelas_cabore" multiple="multiple" name="kelas_cabor[]">   
                     <?php 
                        foreach ($kelascabor as $key => $value) {

                          ?>
                                 <option value="<?php echo $key  ?>" <?php echo isset($kontingencabor[$key])?"selected":''; ?>  ><?php echo $value; ?></option>
                            <?php         
                            }
                      ?>                         
                </select>
        </div>
	    <input type="hidden" name="id_event" value="<?php echo $id_event ?>">
      <input type="hidden" name="id_kecamatan" value="<?php echo $id_kecamatan ?>">
	    <div class="form-group">
                <label for="varchar">Nama <?php echo form_error('nama') ?></label>
                <input type="text" class="form-control" name="nama" id="nama" placeholder="nama" value="<?php echo $nama; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">Tempat Lahir <?php echo form_error('tmp_lahir') ?></label>
                <input type="text" class="form-control" name="tmp_lahir" id="tmp_lahir" placeholder="tempat lahir" value="<?php echo  $tmp_lahir; ?>" />
            </div>
	    <div class="form-group">
                <label for="date">Tanggal Lahir <?php echo form_error('tgl_lahir') ?></label>
                <input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="tanggal Lahir" value="<?php echo ($tgl_lahir!='00/00/0000')?$tgl_lahir:'' ; ?>" />
            </div>
	   
      <div class="form-group">
                <label for="int">Kelamin <?php echo form_error('kelamin') ?></label>
                 <select class="select2_single form-control" name="kelamin" id="kelamin" tabindex="-1">
                                 <option value="1" <?php echo ($kelamin==1)? "selected":"" ?> >Laki - Laki</option>
                                 <option value="2" <?php echo ($kelamin==2)? "selected":"" ?>  >Perempuan</option> 
                </select>
      </div>     
      <div class="form-group">
                <label for="varchar">Jabatan <?php echo form_error('posisi') ?></label>
                <select class="select2_single form-control" name="posisi" id="posisi" tabindex="-1">
                                 <option value="Atlit" <?php echo ($posisi=="Atlit")? "selected":"" ?> >Atlit</option>
                                 <option value="Pelatih" <?php echo ($posisi=="Pelatih")? "selected":"" ?> >Wasit</option>
                                 <option value="Official" <?php echo ($posisi=="Official")? "selected":"" ?> >Official</option>
                                 <option value="Wasit" <?php echo ($posisi=="Wasit")? "selected":"" ?> >Wasit</option>
                </select>
            </div>
      <div class="form-group">
                <label for="varchar">Alamat <?php echo form_error('alamat') ?></label>
                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="alamat" value="<?php echo $alamat; ?>" />
            </div>

	    <div class="form-group">
                <label for="varchar">Telepon <?php echo form_error('telepon') ?></label>
                <input type="text" class="form-control" name="telepon" id="telepon" placeholder="telepon" value="<?php echo $telepon; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">Sertifikat *Khusus Pelatih, Wasit dan Official <?php echo form_error('sertifikat') ?></label>
                <input type="text" class="form-control" name="sertifikat" id="sertifikat" placeholder="sertifikat" value="<?php echo $sertifikat; ?>" />
            </div>
	    <div class="form-group">
                <label for="int">Sekolah *Khusus Atlit<?php echo form_error('sekolah') ?></label>
                <input type="text" class="form-control" name="sekolah" id="sekolah" placeholder="Sekolah" value="<?php echo $sekolah; ?>" />
            </div>
	    <div class="form-group">
                <label for="int">Kelas *Khusus Atlit<?php echo form_error('kelas') ?></label>
                <input type="text" class="form-control" name="kelas" id="kelas" placeholder="Kelas" value="<?php echo $kelas; ?>" />
            </div>
	    <div class="form-group">
                <label for="int">Tinggi Badan (Cm) *Khusus Atlit<?php echo form_error('tinggbadan') ?></label>
                <input type="text" class="form-control" name="tinggibadan" id="tinggibadan" placeholder="tinggi badan" value="<?php echo $tinggibadan; ?>" />
            </div>
      <div class="form-group">
                <label for="int">Berat Badan (Kg) *Khusus Atlit<?php echo form_error('beratbadan') ?></label>
                <input type="text" class="form-control" name="beratbadan" id="beratbadan" placeholder="berat badan" value="<?php echo $beratbadan; ?>" />
            </div>
	 
	     <div class="form-group">
                <label for="varchar">Foto <?php echo form_error('foto') ?></label>
                <input type="file"  name="foto" id="foto" />            
            </div>
         <div>
                
                <?php 
                    if (isset($foto) && $foto!='' && $foto!='0') {
                        ?>
                        <img src="<?php echo base_url('upload/thumbs/'.$foto) ?>" class="img-thumbnail" alt="Cinque Terre" />
                        <?php
                    }else{
                        ?>
                        <img src="<?php echo base_url('upload/no_user.jpg') ?>" class="img-thumbnail" alt="Cinque Terre" />
                        <?php
                    }
                 ?>
        </div>
        <br>   
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('event/kontingenpersonil/'.$id_event.'/'.$id_kecamatan) ?>" class="btn btn-default">Cancel</a>
	</form>
    <script type="text/javascript">
         $(document).ready(function(){
                    $(".select2_single").select2({
                            placeholder: "Select a state",
                            allowClear: true
                        });
                    $('#tgl_lahir').daterangepicker({
                                singleDatePicker: true,
                                showDropdowns: true,
                                calender_style: "picker_5",
                              
                                 format: 'DD/MM/YYYY',
                    }, function (start, end, label) {
                                 console.log(start.toISOString(), end.toISOString(), label);
                    });

                    $(".select2_multiple").select2({
                        maximumSelectionLength: 6,
                        placeholder: "Maksimal 6 nomor yang bisa dipilih",
                        allowClear: true
                    });



                
            });
          var host = "<?php echo base_url(); ?>";
          var tingkat = "<?php echo $event_tingkat; ?>";


          $("#cabang").change(function(){
              var value = $("#cabang").val();
               $.ajax({
                    url  : host+"event/getKelasCabang",
                    type : "POST",
                    dataType:"json" ,
                    data: {id:value, tingkat:tingkat} ,
                    success:function(data){
                        if(data.data.sukses==1){
                           var kelas = data.data.kelas;
                           var options = '';
                          for (var i = 0; i < kelas.length; i++) {
                            options += '<option value="' + kelas[i].value + '">' + kelas[i].label + '</option>';
                          }
                          $("#kelas_cabore").html(options);

                           
                        }else{
                            alert(data.data.message);
                        }

                    } 
                });
          });

    </script>