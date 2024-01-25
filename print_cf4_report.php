<?php
/**
 * Created by PhpStorm.
 * User: llantoz
 * Date: 3/9/2018
 * Time: 9:00 AM
 */
?>
<?php
require_once('../res/tcpdf/tcpdf.php');
include('../function.php');

// create new PDF document
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PhilHealth Expanded PCB System');
$pdf->SetTitle('CF4: Report');
$pdf->SetSubject('CF4: Report');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 8);

// add a page
$pdf->AddPage();
session_start();
$pUserId = $_SESSION['pUserID'];
$pHospName = $_SESSION['pHospName'];
$pHciNo = $_SESSION['pHciNum'];
$pAccreNo = $_SESSION['pAccreNum'];
$pUserLname=$_SESSION['pUserLname'];
$pUserFname=$_SESSION['pUserFname'];
$pUserMname=$_SESSION['pUserMname'];
$pUserSuffix=$_SESSION['pUserSuffix'];
$Prov = $_SESSION['pHospAddProv'];
$getAddProv = describeProvinceAddress($Prov);
$pMun = $_SESSION['pHospAddMun'];
$getAddMun = describeMunicipalityAddress($pMun, $Prov);
$pBrgy = $_SESSION['pHospAddBrgy'];
$getAddBrgy = describeBarangayAddress($pBrgy,$pMun, $Prov);
$pZipCode = $_SESSION['pHospZipCode'];
$pClaimID=$_GET['Claim_ID'];
$displayResultEnlist = getReportResultCf4PatientRecord($pClaimID);
$displayResultProfile = getReportResultProfilingCf4($pClaimID);
$displayProfilingMedHist = getReportResultCf4MedHist($pClaimID);
$displayProfilingMHspecific = getReportResultCf4MHspecific($pClaimID);
$displayProfilingPemisc = getReportResultCf4PEmisc($pClaimID);
$displayProfilingSurghist = getReportResultCf4Surghist($pClaimID);
$displayResultConsultation=getReportResultCf4Soap($pClaimID);
$displayResultMedicine = getReportResultCf4Medicine($pClaimID);
$displayResultCourseWard = getReportResultCourseWardCf4($pClaimID);

$px_RegisteredDate = date("m/d/Y",strtotime($displayResultEnlist['TRANS_DATE']));
$dateRegister = new DateTime($px_RegisteredDate, new DateTimeZone('Asia/Manila'));
$datePxDoB = new DateTime($displayResultEnlist['PX_DOB'], new DateTimeZone('Asia/Manila'));
$getAgeServ = date_diff($dateRegister,$datePxDoB);
$descAgeServ = $getAgeServ->y." yr(s), ".$getAgeServ->m." mo(s), ".$getAgeServ->d." day(s)";
$mDiseases = listMedicalDiseases();
$pLibComplaint = listComplaint();
$listHeents = listHeent();
$listChests = listChest();
$listHearts = listHeart();
$listAbs = listAbdomen();
$listNeuro = listNeuro();
$listGenitourinary = listGenitourinary();
$listSkinExtremities = listSkinExtremities();

