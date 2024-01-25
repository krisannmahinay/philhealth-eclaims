<?php
/**
 * Created by PhpStorm.
 * User: llantoz
 * Date: 9/20/2018
 * Time: 2:11 PM
 */

    $page = 'cf4';
    include('header.php');
    checkLogin();
    include('menu.php');

    $pPIN = $_GET['pPIN'];
    $pLastName= $_GET['pLastName'];
    $pFirstName = $_GET['pFirstName'];
    $pMiddleName = $_GET['pMiddleName'];
    $pSuffix = $_GET['pSuffix'];
    $pDoB = $_GET['pDateOfBirth'];
    $pDateOfBirth = date('Y-m-d',strtotime($pDoB));
    $pModule = "CF4";
?>
<script>
    $(function() {
        $( ".datepicker" ).datepicker();
    });
    $("#pDateOfBirth").mask("99/99/9999");
    $("#pDateOfBirth").datepicker({ maxDate: new Date, minDate: new Date(2007, 6, 12) });

</script>
<div style="margin: 5px;">
    <div class="row">
        <div class="col-sm-7 col-xs-8"><b>SEARCH PATIENT MODULE</b></div>
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
                <h3 class="panel-title">CF4 MODULE</h3>
            </div>
            <form action="cf4_search.php" name="search_consultation_form" method="GET">
                <div class="panel-body">
                    <table style="margin-top: 20px; " align="center">
                        <tr>
                            <td colspan="5" align="center"><u><h4>Search Patient Record</h4></u></td>
                        </tr>
                        <tr>
                            <td colspan="5" align="center">
                                <table>
                                    <tr>
                                        <td><label>PhilHealth Identification No:</label></td>
                                        <td><input type="text" name="pPIN" id="pPIN" style=" margin: 0px 10px 0px 0px;text-transform: uppercase;width: 150px;" class="form-control" value="<?php echo $pPIN;?>" onkeypress="return isNumberKey(event);">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr style="height: 10px;">
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td><label>Last Name</label></td>
                            <td><label>First Name</label></td>
                            <td><label>Middle Name</label></td>
                            <td><label>Extension</label></td>
                            <td><label>Date of Birth</label></td>
                        </tr>
                        <tr>
                            <td>
                                <input
                                    type="text"
                                    name="pLastName"
                                    id="pLastName"
                                    class="form-control"
                                    style=" margin: 0px 10px 0px 0px;text-transform: uppercase;width: 150px;"
                                    maxlength="20"
                                    value="<?php echo $pLastName; ?>"
                                    autocomplete="off"
                                />
                            </td>
                            <td>
                                <input
                                    type="text"
                                    name="pFirstName"
                                    id="pFirstName"
                                    class="form-control"
                                    style=" margin: 0px 10px 0px 0px;text-transform: uppercase;width: 150px;"
                                    maxlength="20"
                                    value="<?php echo $pFirstName; ?>"
                                    autocomplete="off"
                                />
                            </td>
                            <td>
                                <input
                                    type="text"
                                    name="pMiddleName"
                                    id="pMiddleName"
                                    class="form-control"
                                    style=" margin: 0px 10px 0px 0px;text-transform: uppercase;width: 150px;"
                                    maxlength="15"
                                    value="<?php echo $pMiddleName; ?>"
                                    autocomplete="off"
                                />
                            </td>
                            <td>
                                <input
                                    type="text"
                                    name="pSuffix"
                                    id="pSuffix"
                                    class="form-control"
                                    style=" margin: 0px 10px 0px 0px;text-transform: uppercase;width: 70px;" maxlength="3"
                                    value="<?php echo $pSuffix; ?>"
                                    autocomplete="off"
                                />
                            </td>
                            <td>
                                <input
                                    type="text"
                                    name="pDateOfBirth"
                                    id="pDateOfBirth"
                                    class="datepicker form-control"
                                    value="<?php echo $pDoB; ?>"
                                    placeholder="mm/dd/yyyy"
                                    style="width: 100px;"
                                    autocomplete="off"
                                    onkeyup="formatDate('pDateOfBirth');"
                                />
                            </td>
                        </tr>
                        <tr style="height: 20px;">
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5" align="center">
                                <input
                                    type="submit"
                                    name="search"
                                    class="btn btn-success"
                                    id="search"
                                    value="Search Record"
                                    title="Search"
                                    onclick=""
                                />
                                <input
                                    type="button"
                                    name="clear"
                                    class="btn btn-warning"
                                    id="clear"
                                    value="Clear"
                                    title="Clear"
                                    onclick="window.location='cf4_search.php'"
                                />
                                <input type="button"
                                       name="registerNew"
                                       class="btn btn-primary"
                                       style="background:#006dcc;"
                                       id="createNew"
                                       title="Create New Record"
                                       value="Create New Record"
                                       onclick="window.location='cf4_data_entry.php'"
                                />
                            </td>
                        </tr>
                    </table>
                </div>
            </form>


            <div id="result" style="margin: 30px 0px 30px 0px;" align="center">
                <?php
                if($_GET) {
                    $displayResult = searchClientResult($pPIN, $pLastName, $pFirstName, $pMiddleName, $pSuffix, $pDateOfBirth, $pModule);

                    if (count($displayResult) <= 0) {
                        echo "<div style='text-align: center;font-weight: bold;font-size: 12px;'>No record found.</div>";
                    } else {
                        echo "<div style='text-align: center;font-weight: bold;font-size: 12px;'>" . count($displayResult) . " Record/s Found.</div>";
                        ?>
                        <table class="table table-hover table-bordered"
                               style="margin-top: 20px; margin-bottom: 20px; font-size: 11px; text-align: center; width: 98%;">
                            <thead>
                            <tr>
                                <th style="width: 5%; font-size: 11px; padding: 2px; vertical-align: middle"
                                    rowspan="2">No
                                </th>
                                <th style="width: 75%; font-size: 11px; padding: 2px;" colspan="8">Patient Information
                                </th>
                                <th style="width: 20%; font-size: 11px; padding: 2px;" rowspan="2"></th>
                            </tr>
                            <tr>
                                <th style="width: 12%; font-size: 11px; padding: 2px;">Case No</th>
                                <th style="width: 12%; font-size: 11px; padding: 2px;">PIN</th>
                                <th style="width: 12%; font-size: 11px; padding: 2px;">Last Name</th>
                                <th style="width: 12%;  font-size: 11px; padding: 2px;">First Name</th>
                                <th style="width: 12%;  font-size: 11px; padding: 2px;">Middle Name</th>
                                <th style="width: 12%;  font-size: 11px; padding: 2px;">Extension</th>
                                <th style="width: 12%;  font-size: 11px; padding: 2px;">Date of Birth</th>
                                <th style="width: 12%;  font-size: 11px; padding: 2px;">Type</th>
                            </tr>
                            </thead>
                            <?php
                            for ($i = 0; $i < count($displayResult); $i++) {
                                $pxCaseNo = $displayResult[$i]['CASE_NO'];
                                $pClaimId = $displayResult[$i]['CLAIM_ID'];
                                $pxPin = $displayResult[$i]['PX_PIN'];
                                $pxLname = $displayResult[$i]['PX_LNAME'];
                                $pxFname = $displayResult[$i]['PX_FNAME'];
                                $pxMname = $displayResult[$i]['PX_MNAME'];
                                $pxExtName = $displayResult[$i]['PX_EXTNAME'];
                                $pxDob = $displayResult[$i]['PX_DOB'];
                                $pxType = $displayResult[$i]['PX_TYPE'];
                                $for_print_cf4 = "print/print_cf4_report.php?Claim_ID=".$pClaimId;
                                ?>
                                <tbody>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><a href="" data-toggle="modal" data-target="#modal_print_cf4" onclick="$('#print_cf4_myIframe').attr('src', '<?php echo $for_print_cf4; ?>');" title="Go to View Record" style="font-size:11px;font-weight: normal;"><?php echo $pxCaseNo; ?></a></td>
                                    <td><?php echo $pxPin; ?></td>
                                    <td><?php echo $pxLname; ?></td>
                                    <td><?php echo $pxFname; ?></td>
                                    <td><?php echo $pxMname; ?></td>
                                    <td><?php echo $pxExtName; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($pxDob)); ?></td>
                                    <td><?php echo getPatientType(false, $pxType); ?></td>
                                    <td>

                                    </td>
                                </tr>
                                </tbody>
                            <?php } ?>
                        </table>
                    <?php }
                }?>

            </div>
        </div>
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

