<style type="text/css">
    th{
        text-align: center;
        vertical-align: center;
    }
</style>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/datatables/tools/css/dataTables.tableTools.css') ?>"/>
     
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Personil Kontingen</h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px"  id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <?php 
                    echo anchor(site_url($back), 'Back', 'class="btn btn-primary"'); 
                    if($event->status_pendaftaran==1)
                    echo anchor(site_url('event/eventkontingeninsertperson/'.$id_event.'/'.$id_kecamatan), 'Create', 'class="btn btn-primary"'); 
                     echo anchor(site_url('event/doPrint/'.$id_event.'/'.$id_kecamatan), 'Print', ' target="_blank" class="btn btn-primary"'); 
                ?>
	    </div>
        </div>
        <table class="table table-striped responsive-utilities jambo_table" id="mytable">
            <thead>

                <tr>
                    <th>No</th>
        		    <th>Nama</th>
        		    <th>Cabor</th>
                    <th>Posisi</th>
        		    <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($personil as $person)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $person->nama ?></td>
             <td><?php echo $person->caborname ?></td>
		    <td><?php echo $person->posisi ?></td>
		    <td style="text-align:center">
			<?php 
			    // echo anchor(site_url('master_spk/read/'.$person->id),'<i class="fa fa-eye"></i>'); 
			    // echo '&nbsp;'; 
                echo anchor(site_url('event/readeventkontingenperson/'.$person->id),'<i class="fa fa-eye"></i>'); 
                echo '&nbsp;'; 
                if($event->status_pendaftaran==1)
                echo anchor(site_url('event/eventkontingenupdateperson/'.$person->id),'<i class="fa fa-pencil"></i>'); 
                echo '&nbsp;'; 
                if($event->status_pendaftaran==1)
                echo anchor(site_url('event/eventkontingendeleteperson/'.$person->id),'<i class="fa fa-eraser"></i>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
			?>
		    </td>
	        </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/datatables/js/jquery.dataTables.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
              

                 var oTable = $('#mytable').dataTable({
                    "oLanguage": {
                        "sSearch": "Search all columns:"
                    },
                    "aoColumnDefs": [
                        {
                            'bSortable': false,
                            'aTargets': [0]
                        } //disables sorting for column one
            ],
                    'iDisplayLength': 12,
                    "sPaginationType": "full_numbers",
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "<?php echo base_url('assets2/js/Datatables/tools/swf/copy_csv_xls_pdf.swf'); ?>"
                    }
                });
                $("tfoot input").keyup(function () {
                    /* Filter on the column based on the index of this element's parent <th> */
                    oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
                });
                $("tfoot input").each(function (i) {
                    asInitVals[i] = this.value;
                });
                $("tfoot input").focus(function () {
                    if (this.className == "search_init") {
                        this.className = "";
                        this.value = "";
                    }
                });
                $("tfoot input").blur(function (i) {
                    if (this.value == "") {
                        this.className = "search_init";
                        this.value = asInitVals[$("tfoot input").index(this)];
                    }
                });


            });
        </script>
 