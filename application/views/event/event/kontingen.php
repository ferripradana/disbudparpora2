<style type="text/css">
    body.nav-md .container.body .right_col {
        padding: 10px 20px 18px;
        margin-left: 230px;
    }
</style>
        <h2 style="margin-top:0px">Event Name : <?php echo  $namaeven ?></h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4"> 
                <?php 
                    echo anchor(site_url('event'),'Back', 'class="btn btn-primary"'); 
                ?>
            </div>
           
        </div>

        <table class="table table-striped responsive-utilities jambo_table bulk_action" style="margin-bottom: 10px">
            <thead>
            <tr class="headings">
                <th>No</th>
        		<th>Kontingen Kecamatan</th>
                <th>Personil</th>
            </tr></thead><?php
            $start = 1;
            foreach ($kontingenkecamatan as $kon)
            {
               ?>
                <tr>
                    <td><?php echo $start++; ?> </td>
                    <td><?php echo $kecamatan_option[$kon->id_kecamatan] ?></td>
                     <td><?php echo anchor(site_url('event/kontingen/personil/'.$id_event.'/'.$kon->id_kecamatan),'<i class="fa fa-user"></i>'); ?></td>
                   
                </tr>
                    
               <?php
            }
            ?>
        </table>
      