$report1 = '    
    <table border="0" cellpadding="2" class="table table-bordered">
        <tr style="text-align: left;font-size: 8px;text-align: left;">
            <td width="65%"><b>IMPORTANT REMINDERS:</b><br/>
            This form, together with other supporting documents, should be filed within <b>sixty (60) calendar days</b> from date of discharge.
            All information, fields and tick boxes in this form are necessary. <b>Claim forms with information shall not be processed.<br/>
            FALSE/INCORRECT INFORMATION OR MISINTERPRETATION SHALL BE SUBJECT TO CRIMINAL, CIVIL OR ADMINISTRATIVE LIABILITIES.</b>
            </td>
            <td width="35%" style="font-weight: bold;"><h1 style="font-size: 16px;text-align: center">CF4</h1><h4 style="text-align: center"><br/>(Claim Form 4)<br/>August 2018</h4><br/><br/>Series# ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___ ___</td>
        </tr>
    </table>   
    <br/><br/>
    <table border="1" cellpadding="3" style="font-size: 8px; text-align: left; width: 100%;" class="table table-bordered">
        <tbody>        
            <tr>
                <td colspan="3" style="text-align: center;font-weight: bold;background-color: #bbbbbb">I. HEALTH CARE INSTITUTION (HCI) INFORMATION</td>
            </tr>
            <tr>
                <td colspan="2"><p style="font-weight: bold;">1. Name of HCI</p><p style="font-size:10px;text-align: left;">'.$pHospName.'</p></td>
                <td><p style="font-weight: bold;">2. Accreditation Number</p><p style="font-size:10px;text-align: center;">'.$pAccreNo.'</p></td>
            </tr>
            <tr>
                <td colspan="3"><p style="font-weight: bold;">3. Address of HCI</p><p style="font-size:10px;text-align: left;">'.$getAddBrgy["BRGY_NAME"].', '.$getAddMun["MUN_NAME"].', '.$getAddProv["PROV_NAME"].', '.$pZipCode.'</p></td>
            </tr>
            <tr>
                <td colspan="3" style="font-size: 7px;" cellpadding="0">Bldg No. and Name/Lot/Block | Street/Subdivision/Village | Barangay/City/Municipality | Province | Zip Code</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;font-weight: bold;background-color: #bbbbbb">II. PATIENT\'S DATA</td>
            </tr>
            <tr>
                <td colspan="2"><p style="font-weight: bold;">1. Name of Patient</p><p style="font-size:10px;text-align: left;">'.$displayResultEnlist["PX_LNAME"].', '.$displayResultEnlist["PX_FNAME"].' '.$displayResultEnlist["PX_MNAME"].' '.$displayResultEnlist["PX_EXTNAME"].'</p></td>
                <td><p style="font-weight: bold;">2. PIN</p>
                <p style="font-size:10px;text-align: left;">'.$displayResultEnlist["PX_PIN"].'</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 7px;" cellpadding="0">Last Name | First Name | Middle Name</td>
                <td rowspan="2"><p style="font-weight: bold;">3. Age</p>
                <p style="font-size:10px;text-align: left;">'.$descAgeServ.'</p>
                </td>                
            </tr>
            <tr>
                <td colspan="2" rowspan="2"><p style="font-weight: bold;">5. Chief Complaint</p></td>                
            </tr>
            <tr>
                <td colspan="3"><p style="font-weight: bold;">4. Sex</p>
                <input type="checkbox" name="typeSex[]" value="M" '; if($displayResultEnlist["PX_SEX"] == "M"){ $report1 .= ' checked="checked" readonly="true"'; } $report1 .= ' />Male
                <input type="checkbox" name="typeSex[]" value="F" '; if($displayResultEnlist["PX_SEX"] == "F"){ $report1 .= ' checked="checked" readonly="true"'; } $report1 .= ' />Female
                </td>
            </tr>
            <tr>
                <td rowspan="2"><p style="font-weight: bold;">6. Admitting Diagnosis</p></td>
                <td rowspan="2"><p style="font-weight: bold;">7. Discharge Diagnosis</p></td>
                <td><p style="font-weight: bold;">8.a. 1st Case Rate Code</p><p style="font-size:10px;text-align: left;"></p></td>
            </tr>
            <tr>
                <td colspan="3"><p style="font-weight: bold;">8.b. 2nd Case Rate Code</p><p></p></td>
            </tr>
            <tr>
                <td colspan="3"><p style="font-weight: bold;">9.a. Date Admitted 
                &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;
                9.b. Time Admitted:</p>
                <p style="font-size:10px;text-align: left;"></p>
                </td>
            </tr>
            <tr>
                <td colspan="3"><p style="font-weight: bold;">10.a. Date Discharged 
                &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp; &emsp; 
                10.b. Time Discharged:</p>
                <p style="font-size:10px;text-align: left;"></p>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;font-weight: bold;background-color: #bbbbbb">III. REASON FOR ADMISSION</td>
            </tr>
            <tr>
                <td colspan="3"><p style="font-weight: bold;">1.History of Present Illness</p>
                <p style="font-size:10px;text-align: left;">'.$displayResultConsultation["ILLNESS_HISTORY"].'<br/></p>
                </td>
            </tr>
            <tr>
                <td colspan="3" ><p style="font-weight: bold;">2.a. Pertinent Past Medical History</p>
                <p style="font-size:10px;text-align: left;">';
                    foreach ($displayProfilingMHspecific as $displayProfilingMHspec) {
                        $report1 .= $displayProfilingMHspec["SPECIFIC_DESC"] . '';
                    }
                $report1 .= '
                </p>
                <p style="font-weight: bold;">2.b. OB/GYN History</p>
                <p style="font-size:8px;text-align: left;">G: &emsp;'.$displayResultProfile["PREG_CNT"].'&emsp;&emsp;P: &emsp;'.$displayResultProfile["DELIVERY_CNT"].'&emsp;&emsp;LMP: &emsp;'.date("m-d-Y", strtotime($displayResultProfile["LAST_MENS_PERIOD"])).'&emsp;&emsp;<input type="checkbox" value="NA" name="na"'; if($displayResultEnlist["PX_SEX"] == "M"){ $report1 .= ' checked="checked" readonly="true"'; } $report1 .= '/>NA</p>
                </td>
            </tr>
            <tr>
                <td colspan="3"><p style="font-weight: bold;">3. Pertinent Signs and Symptoms on Admission:</p>
                <p style="font-size:8px;text-align: left;">';
                    $getChief = $displayResultConsultation["CHIEF_COMPLAINT"];
                    $getChiefComplaint = explode(';',$getChief);
                    for ($i=0; $i < count($pLibComplaint); $i++) {
                        $report1 .= '<table>
                            <tr>
                                <td>
                                    <input type="checkbox"
                                           name="pCf4Symptoms[]"
                                           id="symptom_'.$pLibComplaint[$i]['SYMPTOMS_ID'].'"
                                           value="'.$pLibComplaint[$i]['SYMPTOMS_ID'].'"
                                           readonly="true"';
                                           foreach($displayResultConsultation as $displayResultConsultations) {
                                               foreach($getChiefComplaint as $getChiefComplaints) {
                                                   if ($getChiefComplaints == $pLibComplaint[$i]['SYMPTOMS_ID']) {
                                                       $report1 .= ' checked="checked"';
                                                   }
                                               }
                                           }
                                           $report1 .= ' 
                                           />
                                    <label for="symptom_'.$pLibComplaint[$i]['SYMPTOMS_ID'].'">
                                        '.$pLibComplaint[$i]["SYMPTOMS_DESC"].'
                                    </label>';
                                    if ($pLibComplaint[$i]['SYMPTOMS_ID'] == "X") {
                                        if ($displayResultConsultation['OTHER_COMPLAINT'] != NULL) {
                                            $report1 .= '- ' . $displayResultConsultation["OTHER_COMPLAINT"] . '';
                                        }
                                    }
                                $report1 .= ' 
                                </td>    
                            </tr>
                        </table>';
                    }
                $report1 .= '
                </p>
                </td>
            </tr>
            <tr>
                <td colspan="3"><p style="font-weight: bold;">4. Referred from another Health Care Institution (HCI):</p>
                <input type="checkbox" name="referredHci" value="N" readonly="true"/>No &emsp;&emsp; <input type="checkbox" name="referredHci" value="Y" readonly="true"/>Yes, Specify Reason ___________________<br/>
                &emsp;&emsp;Name of Originating HCI: ___________________________
                </td>
            </tr>

            <tr>
                <td colspan="3"><p style="font-weight: bold;">5. Physical Examination on Admission (Pertinent Findings per System)</p>
                    <p> General Survey:&emsp;&emsp;<input type="checkbox" name="genSurvey" value="AA" '; if($displayResultProfile["GENSURVEY_ID"] == "1"){ $report1 .= ' checked="checked" readonly="true"'; } $report1 .= ' />Awake and alert&emsp;&emsp;&emsp;&emsp;<input type="checkbox" name="genSurvey" value="AS" '; if($displayResultProfile["GENSURVEY_ID"] == "2"){ $report1 .= ' checked="checked" readonly="true"'; } $report1 .= '/>Altered sensorium';
                                    if ($displayResultProfile["GENSURVEY_ID"] == "2") {
                                        if ($displayResultProfile['GENSURVEY_REM'] != NULL) {
                                            $report1 .= ': <u>' . $displayResultProfile["GENSURVEY_REM"] . '</u>';
                                        }
                                    }
                                $report1 .= ' </p>
                    <p> Vital Signs:&emsp;&emsp;&emsp;&emsp;&emsp;BP: &emsp;<u>'.$displayResultProfile["SYSTOLIC"].'/'.$displayResultProfile["DIASTOLIC"].' mmHg</u>&emsp;&emsp;&emsp;HR: &emsp;<u>'.$displayResultProfile["HR"].' /min</u>&emsp;&emsp;&emsp;RR: &emsp;<u>'.$displayResultProfile["RR"].' /min</u>&emsp;&emsp;&emsp;Temp: &emsp;<u>'.$displayResultProfile["TEMPERATURE"].' &#176;C</u></p>
                   
                    <p>
                        HEENT:&emsp;&emsp;&emsp;&emsp;
                        ';
                                $report1 .= '<table>';
                                foreach ($listHeents as $pLibHEENT) {
                            $report1 .= '
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                               name="heent[]"
                                               id="heent_'.$pLibHEENT['HEENT_ID'].'"
                                               value="'.$pLibHEENT['HEENT_ID'].'"
                                               readonly="true"';
                                               foreach($displayProfilingPemisc as $displayProfilingPemiscs) {
                                                    if ($displayProfilingPemiscs['HEENT_ID'] == $pLibHEENT['HEENT_ID']) {
                                                        $report1 .= ' checked="checked"';
                                                    }
                                               }
                                               $report1 .= ' />
                                        <label for="heent_'.$pLibHEENT['HEENT_ID'].'">
                                            '.$pLibHEENT['HEENT_DESC'].'
                                        </label>
                                    </td>    
                                </tr>';
                                }
                        $report1 .= '    
                                <tr><td>Others: <u>'.$displayResultProfile["HEENT_REM"].'</u></td></tr>
                            </table>';
                    $report1 .= '
                    </p>
                    <p>
                        CHEST/LUNGS:
                        ';
                                $report1 .= '<table>';
                                foreach ($listChests as $pLibChest){
                            $report1 .= '
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                               name="chest[]"
                                               id="chest_'.$pLibChest['CHEST_ID'].'"
                                               value="'.$pLibChest['CHEST_ID'].'"
                                               readonly="true"';
                                               foreach($displayProfilingPemisc as $displayProfilingPemiscs) {
                                                    if ($displayProfilingPemiscs['CHEST_ID'] == $pLibChest['CHEST_ID']) {
                                                        $report1 .= ' checked="checked"';
                                                    }
                                               }
                                               $report1 .= ' 
                                               />
                                        <label for="chest_'.$pLibChest['CHEST_ID'].'">
                                            '.$pLibChest['CHEST_DESC'].'
                                        </label>
                                    </td>    
                                </tr>';
                                }
                        $report1 .= '    
                                <tr><td>Others: <u>'.$displayResultProfile["CHEST_REM"].'</u></td></tr>
                            </table>';
                    $report1 .= '
                    </p>
                    <p>
                        CVS:&emsp;&emsp;&emsp;&emsp;&emsp;
                         ';
                                $report1 .= '<table>';
                                foreach ($listHearts as $pLibHeart) {
                            $report1 .= '
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                               name="heart[]"
                                               id="heart_'.$pLibHeart['HEART_ID'].'"
                                               value="'.$pLibHeart['HEART_ID'].'"
                                               readonly="true"';
                                               foreach($displayProfilingPemisc as $displayProfilingPemiscs) {
                                                    if ($displayProfilingPemiscs['HEART_ID'] == $pLibHeart['HEART_ID']) {
                                                        $report1 .= ' checked="checked"';
                                                    }
                                               }
                                               $report1 .= ' 
                                               />
                                        <label for="heart_'.$pLibHeart['HEART_ID'].'">
                                            '.$pLibHeart['HEART_DESC'].'
                                        </label>
                                    </td>    
                                </tr>';
                                }
                        $report1 .= '    
                                <tr><td>Others: <u>'.$displayResultProfile["HEART_REM"].'</u></td></tr>
                            </table>';
                    $report1 .= '
                    </p>
                    <p>
                        ABDOMEN:&emsp;&emsp;
                        ';
                                $report1 .= '<table>';
                                foreach ($listAbs as $pLibAbdomen) {
                            $report1 .= '
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                               name="abdomen[]"
                                               id="abdomen_'.$pLibAbdomen['ABDOMEN_ID'].'"
                                               value="'.$pLibAbdomen['ABDOMEN_ID'].'"
                                               readonly="true"';
                                               foreach($displayProfilingPemisc as $displayProfilingPemiscs) {
                                                    if ($displayProfilingPemiscs['ABDOMEN_ID'] == $pLibAbdomen['ABDOMEN_ID']) {
                                                        $report1 .= ' checked="checked"';
                                                    }
                                               }
                                               $report1 .= ' 
                                               />
                                        <label for="abdomen_'.$pLibAbdomen['ABDOMEN_ID'].'">
                                            '.$pLibAbdomen['ABDOMEN_DESC'].'
                                        </label>
                                    </td>    
                                </tr>';
                                }
                        $report1 .= '    
                                <tr><td>Others: <u>'.$displayResultProfile["ABDOMEN_REM"].'</u></td></tr>
                            </table>';
                    $report1 .= '
                    </p>
                    <p>
                        GU (IE):&emsp;&emsp;&emsp;&emsp;
                        ';
                                $report1 .= '<table>';
                                foreach ($listGenitourinary  as $pLibGU) {
                            $report1 .= '
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                               name="genitourinary[]"
                                               id="gu_'.$pLibGU['GU_ID'].'"
                                               value="'.$pLibGU['GU_ID'].'"
                                               readonly="true"';
                                               foreach($displayProfilingPemisc as $displayProfilingPemiscs) {
                                                    if ($displayProfilingPemiscs['GU_ID'] == $pLibGU['GU_ID']) {
                                                        $report1 .= ' checked="checked"';
                                                    }
                                               }
                                               $report1 .= ' 
                                               />
                                        <label for="gu_'.$pLibGU['GU_ID'].'">
                                            '.$pLibGU['GU_DESC'].'
                                        </label>
                                    </td>    
                                </tr>';
                                }
                        $report1 .= '    
                                <tr><td>Others: <u>'.$displayResultProfile["SKIN_REM"].'</u></td></tr>
                            </table>';
                    $report1 .= '
                    </p>
                    <p>
                        SKIN/EXTREMITIES:
                        ';
                                $report1 .= '<table>';
                                foreach ($listSkinExtremities as $pLibExtremities) {
                            $report1 .= '
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                               name="skinExtremities[]"
                                               id="extremities_'.$pLibExtremities['SKIN_ID'].'"
                                               value="'.$pLibExtremities['SKIN_ID'].'"
                                               readonly="true"';
                                               foreach($displayProfilingPemisc as $displayProfilingPemiscs) {
                                                    if ($displayProfilingPemiscs['SKIN_ID'] == $pLibExtremities['SKIN_ID']) {
                                                        $report1 .= ' checked="checked"';
                                                    }
                                               }
                                               $report1 .= ' 
                                               />
                                        <label for="extremities_'.$pLibExtremities['SKIN_ID'].'">
                                            '.$pLibExtremities['SKIN_DESC'].'
                                        </label>
                                    </td>    
                                </tr>';
                                }
                        $report1 .= '    
                                <tr><td>Others: <u>'.$displayResultProfile["SKIN_REM"].'</u></td></tr>
                            </table>';
                    $report1 .= '
                    </p>
                    <p>
                        NEURO-EXAM:
                        ';
                                $report1 .= '<table>';
                                foreach ($listNeuro as $pLibNeuro) {
                            $report1 .= '
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                               name="neuro[]"
                                               id="neuro_'.$pLibNeuro['NEURO_ID'].'"
                                               value="'.$pLibNeuro['NEURO_ID'].'"
                                               readonly="true"';
                                               foreach($displayProfilingPemisc as $displayProfilingPemiscs) {
                                                    if ($displayProfilingPemiscs['NEURO_ID'] == $pLibNeuro['NEURO_ID']) {
                                                        $report1 .= ' checked="checked"';
                                                    }
                                               }
                                               $report1 .= ' 
                                               />
                                        <label for="neuro_'.$pLibNeuro['NEURO_ID'].'">
                                            '.$pLibNeuro['NEURO_DESC'].'
                                        </label>
                                    </td>    
                                </tr>';
                                }
                        $report1 .= '    
                                <tr><td>Others: <u>'.$displayResultProfile["NEURO_REM"].'</u></td></tr>
                            </table>';
                    $report1 .= '
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;font-weight: bold;background-color: #bbbbbb">IV. COURSE IN THE WARD</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table border="1" cellpadding="2" class="table table-bordered">
                        <tr style="text-align: center;">
                            <td width="15%">DATE</td>
                            <td width="85%">DOCTOR\'S ORDER/ACTION</td>
                        </tr>
                        <tbody>';
                            foreach ($displayResultCourseWard as $displayResultCourseWards) {
                            $report1 .= '<tr>
                                <td style="text-align: center">'.date("m-d-Y",strtotime($displayResultCourseWards["ACTION_DATE"])).'</td >
                                <td>'.$displayResultCourseWards["DOCTORS_ACTION"].'</td>
                                </tr >';
                                }
                            $report1 .= '</tbody>
                    </table>     
                    <p>'.count($displayResultCourseWard).' number of record/s.</p>        
                </td>
            </tr>
            <tr>
                <td colspan="3"><p>SURGICAL PROCEDURE/RVS CODE (Attach photocopy of OR technique):</p><br/></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;font-weight: bold;background-color: #bbbbbb">V. DRUGS/MEDICINES</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table border="1" cellpadding="2" class="table table-bordered">
                        <tr style="text-align: center;">
                            <td width="25%">Generic Name</td>
                            <td width="50%">Quantity/Dosage/Route</td>
                            <td width="25%">Total Cost</td>
                        </tr>
                        <tbody>';
                            foreach ($displayResultMedicine as $displayResultMeds) {
                            $report1 .='<tr style="text-align: center">
                                <td>';
                                $getGenericName = descMedsGeneric($displayResultMeds["GEN_CODE"]);
                            $report1 .= $getGenericName["GEN_DESC"].
                                '</td >
                                <td>';
                                $getStrengthName = descMedsStrength($displayResultMeds["STRENGTH_CODE"]);
                                $getFormName= descMedsForm($displayResultMeds["FORM_CODE"]);
                            $report1 .= $displayResultMeds["QUANTITY"].', '.$getStrengthName["STRENGTH_DESC"].', '.$getFormName["FORM_DESC"].'</td>
                                <td>'.$displayResultMeds["AMT_PRICE"].'</td>
                                </tr >';
                                }
                            $report1 .= '</tbody>
                    </table>   
                    <p>'.count($displayResultMedicine).' number of record/s.</p>                
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;font-weight: bold;background-color: #bbbbbb">VI. OUTCOME OF TREATMENT</td>
            </tr>
            <tr>
                <td colspan="3">
                <input type="checkbox" name="outTreatment" value="1" readonly="true"/>IMPROVED&emsp;&emsp;
                <input type="checkbox" name="outTreatment" value="2" readonly="true"/>HAMA&emsp;&emsp;
                <input type="checkbox" name="outTreatment" value="3" readonly="true"/>EXPIRED&emsp;&emsp;   
                <input type="checkbox" name="outTreatment" value="4" readonly="true"/>ABSCONDED&emsp;&emsp;   
                <input type="checkbox" name="outTreatment" value="5" readonly="true"/>TRANSFERRED&emsp;&emsp;
                Specify reason: ___________________   
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;font-weight: bold;background-color: #bbbbbb">VII. CERTIFICATION OF HEALTH CARE PROFESSIONAL</td>
            </tr>
            <tr>
                <td colspan="3"><p>Certification of Attending Health Care Professional:</p>
                <p style="font-style: italic;text-align: center">I certify that the above information given in this form, including all attachments, are true and correct.</p>
                <p style="text-align: center;">_____________________________________________________________________&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;_______________
                <br/>Signature over Printed Name of Attending Health Care Professional
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Date Signed
                </p>
                </td>
            </tr>
        </tbody>
    </table>
    <br/><br/>
    <table style="width: 50%;font-style: italic;font-size: 9px;">
        <tr>
            <td>Prepared By:&emsp;&emsp;&emsp;'.$pUserFname.'&nbsp;'.$pUserMname.'&nbsp;'.$pUserLname.'&nbsp;'.$pUserSuffix.'</td>
        </tr>
        <tr>
            <td>Prepared Date:&emsp;&emsp;'.date("m/d/Y g.i a").'</td>
        </tr>
    </table>';

// output the HTML content
$pdf->writeHTML($report1, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('CF4_'.$pClaimID.'_'.date("Ymd").'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

