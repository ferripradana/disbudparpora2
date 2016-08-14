
<style>
.container {
	font-family:	Arial;
}
@media all {
	.page-break	{ display: none; }
}

@media print {
	.page-break	{ display: block; page-break-before: always; }
}
</style>
    

<?php foreach ($personil as $per): ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="5" class="container">
      <tbody>
        <tr>
          <td colspan="4" align="center"><h4>BIODATA PESERTA <?php echo $event->name ?> <br>KONTINGEN KECAMATAN <?php echo $kecamatan[$per->id_kecamatan] ?> KABUPATEN KLATEN<br><?php 
          echo date_formater($event->tglmulai); ?> - <?php echo date_formater($event->tglselesai); ?></h4></td>
        </tr>

       
        <tr>
          <td width="24%" rowspan="15" align="center" valign="top">
          	  <img src='<?php echo base_url('upload/thumbs/'.$per->foto) ?>'>            </td>
          <td width="33%" valign="top">Cabang / Nomor</td>
          <td width="3%" align="center" valign="top">:</td>
          <td width="40%" valign="top">
          <?php foreach ($per->kelas_olahraga as $key => $value) {
              echo $value."<br>";
          } ?>
          </td>
        </tr>
        <tr>
          <td valign="top">Jabatan</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $per->posisi ?></td>
        </tr>
        <tr>
          <td valign="top">Nama</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $per->nama ?></td>
        </tr>
        <tr>
          <td valign="top">Tempat / Tgl Lahir</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $per->tmp_lahir ?> / <?php echo date_formater($per->tgl_lahir) ?> </td>
        </tr>
        <tr>
          <td valign="top">Alamat</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $per->alamat ?></td>
        </tr>
        <tr>
          <td valign="top">Jenis Kelamin</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo getGender($per->kelamin) ?></td>
        </tr>
        <tr>
          <td valign="top">Telepon / HP</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $per->telepon ?></td>
        </tr>
        <tr>
          <td valign="top">Sertifikat</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $per->sertifikat ?></td>
        </tr>
        <tr>
          <td valign="top">Tinggi Badan</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $per->tinggibadan ?> CM</td>
        </tr>
        <tr>
          <td valign="top">Berat Badan</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $per->beratbadan ?> KG</td>
        </tr>
        <tr>
          <td valign="top">Nama Sekolah</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $per->sekolah ?></td>
        </tr>
        <tr>
          <td valign="top">Kelas</td>
          <td align="center" valign="top">:</td>
          <td valign="top"><?php echo $per->kelas ?></td>
        </tr>
       
        <tr>
          <td colspan="4" align="center" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="5">
            <tbody>
              <tr>
                <td height="43" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td width="43%" align="center" valign="top"><p>Mengetahui<br>
                  <strong>Dinas Kab Kota</strong><br>
                </p>
                <p>&nbsp;</p></td>
                <td width="17%" align="center" valign="top">&nbsp;</td>
                <td width="40%" align="center" valign="top"><p><strong><br><?php echo $per->posisi ?></strong></p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p><strong><?php echo $per->nama ?></strong></p></td>
              </tr>
              <tr>
                <td align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" align="center" valign="top"><p><strong>Tim Keabsahan</strong></p>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
      </tbody>
    </table>
	<div class="page-break"></div>
  <?php endforeach; ?>   