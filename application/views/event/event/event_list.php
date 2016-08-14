
        <h2 style="margin-top:0px">Event List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4"> 
                <?php 
                    if ($iscreate==1)
                    echo anchor(site_url('event/create'),'Create', 'class="btn btn-primary"'); 
                ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('event/search'); ?>" class="form-inline" method="post">
                    <input name="keyword" class="form-control" value="<?php echo $keyword; ?>" />
                    <?php 
                    if ($keyword <> '')
                    {
                        ?>
                        <a href="<?php echo site_url('event'); ?>" class="btn btn-default">Reset</a>
                        <?php
                    }
                    ?>
                    <input type="submit" value="Search" class="btn btn-primary" />
                </form>
            </div>
        </div>
        <table class="table table-striped responsive-utilities jambo_table bulk_action" style="margin-bottom: 10px">
            <thead>
            <tr class="headings">
                <th>No</th>
                <th>Kontingen</th>
        		<th>Nama</th>
        		<th>Penyelenggaraan</th>
        		<th>Level</th>
                <th>Pendaftaran</th>
                <th>Status Pendaftaran</th>
                <th>Klasemen</th>
                <th style="text-align:center">Action</th>
            </tr></thead><?php
            foreach ($events as $event)
            {
                ?>
                <tr>
			<td><?php echo ++$start ?></td>
            <td><?php echo anchor(site_url('event/kontingen/'.$event->id),'<i class="fa fa-flag"></i>'); ?></td>
            <td><?php echo $event->name ?></td>
			<td><?php echo date_formater($event->tglmulai) ?> <br /> <?php echo date_formater($event->tglselesai) ?> </td>
			<td><?php echo $tingkatan_option[$event->tingkat] ?></td>
            <td><?php echo date_formater($event->tglmulai_pendaftaran) ?> <br /> <?php echo date_formater($event->tglselesai_pendaftaran) ?> </td>
			<td>
            <?php
                echo ($event->status_pendaftaran==1)?"Open":"Close"; 
            ?></td>
			<td><?php echo ($event->klasmen==1)?"Ya":"Tidak";  ?></td>
			<td style="text-align:center">
				<?php 
				echo anchor(site_url('event/read/'.$event->id),'<i class="fa fa-eye"></i>'); 
				echo '  ';
                if($isupdate){ 
				    echo anchor(site_url('event/update/'.$event->id),'<i class="fa fa-pencil"></i>'); 
				    echo '  ';
                } 
				if($isdelete){
                    echo anchor(site_url('event/delete/'.$event->id),'<i class="fa fa-eraser"></i>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				}
                ?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
 