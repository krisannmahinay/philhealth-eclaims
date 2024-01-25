<?php
/**
 * Created by PhpStorm.
 * User: itmd-zia
 * Date: 11/14/2018
 * Time: 2:22 PM
 */

    $page = 'cf4';
    include('header.php');
    checkLogin();
    include('menu.php');
?>


<div style="margin: 5px;">
    <div class="row">
        <div class="col-sm-7 col-xs-8"><b>LIST OF CF4 RECORDS</b></div>
        <div align="right" class="col-sm-5 col-xs-4"><?php echo date('F d, Y - l'); ?></div>
    </div>
</div>

<div id="content">

    <style>
        .table td,
        .table th {
            text-align: center;
        }

        legend {
            background-color: #FBFCC7;
        }
    </style>

    <div id="content_div" align="center" style="margin: 0px 0px 20px 0px;">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">CF4 LIST MODULE</h3>
            </div>
            <div class="panel-body">
                <div style="margin-top: 0px;" align="center" id="results_list_tbl">
                    <form action="" method="GET">

                        <?php
                        $getListCF4record= getListCF4records();

                        if(count($getListCF4record) == 0){ echo "<b>No record found.</b>"; ?>
                            <br/>
                            <input type='button'
                                   class='btn btn-primary'
                                   style='background:#006dcc;margin-top:20px;'
                                   name='create_new'
                                   id='createNew'
                                   value='Create New Record'
                                   title="Create New Record of CF4"
                                   onclick='window.location="cf4_data_entry.php"'
                            />
                        <?php } else{ echo "<b>".count($getListCF4record)." Record/s Found.</b><br/><br/>"; ?>
                            <table class="table table-hover table-bordered" id="listRecord" style="margin-top: 20px; margin-bottom: 20px; font-size: 11px; text-align: center; width: 98%;">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>E-Claims Transmittal ID</th>
                                    <th>Claim ID No</th>
                                    <th>PIN</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Suffix</th>
                                    <th>Recorded Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                for ($i = 0; $i < count($getListCF4record); $i++) {
                                    $pxPin = $getListCF4record[$i]['PX_PIN'];
                                    $transNo = $getListCF4record[$i]['CASE_NO'];
                                    $claimTransId = $getListCF4record[$i]['CLAIM_TRANS_ID'];
                                    $claimId = $getListCF4record[$i]['CLAIM_ID'];
                                    $pxLName = $getListCF4record[$i]['PX_LNAME'];
                                    $pxFName = $getListCF4record[$i]['PX_FNAME'];
                                    $pxMName = $getListCF4record[$i]['PX_MNAME'];
                                    $pxExtName= $getListCF4record[$i]['PX_EXTNAME'];
                                    $pxDob = $getListCF4record[$i]['PX_DOB'];
                                    $pxType = $getListCF4record[$i]['PX_TYPE'];
                                    $transDate = $getListCF4record[$i]['TRANS_DATE'];
                                    $createdBy = $getListCF4record[$i]['CREATED_BY'];
                                    //$for_print_cf4 = "print/print_cf4_report.php?Claim_ID=".$claimId;
                                    $for_print_cf4 = "print/cf4_report_claims.php?Claim_ID=".$claimId;
                                    ?>
                                    <tr>
                                        <td><?php echo $i+1; ?></td>
                                        <td><?php echo $claimTransId; ?></td>
                                        <td><a href="" data-toggle="modal" data-target="#modal_print_cf4" onclick="$('#print_cf4_myIframe').attr('src', '<?php echo $for_print_cf4; ?>');"><?php echo $claimId; ?></a></td>
                                        <td><?php echo $pxPin; ?></td>
                                        <td><?php echo $pxLName; ?></td>
                                        <td><?php echo $pxFName; ?></td>
                                        <td><?php echo $pxMName; ?></td>
                                        <td><?php echo $pxExtName; ?></td>
                                        <td><?php echo date('m/d/Y', strtotime($pxDob)); ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </form>
                    <div align="left" style="color:red;font-size: 10px; font-family: Verdana, Geneva, sans-serif;font-style: italic;">NOTE: Click the CLAIM ID NO. to view and print the record.</div>
                </div>
            </div>
        </div>

    </div>

    <div id="result" style="margin: 30px 0px 30px 0px; display: none;" align="center">

    </div>

    <div id="wait_image" align="center" style="display: none; margin: 30px 0px;">
        <img src="res/images/LoadingWait.gif" alt="Please Wait" />
    </div>

</div>
<!-- START MODAL PRINT CF4 -->
<div class="modal fade" id="modal_print_cf4" role="dialog" tabindex='-1'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align:left;">Print: CF4</h4>
            </div>
            <div class="modal-body">
                <iframe id="print_cf4_myIframe" src="" width="100%" frameborder="0" style="height: 650px;">
                </iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width:90px;">Close</button>
            </div>
        </div>
    </div>
</div><!-- END MODAL PRINT CF4 -->
<?php
include('footer.php');
?>
<script type="text/javascript">
    $(function() {
        $( ".datepicker" ).datepicker();
    });

    $(document).ready(function() {
        $('#listRecord').dataTable({
        });
    });
</script>