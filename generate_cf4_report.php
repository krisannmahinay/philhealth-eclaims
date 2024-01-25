<?php
$page = 'reports';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('header.php');
checkLogin();
include('menu.php');

$pClaimID=$_POST['pClaimId'];
?>

<style>
    .table td,
    .table th {
        text-align: center;
    }
    legend {
        background-color: #FBFCC7;
    }
</style>
<div style="margin: 5px;">
    <div class="row">
        <div class="col-sm-7 col-xs-8"><b>GENERATE CF4 XML MODULE</b></div>
        <div align="right" class="col-sm-5 col-xs-4"><?php echo date('F d, Y - l'); ?></div>
    </div>
</div>

<div id="content">
    <div id="content_div" align="center" style="margin: 0px 0px 20px 0px;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">GENERATE CF4 XML MODULE</h3>
            </div>
            <div class="panel-body">
                <form action="" name="frmGenerateReport" method="POST" onsubmit="return confirm('Generate CF4 now?');">
                    <table style="margin-top: 20px; " align="center">
                        <tr>
                            <td colspan="5" align="center"><h4><u>Filter by Claim ID Recorded</u></h4></td>
                        </tr>
                        <tr style="height: 10px;">
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td><label>Claim ID:</label></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="pClaimId" id="pClaimId" class="form-control" style=" margin: 0px 10px 0px 0px;width: 150px;" value="<?php echo $pClaimID;?>" autocomplete="off" placeholder="Claim ID" required></td>

                            <td><input type="submit" name="search" class="btn btn-success" id="search" value="Generate CF4 XML"></td>
                        </tr>
                    </table>

                    <div id="wait_image" align="center" style="display:;margin: 30px 0px;">
                        <img src="res/images/LoadingWait.gif" alt="Please Wait" />
                    </div>

                    <!--START DISPLAY SEARCH RESULTS-->
                    <div id="result" style="margin: 30px 0px 30px 0px;" align="center">
                        <?php
                        if(isset($pClaimID) && !empty($pClaimID)) {
                            /*Registration*/
                            $displayResultEnlist = getReportResultCf4PatientRecord($pClaimID);

                            /*Health Screening & Assessment*/
                            $displayResultProfile = getReportResultProfilingCf4($pClaimID);

                            /*Start Other details of Profiling*/
                            $displayProfilingMedHist = getReportResultCf4MedHist($pClaimID);
                            $displayProfilingMHspecific = getReportResultCf4MHspecific($pClaimID);
                            $displayProfilingPemisc = getReportResultCf4PEmisc($pClaimID);
                            $displayProfilingSurghist = getReportResultCf4Surghist($pClaimID);

                            /*Consultation*/
                            $displayResultConsultation=getReportResultCf4Soap($pClaimID);

                            /*Medicine*/
                            $displayResultMedicine = getReportResultCf4Medicine($pClaimID);

                            /*Course Ward*/
                            $displayResultCourseWard = getReportResultCourseWardCf4($pClaimID);
                            /*Count Results*/
                            $countGenXML = count($displayResultEnlist);
                        }

                        ?>
                    </div>
                    <div>
                        <?php
                        if(!empty($pClaimID) && !empty($pClaimID)){
                            if($countGenXML > 1){
                                /*Update Transmittal Reference Number*/
                                /*Get Passphrase/Key to generate xml report*/
                                $getHCIinfo = getHciProfileInfo($pAccreNo, $pUserId);
                                $hciKey = $getHCIinfo['CIPHER_KEY'];

                                if(!empty($hciKey)){
                                    /*Generate XML format*/
                                    $xmlResults = generateCf4Xml($displayResultEnlist, $displayResultProfile, $displayResultCourseWard, $displayProfilingMedHist, $displayProfilingMHspecific, $displayProfilingPemisc,
                                                                    $displayResultConsultation, $displayResultMedicine);

                                    /*Encrypt XML String*/
                                    $uxPublicKeyFileName = 'files/Input/pnpki_philhealth_eclaims_auth_cert.pem';
                                    $uxFileToEncrypt='tmp/genCf4XmlReport.xml';
                                    $uxMimeType='text/xml';
                                    $uxSaveFileName="files/Output/CF4_".$displayResultEnlist['ACCRE_NO']."_".$displayResultEnlist['CLAIM_TRANS_ID']."_".$displayResultEnlist['CLAIM_ID']."_".date('Ymd').".xml";

                                    include_once('PhilHealthEClaimsEncryptor.php');
                                    $publicKeyFileName = 'file://' . dirname(__FILE__) . '/' . $uxPublicKeyFileName;
                                    $encryptor = new PhilHealthEClaimsEncryptor();
                                    $encryptor->setPublicKeyFileName($publicKeyFileName);
                                    $encryptor->setLoggingEnabled(TRUE);
                                    $encryptor->setPassword1UsingHexStr(null);
                                    $encryptor->setPassword2UsingHexStr(null);
                                    $encryptor->setIVUsingHexStr(null);
                                    $encryptor->encryptImageFile($uxFileToEncrypt, $uxMimeType, $uxSaveFileName);

                                    $logs = print_r($encryptor->getLogs(), true);
                                    $fileContents = file_get_contents($uxSaveFileName);

                                    /*Success notification*/
                                    echo "<p style='font-size: 12px;font-weight: bold;color:#8b0000'>Save as XML File <br/>with a name of CF4_Claim ID No + Generated Date(YYYYMMDD)<br/> (e.g. CF4_".$pClaimID."_".date('Ymd').".xml)</p><br/>";

                                    /*Download as File*/
                                    if ($encryptor == true) {
                                        if(file_exists($uxSaveFileName)) {
                                            echo "<a href='$uxSaveFileName' download='$fileName'>Download CF4 XML Report</a>";
                                       }
                                    }
                                }

                            } else{
                                echo "<p style='font-size: 15px;font-weight: bold;color:red;'>No Record Found.</p>";
                            }
                        }

                        ?>
                    </div>
                    <!--END DISPLAY SEARCH RESULTS-->
                </form>
            </div>
        </div>
    </div>

</div>
<?php
include('footer.php');
?>
<script>
    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });

    $(function() {
        $( ".datepicker" ).datepicker();
    });
</script>