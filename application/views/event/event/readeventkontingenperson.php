<h2 style="margin-top:0px">Personi Read</h2>
        <table class="table">
	    <tr><td>Nama</td><td><?php echo $nama; ?></td></tr>
	    <tr><td>Kelamin</td><td><?php echo getGender($kelamin); ?></td></tr>
	    <tr><td>Tempat Lahir</td><td><?php echo $tmp_lahir; ?></td></tr>
	    <tr><td>Tanggal Lahir</td><td><?php echo $tgl_lahir; ?></td></tr>
	    <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
	    <tr><td>Telepon</td><td><?php echo $telepon; ?></td></tr>
	    <tr><td>Jabatan</td><td><?php echo $posisi; ?></td></tr>
	    <tr><td>Sertifikat</td><td><?php echo $sertifikat; ?></td></tr>
	    <tr><td>Sekolah</td><td><?php echo $sekolah; ?></td></tr>
	    <tr><td>Kelas</td><td><?php echo $kelas; ?></td></tr>
	    <tr><td>Tinggi Badan</td><td><?php echo $tinggibadan; ?></td></tr>
	    <tr><td>Berat Badan Lahir</td><td><?php echo $beratbadan; ?></td></tr>
	    <tr><td>Foto</td><td>
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

	    </td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('event/kontingenpersonil/'.$id_event.'/'.$id_kecamatan) ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
