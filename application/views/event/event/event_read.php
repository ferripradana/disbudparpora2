
        <h2 style="margin-top:0px">Event Read</h2>
        <table class="table">
	    <tr><td>Nama</td><td><?php echo $name; ?></td></tr>
	    <tr><td>Tanggal Mulai Event</td><td><?php echo $tglmulai; ?></td></tr>
	    <tr><td>Tanggal Selesai Event</td><td><?php echo $tglselesai; ?></td></tr>
	    <tr><td>Tingkatan Peserta</td><td><?php echo $tingkat; ?></td></tr>
	    <tr><td>Tanggal Mulai Pendaftaran</td><td><?php echo $tglmulai_pendaftaran; ?></td></tr>
	    <tr><td>Tanggal Ditutup Pendaftaran</td><td><?php echo $tglselesai_pendaftaran; ?></td></tr>
	    <tr><td>Status Pendaftaran</td><td><?php echo ($status_pendaftaran==1)?"Open":"Close"; ?></td></tr>
	    <tr><td>Klasmen</td><td><?php echo ($klasmen==1)?"Ya":"Tidak"; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('event') ?>" class="btn btn-default">Cancel</button></td></tr>
	</table>
