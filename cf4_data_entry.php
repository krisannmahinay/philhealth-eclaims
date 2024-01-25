<?php
/**
 * Created by PhpStorm.
 * User: llantoz
 * Date: 9/12/2018
 * Time: 11:05 AM
 */

    $page = 'cf4';
    include('header.php');
    checkLogin();
    include('menu.php');

    $listHeents = listHeent();
    $listChests = listChest();
    $listHearts = listHeart();
    $listAbs = listAbdomen();
    $listNeuro = listNeuro();
    $listGenitourinary = listGenitourinary();
    $listRectal = listDigitalRectal();
    $listSkinExtremities = listSkinExtremities();

    if(isset($_POST['submitCf4'])){
        $cntChiefComplaint = count($_POST["pCf4Symptoms"]);
        $x=1;
        foreach($_POST["pCf4Symptoms"] as $complaints) {
            if($x==$cntChiefComplaint) {
                $complaint .= $complaints;
            }
            else {
                $complaint .= $complaints.";";
            }
            $x++;
        }
        $_POST["pSignsSymptoms"] = $complaint;
        saveCF4record($_POST);
    }
?>

<div style="margin: 5px;">
    <div class="row">
        <div class="col-sm-7 col-xs-8"><b>CLAIM FORM 4 MODULE</b></div>
        <div align="right" class="col-sm-5 col-xs-4"><?php echo date('F d, Y - l'); ?></div>
    </div>
</div>

<div id="wait_image" align="center" style="display: ; margin: 30px 0px;">
    <img src="res/images/LoadingWait.gif" alt="Please Wait" />
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

    <div id="content_div" align="center" style="margin: 0px 0px 0px 0px;">
        <form action="" name="formProfiling" method="POST" onsubmit="return saveCF4Transaction();">
            <table border="0" style="margin-top: 0px;" align="center">
                <tr id="soap_info">
                    <td>
                        <div class="tabbable">
                            <ul class="nav nav-pills nav-justified" data-tabs="tabs" style="margin-top: 1px; margin-bottom: 5px;">
                                <li class="active" id="list1"><a href="#tab1" data-toggle="tab" style="text-align: center; height: 71px;" onclick="" id="">1<br>Patient Profile</a></li>
                                <li class="" id="list9"><a href="#tab9" data-toggle="tab" style="text-align: center;" onclick="" id="">2<br>Chief Complaint</a></li>
                                <li class="" id="list2"><a href="#tab2" data-toggle="tab" style="text-align: center;" onclick="" id="">3<br>History of Present Illness</a></li>
                                <li class="" id="list3"><a href="#tab3" data-toggle="tab" style="text-align: center;" onclick="" id="">4<br>Pertinent Past Medical History</a></li>
                                <li class="" id="list4"><a href="#tab4" data-toggle="tab" style="text-align: center; height: 71px;" onclick="" id="">5<br>OB-Gyne History</a></li>
                                <li class="" id="list5"><a href="#tab5" data-toggle="tab" style="text-align: center; height: 71px;" onclick="" id="">6<br>Pertinent Signs & Symptoms on Admission</a></li>
                                <li class="" id="list6"><a href="#tab6" data-toggle="tab" style="text-align: center;" onclick="" id="">7<br>Physical Examination on Admission</a></li>
                                <li class="" id="list7"><a href="#tab7" data-toggle="tab" style="text-align: center;" onclick="" id="">8<br>Course in the Ward</a></li>
                                <li class="" id="list8"><a href="#tab8" data-toggle="tab" style="text-align: center;" onclick="" id="">9<br>Medicine</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <!--TAB 1 - FAMILY AND PERSONAL HISTORY START-->
                            <div class="tab-pane fade in active" id="tab1">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Patient Profile</h3>
                                    </div>
                                    <div class="panel-body">
                                        <fieldset style="margin: 0px; padding: 20px; background-color: #EDFCF0;">
                                            <table border="0" style="width: 100%;" class="table-condensed">
                                                <tr>
                                                    <td colspan="5">
                                                        <div class="alert alert-success" style="margin-bottom: 0px;font-weight: bold;font-size:16px;">
                                                            PATIENT'S DATA
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">
                                                        <label style="color:red;">*</label><label for="txtPerTransmittalNo">EClaims Transmittal ID Number:</label>
                                                        <input type="text"
                                                               id="txtPerTransmittalNo"
                                                               name="txtPerTransmittalNo"
                                                               value=""
                                                               class="form-control"
                                                               style="width: 95%;"
                                                               maxlength="21"
                                                               placeholder="E-Claims Transmittal ID No."
                                                        />
                                                    </td>
                                                    <td style="width: 20%;">
                                                        <label style="color:red;">*</label><label for="txtPerClaimId">Claim ID Number:</label>
                                                        <input type="text"
                                                               id="txtPerClaimId"
                                                               name="txtPerClaimId"
                                                               value=""
                                                               class="form-control"
                                                               style="width: 95%;"
                                                               maxlength="21"
                                                               placeholder="Claim ID No."
                                                        />
                                                    </td>
                                                    <td style="width: 20%;">
                                                        <label style="color:red;">*</label><label>Patient PhilHealth Identification Number:</label>
                                                        <!--Patient PIN-->
                                                        <input type="text"
                                                               id="txtPerPatPIN"
                                                               name="txtPerPatPIN"
                                                               value=""
                                                               class="form-control"
                                                               style="width: 95%;"
                                                               minlength="12"
                                                               maxlength="12"
                                                               onkeypress="return isNumberKey(event);"
                                                               placeholder="Patient PIN"
                                                        />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%">
                                                        <label style="color:red;">*</label><label>Last Name:</label>
                                                        <input type="text"
                                                               id="txtPerPatLname"
                                                               name="txtPerPatLname"
                                                               value=""
                                                               class="form-control"
                                                               style="width: 95%;text-transform: uppercase;"
                                                               maxlength="20"
                                                               placeholder="Last Name"
                                                        />
                                                    </td>
                                                    <td style="width: 20%">
                                                        <label style="color:red;">*</label><label>First Name:</label>
                                                        <input type="text"
                                                               id="txtPerPatFname"
                                                               name="txtPerPatFname"
                                                               value=""
                                                               class="form-control"
                                                               style="width: 95%;text-transform: uppercase;"
                                                               maxlength="20"
                                                               placeholder="First Name"
                                                        />
                                                    </td>
                                                    <td style="width: 20%">
                                                        <label>Middle Name:</label>
                                                        <input type="text"
                                                               id="txtPerPatMname"
                                                               name="txtPerPatMname"
                                                               value=""
                                                               class="form-control"
                                                               style="width: 95%;text-transform: uppercase;"
                                                               maxlength="20"
                                                               placeholder="Middle Name"
                                                        />
                                                    </td>
                                                    <td style="width: 10%">
                                                        <label>Extension Name:</label>
                                                        <input type="text"
                                                               id="txtPerPatExtName"
                                                               name="txtPerPatExtName"
                                                               value=""
                                                               class="form-control"
                                                               style="width: 95%;text-transform: uppercase;"
                                                               maxlength="4"
                                                               placeholder="Extension Name"
                                                        />
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="width: 20%">
                                                        <label style="color:red;">*</label><label>Date of Birth (mm/dd/yyyy):</label><br/>
                                                        <input type="text"
                                                               id="txtPerPatBirthday"
                                                               name="txtPerPatBirthday"
                                                               value=""
                                                               class="datepicker form-control"
                                                               style="width: 95%;text-transform: uppercase;"
                                                               placeholder="Date of Birth"
                                                        />
                                                    </td>
                                                    <td style="width: 20%">
                                                        <label style="color:red;">*</label><label>Sex:</label><br/>
                                                        <select name="txtPerPatSex" id="txtPerPatSex" class="form-control" style="width: 95%;text-transform: uppercase;">
                                                            <option value="" selected disabled>Select Sex</option>
                                                            <?php
                                                            $sexX = getSex(true, '');
                                                            foreach($sexX as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td style="width: 20%">
                                                        <label style="color:red;">*</label><label>Civil Status:</label><br/>
                                                        <select name="txtPerPatStatus" id="txtPerPatStatus" class="form-control" style="width: 95%;text-transform: uppercase;">
                                                            <option value="" disabled selected>Select Civil Status</option>
                                                            <?php
                                                            $civilStatus = getCivilStatus(true, '');
                                                            foreach($civilStatus as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td style="width: 20%">
                                                        <label style="color:red;">*</label><label>Patient Type:</label><br/>
                                                        <select name="txtPerPatType" id="txtPerPatType" class="form-control" style="width: 95%;text-transform: uppercase;">
                                                            <option value="" selected disabled>Select Patient Type</option>
                                                            <?php
                                                            $patientType = getPatientType(true, '');
                                                            foreach($patientType as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $key; ?>" <?php if($key == 'NM') { ?> disabled <?php } ?>><?php echo $value; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                        <div style="text-align: center;">
                                            <input type="button"
                                                   class="btn btn-primary"
                                                   name="nextTab9"
                                                   id="nextTab9"
                                                   value="Next"
                                                   title="Go to Chief Complaint"
                                                   style="margin: 10px 0px 0px 0px;"
                                                   onclick="showTab('tab9');"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--TAB 1 - FAMILY AND PERSONAL HISTORY END-->

                            <div class="tab-pane fade" id="tab9">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Chief Complaint</h3>
                                    </div>
                                    <div class="panel-body">
                                        <fieldset style="margin: 0px; padding: 20px; background-color: #EDFCF0;">
                                            <label style="color:red;">*</label><label>Chief Complaint:</label>
                                            <textarea name="pChiefComplaint" id="pChiefComplaint" class="form-control" rows="5" maxlength="2000" style="resize: none; width: 100%;text-transform: uppercase"></textarea>
                                        </fieldset>
                                        <div style="text-align: center;">
                                            <input type="button"
                                                   class="btn btn-primary"
                                                   name="nextTab3"
                                                   id="nextTab3"
                                                   value="Next"
                                                   title="Go to History of Present Illness"
                                                   style="margin: 10px 0px 0px 0px;"
                                                   onclick="showTab('tab2');"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--TAB 2 - REASON FOR ADMISSION START-->
                            <div class="tab-pane fade" id="tab2">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">History of Present Illness</h3>
                                    </div>
                                    <div class="panel-body">
                                        <fieldset style="margin: 0px; padding: 20px; background-color: #EDFCF0;">
                                            <label style="color:red;">*</label><label>History of Present Illness:</label>
                                            <textarea name="pHistPresentIllness" id="pHistPresentIllness" class="form-control" rows="5" maxlength="2000" style="resize: none; width: 100%;text-transform: uppercase"></textarea>
                                        </fieldset>
                                        <div style="text-align: center;">
                                            <input type="button"
                                                   class="btn btn-primary"
                                                   name="nextTab3"
                                                   id="nextTab3"
                                                   value="Next"
                                                   title="Go to Pertinent Past Medical History"
                                                   style="margin: 10px 0px 0px 0px;"
                                                   onclick="showTab('tab3');"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--TAB 2 - REASON FOR ADMISSION END-->

                            <!--TAB 3 - MEDICAL HISTORY TAB START-->
                            <div class="tab-pane fade" id="tab3">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Pertinent Past Medical History</h3>
                                    </div>
                                    <div class="panel-body" id="obliSerTab">
                                        <fieldset style="margin: 0px; padding: 20px; background-color: #EDFCF0;">
                                            <label style="color:red;">*</label><label>Past Medical History:</label>
                                            <textarea name="txaMedHistOthers" id="txaMedHistOthers" class="form-control" rows="5" maxlength="2000" style="resize: none; width: 100%;text-transform: uppercase"></textarea>
                                        </fieldset>
                                        <div style="text-align: center;">
                                            <input type="button"
                                                   class="btn btn-primary"
                                                   name="nextTab4"
                                                   id="nextTab4"
                                                   value="Next"
                                                   title="Go to OB-Gyne History"
                                                   style="margin: 10px 0px 0px 0px;"
                                                   onclick="showTab('tab4');"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--TAB 3 - MEDICAL HISTORY TAB END-->

                            <!--TAB 4 - OB-GYNE HISTORY TAB START-->
                            <div class="tab-pane fade" id="tab4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">OB-Gyne History</h3>
                                    </div>
                                    <div class="panel-body">
                                        <fieldset style="margin: 0px; padding: 20px; background-color: #EDFCF0;<?php if ($px_data["PX_SEX"] == 'M') { ?>display:none;<?php } ?>" >
                                            <table border="0" width="100%" class="table-condensed">
                                                <col style="width: 25%;">
                                                <col style="width: 25%;">
                                                <col style="width: 25%;">
                                                <col style="width: 25%;">
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="alert alert-success" style="margin-bottom: 0px">
                                                            <?php if ($px_data["PX_SEX"] == 'F') { ?>
                                                                <font color="red">*</font>
                                                            <?php } ?><strong style="font-size: 16px">MENSTRUAL HISTORY</strong>
                                                            <div style="float:right;">
                                                                <span>
                                                                    <input id="mhDone_1"
                                                                           type="radio"
                                                                           name="mhDone"
                                                                           value="N"
                                                                           style="float: left;"
                                                                           onclick="disMenstrualHist();disPregHist();"
                                                                    />
                                                                    <label for="mhDone_1" style="margin: 3px 20px 0px 5px;">Not applicable</label>
                                                                </span>
                                                                <span>
                                                                    <input id="mhDone_2"
                                                                           type="radio"
                                                                           name="mhDone"
                                                                           value="Y"
                                                                           style="float: left;"
                                                                           onclick="enMenstrualHist();enPregHist();"
                                                                           checked="checked"
                                                                    />
                                                                    <label for="mhDone_1" style="margin: 3px 20px 0px 5px;">Applicable</label>
                                                                </span>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <table border="0" style="width: 65%;">
                                                            <col style="width: 30%;">
                                                            <col style="width: 35%;">
                                                            <col style="width: 30%;">
                                                            <col style="width: 5%;">
                                                            <tr>
                                                                <td><label style="color:red;">*</label><label>Last menstrual period:</label></td>
                                                            </tr>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <table>
                                                                        <tr>
                                                                            <td>
                                                                                <input type='text'
                                                                                       name='txtOBHistLastMens'
                                                                                       id="txtOBHistLastMens"
                                                                                       maxlength="10"
                                                                                       class='form-control datepicker'
                                                                                       placeholder="mm/dd/yyyy"
                                                                                       onkeypress="return acceptNumOnly(event);"
                                                                                       value=""
                                                                                />
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr><td>&nbsp;</td></tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="alert alert-success" style="margin-bottom: 0px">
                                                            <?php if ($px_data["PX_SEX"] == 'F') { ?>
                                                                <font color="red">*</font>
                                                            <?php } ?><strong style="font-size: 16px">PREGNANCY HISTORY</strong>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label style="color:red;">*</label><label>Gravidity (no. of pregnancy):</label></td>
                                                    <td><label style="color:red;">*</label><label>Parity (no. of delivery):</label></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type='text'
                                                        name='txtOBHistGravity'
                                                        id="txtOBHistGravity"
                                                        maxlength="2"
                                                        class='form-control'
                                                        onkeypress="return acceptNumOnly(event);"
                                                        value="<?php echo $px_data['PREG_CNT'];?>"
                                                        style="margin-right: 10px;"
                                                        />
                                                    </td>
                                                    <td>
                                                        <input type='text'
                                                        name='txtOBHistParity'
                                                        id="txtOBHistParity"
                                                        maxlength="2"
                                                        class='form-control'
                                                        onkeypress="return acceptNumOnly(event);"
                                                        value="<?php echo $px_data['DELIVERY_CNT'];?>"
                                                        />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label style="color:red;">*</label><label>No. of full term:</label></td>
                                                    <td><label style="color:red;">*</label><label>No. of premature:</label></td>
                                                    <td><label style="color:red;">*</label><label>No. of abortion:</label></td>
                                                    <td><label style="color:red;">*</label><label>No. of living children:</label></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type='text'
                                                               name='txtOBHistFullTerm'
                                                               id="txtOBHistFullTerm"
                                                               maxlength="2"
                                                               class='form-control'
                                                               onkeypress="return acceptNumOnly(event);"
                                                               value="<?php echo $px_data['FULL_TERM_CNT'];?>"
                                                        />
                                                    </td>
                                                    <td>
                                                        <input type='text'
                                                               name='txtOBHistPremature'
                                                               id="txtOBHistPremature"
                                                               maxlength="2"
                                                               class='form-control'
                                                               onkeypress="return acceptNumOnly(event);"
                                                               value="<?php echo $px_data['PREMATURE_CNT'];?>"
                                                        />
                                                    </td>
                                                    <td>
                                                        <input type='text'
                                                               name='txtOBHistAbortion'
                                                               id="txtOBHistAbortion"
                                                               maxlength="2"
                                                               class='form-control'
                                                               onkeypress="return acceptNumOnly(event);"
                                                               value="<?php echo $px_data['ABORTION_CNT'];?>"
                                                        />
                                                    </td>
                                                    <td>
                                                        <input type='text'
                                                               name='txtOBHistLivingChildren'
                                                               id="txtOBHistLivingChildren"
                                                               maxlength="2"
                                                               class='form-control'
                                                               onkeypress="return acceptNumOnly(event);"
                                                               value="<?php echo $px_data['LIV_CHILDREN_CNT'];?>"
                                                        />
                                                    </td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                        <div style="text-align: center;">
                                            <input type="button"
                                                   class="btn btn-primary"
                                                   name="nextTab5"
                                                   id="nextTab5"
                                                   value="Next"
                                                   title="Go to Pertinent Signs & Symptoms on Admission"
                                                   style="margin: 10px 0px 0px 0px;"
                                                   onclick="showTab('tab5');"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--TAB 4- OB-GYNE HISTORY TAB END-->

                            <!--TAB 5 - PERTINENT SIGNS & SYMPTOMS ON ADMISSION START-->
                            <div class="tab-pane fade" id="tab5">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Pertinent Signs & Symptoms on Admission</h3>
                                    </div>
                                    <div class="panel-body">
                                        <fieldset style="margin: 0px; padding: 20px; background-color: #EDFCF0;">
                                            <table border="0" style="width: 100%" class="table-condensed">
                                                <tr>
                                                    <td>
                                                        <div class="alert alert-success" style="margin-bottom: 0px">
                                                            <label style="color:red;">*</label><strong style="font-size: 16px">PERTINENT SIGNS & SYMPTOMS ON ADMISSION</strong>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <?php
                                                        $pLibComplaint = listComplaint();
                                                        for ($i = 0; $i < count($pLibComplaint); $i++) {
                                                            ?>
                                                            <input type="checkbox"
                                                                   name="pCf4Symptoms[]"
                                                                   id="<?php echo 'symptom_'.$pLibComplaint[$i]['SYMPTOMS_ID'];?>"
                                                                   value="<?php echo $pLibComplaint[$i]['SYMPTOMS_ID'];?>"
                                                                   style="cursor: pointer; float: left;"
                                                                   onclick="checkOtherChiefComplaint();"
                                                            />
                                                            <label for="<?php echo 'symptom_'.$pLibComplaint[$i]['SYMPTOMS_ID'];?>" style="cursor: pointer;float:left;margin: 4px 0px 0px 2px; font-weight: normal;"><?php echo $pLibComplaint[$i]['SYMPTOMS_DESC'];?></label>
                                                        <?php
                                                                if($pLibComplaint[$i]['SYMPTOMS_ID'] == '38'){ ?>
                                                                    <input type="text"
                                                                           name="pPainSite"
                                                                           id="pPainSite"
                                                                           class="form-control"
                                                                           style="width: 500px; color: #000; margin: 0px 10px 0px 10px; text-transform: uppercase; resize: none;display:none"
                                                                           placeholder="Input the Site of Pain here..."
                                                                           autocomplete="off"
                                                                           value=""
                                                                           maxlength="500"
                                                                    />
                                                                    <br/>
                                                        <?php
                                                                }
                                                                else{
                                                                   echo '<br/>';
                                                                }
                                                            }
                                                        ?>
                                                        <input type="checkbox"
                                                               name="pCf4Symptoms[]"
                                                               id="symptom_X"
                                                               value="X"
                                                               style="cursor: pointer; float: left;"
                                                               onclick="checkOtherChiefComplaint();"
                                                        />
                                                        <label for="symptom_X" style="cursor: pointer;float:left;margin: 4px 0px 0px 2px; font-weight: normal;">OTHERS</label><br/>
                                                        <input type="text"
                                                               name="pCf4OtherSymptoms"
                                                               id="pOtherChiefComplaint"
                                                               class="form-control"
                                                               style="width: 500px; color: #000; margin: 0px 10px 0px 10px; text-transform: uppercase; resize: none;display:none"
                                                               placeholder="OTHERS"
                                                               autocomplete="off"
                                                               value=""
                                                               maxlength="500"
                                                               disabled
                                                        />
                                                    </td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                        <div style="text-align: center;">
                                            <input type="button"
                                                   class="btn btn-primary"
                                                   name="nextTab6"
                                                   id="nextTab6"
                                                   value="Next"
                                                   title="Go to Physical Examination on Admission"
                                                   style="margin: 10px 0px 0px 0px;"
                                                   onclick="showTab('tab6');"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--TAB 5 - PERTINENT SIGNS & SYMPTOMS ON ADMISSION END-->

                            <!--TAB 6 - PERTINENT PHYSICAL EXAMINATION FINDINGS TAB START-->
                            <div class="tab-pane fade" id="tab6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Physical Examination on Admission</h3>
                                    </div>
                                    <div class="panel-body">
                                        <fieldset style="margin: 0px; padding: 20px; background-color: #EDFCF0;">
                                            <!--PERTINENT PHYSICAL EXAMINATION FINDINGS-->
                                            <table border="0" style="width: 100%" class="table-condensed">
                                                <col style="width: 35%;">
                                                <col style="width: 65%;">
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="alert alert-success" style="margin-bottom: 0px">
                                                            <label style="color:red;">*</label><strong style="font-size: 16px">PERTINENT FINDINGS PER SYSTEM</strong>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="vertical-align: top;">
                                                        <table width="100%">
                                                            <tr>
                                                                <td><label style="color:red;">*</label><label for="txtMedHistBPSystolic" title="Blood Pressure">BP:</label></td>
                                                                <td>
                                                                    <label class="form-inline">
                                                                        <input type='text'
                                                                               name='txtPhExSystolic'
                                                                               id="txtPhExSystolic"
                                                                               maxlength="3"
                                                                               class='form-control'
                                                                               style="width: 50px;"
                                                                               onkeypress="return isNumberKey(event);"
                                                                               value="<?php echo $px_data['SYSTOLIC']; ?>"
                                                                        /> /

                                                                        <input type='text'
                                                                               name='txtPhExBPDiastolic'
                                                                               id="txtPhExBPDiastolic"
                                                                               maxlength="3"
                                                                               class='form-control'
                                                                               style="width: 50px;"
                                                                               onkeypress="return isNumberKey(event);"
                                                                               value="<?php echo $px_data['DIASTOLIC']; ?>"
                                                                        /> mmHg
                                                                    </label>
                                                                </td>
                                                                <td><label style="color:red;">*</label><label for="txtPhExHeartRate" title="Heart Rate">HR:</label></td>
                                                                <td>
                                                                    <label class="form-inline">
                                                                        <input type='text'
                                                                               name='txtPhExHeartRate'
                                                                               id="txtPhExHeartRate"
                                                                               maxlength="3"
                                                                               class='form-control'
                                                                               style="width:150px;"
                                                                               onkeypress="return isNumberKey(event);"
                                                                               value="<?php echo $px_data['HR']; ?>"
                                                                        /> /min
                                                                    </label>
                                                                </td>
                                                                <td><label style="color:red;">*</label><label for="txtPhExRespiratoryRate" title="Respiratory Rate">RR:</label></td>
                                                                <td>
                                                                    <label class="form-inline">
                                                                        <input type='text'
                                                                               name='txtPhExRespiratoryRate'
                                                                               id="txtPhExRespiratoryRate"
                                                                               maxlength="3"
                                                                               class='form-control'
                                                                               style="width:150px;"
                                                                               onkeypress="return isNumberKey(event);"
                                                                               value="<?php echo $px_data['RR']; ?>"
                                                                        /> /min
                                                                    </label>
                                                                </td>
                                                                <td><label style="color:red;">*</label><label for="txtPhExTemp" title="Temperature">Temperature:</label></td>
                                                                <td>
                                                                    <label class="form-inline">
                                                                        <input type='text'
                                                                               name='txtPhExTemp'
                                                                               id="txtPhExTemp"
                                                                               maxlength="4"
                                                                               class='form-control'
                                                                               style="width:150px;"
                                                                               onkeypress="return isNumberWithDecimalKey(event);"
                                                                               value="<?php echo $px_data['TEMPERATURE']; ?>"
                                                                        /> &#176;C
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <table>
                                                            <tr>
                                                                <td><label style="color:red;margin-top:20px">*</label><label for="txtGenSurvey" title="General Survey" style="margin-top:20px;">General Survey:</label></td>
                                                                <td>
                                                                    <input type="radio"
                                                                           name="pGenSurvey"
                                                                           value="1"
                                                                           id="pGenSurvey_1"
                                                                           style="cursor: pointer; float: left;margin:20px 0px 0px 5px;"
                                                                           onclick="setDisabled('<?php echo "pGenSurveyRem";?>',true)"
                                                                    />
                                                                    <label for="pGenSurvey_1" style="font-weight: normal; cursor: pointer; float: left; margin: 20px 5px 0px 5px; ">Awake and alert</label>
                                                                </td>
                                                                <td>
                                                                    <input type="radio"
                                                                           name="pGenSurvey"
                                                                           value="2"
                                                                           id="pGenSurvey_2"
                                                                           style="cursor: pointer; float: left;margin:20px 0px 0px 10px;"
                                                                           onclick="setDisabled('<?php echo "pGenSurveyRem";?>',false)"
                                                                    />
                                                                    <label for="pGenSurvey_2" style="font-weight: normal; cursor: pointer; float: left; margin: 20px 5px 0px 5px; ">Altered Sensorium</label>
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                           name="pGenSurveyRemarks"
                                                                           value=""
                                                                           id="pGenSurveyRem"
                                                                           class="form-control"
                                                                           style="margin:20px 0px 0px 5px;text-transform: uppercase;"
                                                                           maxlength="500"
                                                                           disabled
                                                                    />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr id="heent_info">
                                                    <td>
                                                        <h5><label style="color:red;">*</label><u style="font-weight: bold;">A. HEENT</u></h5>
                                                        <table style="margin: 5px 0px 0px 20px; text-align: left;">
                                                            <?php foreach ($listHeents as $pLibHEENT) { ?>
                                                                <tr>
                                                                    <td style="width: 250px;">
                                                                        <input type="checkbox"
                                                                               name="heent[]"
                                                                               id="<?php echo 'heent_'.$pLibHEENT['HEENT_ID'];?>"
                                                                               value="<?php echo $pLibHEENT['HEENT_ID'];?>"
                                                                               style="cursor: pointer; float: left;"
                                                                            <?php if($hsa_transNo != null) {
                                                                                foreach($descPertinentMisc as $descPertinent) {
                                                                                    if ($descPertinent['HEENT_ID'] == $pLibHEENT['HEENT_ID']) { ?>
                                                                                        checked
                                                                                    <?php }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        >
                                                                        <label for="<?php echo 'heent_'.$pLibHEENT['HEENT_ID'];?>" style="margin: 4px 0px 0px 2px; font-weight: normal; cursor: pointer; float: left;"><?php echo $pLibHEENT['HEENT_DESC'];?></label><br/>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <label>Others:</label><br/>
                                                        <textarea name="heent_remarks"
                                                                  id="heent_remarks"
                                                                  class="form-control"
                                                                  style="width: 500px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase; resize: none;"
                                                                  autocomplete="off"
                                                                  maxlength="500"
                                                                  rows="3"><?php echo $px_data['HEENT_REM']; ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr id="chest_lungs_info">
                                                    <td>
                                                        <h5><label style="color:red;">*</label><u style="font-weight: bold;">B. Chest/Lungs</u></h5>
                                                        <table style="margin: 5px 0px 0px 20px; text-align: left;">
                                                            <?php foreach ($listChests as $pLibChest) { ?>
                                                                <tr>
                                                                    <td style="width: 250px;">
                                                                        <input type="checkbox"
                                                                               name="chest[]"
                                                                               id="<?php echo 'chest_'.$pLibChest['CHEST_ID'];?>"
                                                                               value="<?php echo $pLibChest['CHEST_ID'];?>"
                                                                               style="cursor: pointer; float: left;"
                                                                            <?php if($hsa_transNo != null) {
                                                                                foreach($descPertinentMisc as $descPertinent) {
                                                                                    if ($descPertinent['CHEST_ID'] == $pLibChest['CHEST_ID']) { ?>
                                                                                        checked
                                                                                    <?php }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        />
                                                                        <label for="<?php echo 'chest_'.$pLibChest['CHEST_ID'];?>" style="margin: 4px 0px 0px 2px; font-weight: normal; cursor: pointer; float: left;"><?php echo $pLibChest['CHEST_DESC'];?></label><br/>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <label>Others:</label><br/>
                                                        <textarea name="chest_lungs_remarks" id="chest_lungs_remarks" class="form-control" style="width: 500px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase; resize: none;" autocomplete="off" rows="3" maxlength="500"><?php echo $px_data['CHEST_REM']; ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr id="heart_info">
                                                    <td>
                                                        <h5><label style="color:red;">*</label><u style="font-weight: bold;">C. CVS</u></h5>
                                                        <table style="margin: 5px 0px 0px 20px; text-align: left;">
                                                            <?php foreach ($listHearts as $pLibHeart) { ?>
                                                                <tr>
                                                                    <td style="width: 250px;">
                                                                        <input type="checkbox"
                                                                               name="heart[]"
                                                                               id="<?php echo 'heart_'.$pLibHeart['HEART_ID'];?>"
                                                                               value="<?php echo $pLibHeart['HEART_ID'];?>"
                                                                               style="cursor: pointer; float: left;"
                                                                            <?php if($hsa_transNo != null) {
                                                                                foreach($descPertinentMisc as $descPertinent) {
                                                                                    if ($descPertinent['HEART_ID'] == $pLibHeart['HEART_ID']) { ?>
                                                                                        checked
                                                                                    <?php }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        />
                                                                        <label for="<?php echo 'heart_'.$pLibHeart['HEART_ID'];?>" style="margin: 4px 0px 0px 2px; font-weight: normal; cursor: pointer; float: left;"><?php echo $pLibHeart['HEART_DESC'];?></label><br/>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <label>Others:</label><br/>
                                                        <textarea name="heart_remarks" id="heart_remarks" class="form-control" style="width: 500px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase; resize: none;" autocomplete="off" rows="3" maxlength="500"><?php echo $px_data['HEART_REM']; ?></textarea>
                                                    </td>
                                                </tr>

                                                <tr id="abdomen_info">
                                                    <td>
                                                        <h5><label style="color:red;">*</label><u style="font-weight: bold;">D. Abdomen</u></h5>
                                                        <table style="margin: 5px 0px 0px 20px; text-align: left;">
                                                            <?php foreach ($listAbs as $pLibAbdomen) { ?>
                                                                <tr>
                                                                    <td style="width: 250px;">
                                                                        <input type="checkbox"
                                                                               name="abdomen[]"
                                                                               id="<?php echo 'abdomen_'.$pLibAbdomen['ABDOMEN_ID'];?>"
                                                                               value="<?php echo $pLibAbdomen['ABDOMEN_ID'];?>" style="cursor: pointer; float: left;"
                                                                            <?php if($hsa_transNo != null) {
                                                                                foreach($descPertinentMisc as $descPertinent) {
                                                                                    if ($descPertinent['ABDOMEN_ID'] == $pLibAbdomen['ABDOMEN_ID']) { ?>
                                                                                        checked
                                                                                    <?php }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        />
                                                                        <label for="<?php echo 'abdomen_'.$pLibAbdomen['ABDOMEN_ID'];?>" style="margin: 4px 0px 0px 2px; font-weight: normal; cursor: pointer; float: left;"><?php echo $pLibAbdomen['ABDOMEN_DESC'];?></label><br/>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <label>Others:</label><br/>
                                                        <textarea name="abdomen_remarks" id="abdomen_remarks" class="form-control" style="width: 500px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase; resize: none;" autocomplete="off" rows="3" maxlength="500"><?php echo $px_data['ABDOMEN_REM']; ?></textarea>
                                                    </td>
                                                </tr>

                                                <tr id="gu_info">
                                                    <td>
                                                        <h5><label style="color:red;">*</label><u style="font-weight: bold;">E. GU (IE)</u></h5>
                                                        <table style="margin: 5px 0px 0px 20px; text-align: left;">
                                                            <?php foreach ($listGenitourinary  as $pLibGU) { ?>
                                                                <tr>
                                                                    <td style="width: 250px;">
                                                                        <input type="checkbox"
                                                                               name="genitourinary[]"
                                                                               id="<?php echo 'gu_'.$pLibGU['GU_ID'];?>"
                                                                               value="<?php echo $pLibGU['GU_ID'];?>" style="cursor: pointer; float: left;"
                                                                            <?php if($hsa_transNo != null) {
                                                                                foreach($descPertinentMisc as $descPertinent) {
                                                                                    if ($descPertinent['GU_ID'] == $pLibGU['GU_ID']) { ?>
                                                                                        checked
                                                                                    <?php }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        />
                                                                        <label for="<?php echo 'gu_'.$pLibGU['GU_ID'];?>" style="margin: 4px 0px 0px 2px; font-weight: normal; cursor: pointer; float: left;"><?php echo $pLibGU['GU_DESC'];?></label><br/>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <label>Others:</label><br/>
                                                        <textarea name="gu_remarks" id="gu_remarks" class="form-control" style="width: 500px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase; resize: none;" autocomplete="off" rows="3" maxlength="500"><?php echo $px_data['GU_REMARKS']; ?></textarea>
                                                    </td>
                                                </tr>

                                                <tr id="skin_extremities_info">
                                                    <td>
                                                        <h5><label style="color:red;">*</label><u style="font-weight: bold;">F. Skin/Extremities</u></h5>
                                                        <table style="margin: 5px 0px 0px 20px; text-align: left;">
                                                            <?php foreach ($listSkinExtremities as $pLibExtremities) { ?>
                                                                <tr>
                                                                    <td style="width: 250px;">
                                                                        <input type="checkbox"
                                                                               name="skinExtremities[]"
                                                                               id="<?php echo 'extremities_'.$pLibExtremities['SKIN_ID'];?>"
                                                                               value="<?php echo $pLibExtremities['SKIN_ID'];?>"
                                                                               style="cursor: pointer; float: left;"
                                                                            <?php if($hsa_transNo != null) {
                                                                                foreach($descPertinentMisc as $descPertinent) {
                                                                                    if ($descPertinent['SKIN_ID'] == $pLibExtremities['SKIN_ID']) { ?>
                                                                                        checked
                                                                                    <?php }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        />
                                                                        <label for="<?php echo 'extremities_'.$pLibExtremities['SKIN_ID'];?>" style="margin: 4px 0px 0px 2px; font-weight: normal; cursor: pointer; float: left;"><?php echo $pLibExtremities['SKIN_DESC'];?></label><br/>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <label>Others:</label><br/>
                                                        <textarea name="skinExtremities_remarks" id="extremities_remarks" class="form-control" style="width: 500px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase; resize: none;" autocomplete="off" rows="3" maxlength="500"><?php echo $px_data['EXTREME_REM']; ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr id="neuro_info">
                                                    <td>
                                                        <h5><label style="color:red;">*</label><u style="font-weight: bold;">G. Neurological Examination</u></h5>
                                                        <table style="margin: 5px 0px 0px 20px; text-align: left;">
                                                            <?php foreach ($listNeuro as $pLibNeuro) { ?>
                                                                <tr>
                                                                    <td style="width: 250px;">
                                                                        <input type="checkbox"
                                                                               name="neuro[]"
                                                                               id="<?php echo 'neuro_'.$pLibNeuro['NEURO_ID'];?>"
                                                                               value="<?php echo $pLibNeuro['NEURO_ID'];?>"
                                                                               style="cursor: pointer; float: left;"
                                                                            <?php if($hsa_transNo != null) {
                                                                                foreach($descPertinentMisc as $descPertinent) {
                                                                                    if ($descPertinent['NEURO_ID'] == $pLibNeuro['NEURO_ID']) { ?>
                                                                                        checked
                                                                                    <?php }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        />
                                                                        <label for="<?php echo 'neuro_'.$pLibNeuro['NEURO_ID'];?>" style="margin: 4px 0px 0px 2px; font-weight: normal; cursor: pointer; float: left;"><?php echo $pLibNeuro['NEURO_DESC'];?></label><br/>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <label>Others:</label><br/>
                                                        <textarea name="neuro_remarks" id="neuro_remarks" class="form-control" style="width: 500px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase; resize: none;" autocomplete="off" rows="3" maxlength="500"><?php echo $px_data['NEURO_REM']; ?></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                        <div style="text-align: center;">
                                            <input type="button"
                                                   class="btn btn-primary"
                                                   name="nextTab7"
                                                   id="nextTab7"
                                                   value="Next"
                                                   title="Go to Course in the Ward"
                                                   style="margin: 10px 0px 0px 0px;"
                                                   onclick="showTab('tab7');"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--PERTINENT PHYSICAL EXAMINATION FINDINGS TAB END-->

                            <!--TAB 7 - COURSE IN THE WARD START-->
                            <div class="tab-pane fade" id="tab7">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Course in the Ward</h3>
                                    </div>
                                    <div class="panel-body">
                                        <fieldset style="width:100%;margin: 0px 0px 10px 0px; padding: 20px; background-color: #EDFCF0;">
                                            <table style="width:100%;">
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="alert alert-success" style="margin-bottom: 2px">
                                                            <label style="color:red;">*</label><strong style="font-size: 16px">COURSE IN THE WARD</strong>
                                                        </div>

                                                        <table id="tblCourseWard" class="table table-condensed table-bordered">
                                                            <col width="15%">
                                                            <col width="75%">
                                                            <col width="10%">
                                                            <thead>
                                                            <tr>
                                                                <th>DATE</th>
                                                                <th>DOCTOR'S ORDER/ACTION</th>
                                                                <th>&nbsp;</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td style="vertical-align: middle">
                                                                    <input type="text"
                                                                           id="txtWardDateOrder"
                                                                           placeholder='mm/dd/yyyy'
                                                                           class="datepicker form-control"
                                                                           onkeypress="formatDate('<?php echo "txtWardDateOrder"; ?>')"
                                                                           maxlength="10"
                                                                           autocomplete="off"
                                                                           style="text-align: center;"
                                                                    />
                                                                </td>
                                                                <td>
                                                                    <textarea id="txtWardDocAction" onkeyup="resizeTextAreaCf4();" class='form-control' rows="1" maxlength="1000" style="resize: none; width: 100%;text-transform: uppercase;"></textarea>
                                                                </td>
                                                                <td style="vertical-align: middle">
                                                                    <button type="button" class="btn btn-success" style="width: 100%" onclick="addCourseInTheWard();">Add</button>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                        <div style="text-align: center;">
                                            <input type="button"
                                                   class="btn btn-primary"
                                                   name="nextTab8"
                                                   id="nextTab8"
                                                   value="Next"
                                                   title="Go to Medicine"
                                                   style="margin: 10px 0px 0px 0px;"
                                                   onclick="showTab('tab8');"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--TAB 7 - COURSE IN THE WARD END-->

                            <!--START TAB MEDICINE-->
                            <div class="tab-pane fade" id="tab8">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Medicine</h3>
                                    </div>
                                    <div class="panel-body">
                                        <fieldset style="margin: 0px 0px 10px 0px; padding: 20px; background-color: #EDFCF0;">
                                            <div class="alert alert-success" style="margin-bottom: 0px">
                                                <strong style="font-size: 16px">DRUG PRESCRIPTION</strong>
                                            </div>

                                            <table id="tblPrescribeMeds" class="table table-bordered table-condensed" style="width:100%">
                                                <tr>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><label style="text-decoration: underline;">MEDICINE</label></td>
                                                            </tr>
                                                        </table>
                                                        <table style="margin-top: 5px; text-align: left;">
                                                            <tr>
                                                                <th><label style="font-size:13px;">Complete Drug Description</label></th>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <select name="pDrugCode" id="pDrugCode" class="form-control" style="width:300px;margin:0px 10px 0px 0px;" onChange="loadMedsGeneric(this.value);loadMedsStrength(this.value);loadMedsForm(this.value);loadMedsPackage(this.value);loadMedsSalt(this.value);loadMedsUnit(this.value);">
                                                                        <option value selected="selected" disabled>Select Drug Name</option>
                                                                        <?php
                                                                        $pLibDrugs = listDrugsDesc();
                                                                        foreach ($pLibDrugs as $pLibDrug){
                                                                            $drugCode= $pLibDrug['DRUG_CODE'];
                                                                            $drugDesc= $pLibDrug['DRUG_DESC'];
                                                                            ?>
                                                                            <option value="<?php echo $drugCode;?>"><?php echo $drugDesc;?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table style="margin-top: 15px; text-align: left;">
                                                            <tr>
                                                                <th><label style="font-style: italic;font-weight: normal;">Generic Name</label></th>
                                                                <th><label style="font-style: italic;font-weight: normal;">Salt</label></th>
                                                                <th><label style="font-style: italic;font-weight: normal;">Strength</label></th>
                                                                <th><label style="font-style: italic;font-weight: normal;">Form</label></th>
                                                                <th><label style="font-style: italic;font-weight: normal;">Unit</label></th>
                                                                <th><label style="font-style: italic;font-weight: normal;">Package</label></th>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <select name="pGeneric" id="pGeneric" class="form-control" style="width:220px;margin:0px 10px 0px 0px;">
                                                                        <option value selected="selected"></option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="pSalt" id="pSalt" class="form-control" style="width:100px;margin:0px 10px 0px 0px;">
                                                                        <option value selected="selected"></option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="pStrength" id="pStrength" class="form-control" style="width:100px;margin:0px 10px 0px 0px;">
                                                                        <option value selected="selected"></option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="pForm" id="pForm" class="form-control" style="width:100px; margin:0px 10px 0px 0px;">
                                                                        <option value selected="selected"></option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="pUnit" id="pUnit" class="form-control" style="width:100px;margin:0px 10px 0px 0px;">
                                                                        <option value selected="selected"></option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="pPackage" id="pPackage" class="form-control" style="width:100px;margin:0px 10px 0px 0px;">
                                                                        <option value selected="selected"></option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table style="margin-top: 15px; text-align: left;">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <label style="font-size:11px;color: red;"><i>Note: If Medicine is not available in the list, kindly input  the drug description below as required:</i></label><br/>
                                                                        <label style="font-size:13px;">Generic Name/Salt/Strength/Form/Unit/Package</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="text"
                                                                               name="pGenericFreeText"
                                                                               id="pGenericFreeText"
                                                                               class="form-control"
                                                                               value=""
                                                                               style="width: 100%; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase"
                                                                               autocomplete="off"
                                                                               maxlength="500"
                                                                        />
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table style="margin-top: 15px; text-align: left;">
                                                            <tbody>
                                                                <tr>
                                                                    <td><label style="font-size:13px;">Route</label></td>
                                                                    <td><label style="font-size:13px;">Frequency</label></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="text"
                                                                               name="pRoute"
                                                                               id="pRoute"
                                                                               class="form-control"
                                                                               value=""
                                                                               style="width: 220px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase"
                                                                               autocomplete="off"
                                                                               maxlength="500"
                                                                        />
                                                                    </td>

                                                                    <td>
                                                                        <input type="text"
                                                                               name="pFrequencyInstruction"
                                                                               id="pFrequencyInstruction"
                                                                               class="form-control"
                                                                               value=""
                                                                               style="width: 220px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase"
                                                                               autocomplete="off"
                                                                               maxlength="500"
                                                                        />
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table style="margin-top: 15px; text-align: left;">
                                                            <tr>
                                                                <td><label style="font-size:13px;">Quantity</label></td>
                                                                <td><label style="font-size:13px;">Total Amount Price</label></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="text"
                                                                           name="pQuantity"
                                                                           id="pQuantity"
                                                                           class="form-control"
                                                                           value=""
                                                                           style="width: 80px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase"
                                                                           autocomplete="off"
                                                                           maxlength="5"
                                                                           onkeypress="return isNumberKey(event);"
                                                                    />
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                           name="pTotalPrice"
                                                                           id="pTotalPrice"
                                                                           class="form-control"
                                                                           value=""
                                                                           style="width: 150px; color: #000; margin: 0px 10px 0px 0px; text-transform: uppercase"
                                                                           autocomplete="off"
                                                                           maxlength="15"
                                                                           onkeypress="return isNumberWithDecimalKey(event);"
                                                                    />
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </td>
                                                    <td>
                                                        <input type="button"
                                                               name="btnAddMeds"
                                                               id="btnAddMeds"
                                                               class="btn btn-warning"
                                                               style="color:#000000;margin: 150px 0px 0px 0px;"
                                                               onclick="addMedicineCf4();"
                                                               value="Add Medicine"
                                                               title="Add Medicine"
                                                        />
                                                    </td>
                                                </tr>
                                            </table>

                                            <!--START DISPLAY ADDED MEDICINE-->
                                            <div style="font-weight: normal;font-style: italic;font-size:11px;color:#8b0000">Click 'Add Medicine' button to add medicine in the list.</div>
                                            <table id="tblResultsMeds" class="table table-bordered table-hover" style="font-weight: normal;font-size:11px;">
                                                <thead>
                                                <tr>
                                                    <th colspan="5">List of Medicine</th>
                                                    <th rowspan="2"></th>
                                                </tr>
                                                <tr>
                                                    <th style='vertical-align: middle;'>Drug Description</th>
                                                    <th style='vertical-align: middle;'>Route</th>
                                                    <th style='vertical-align: middle;'>Frequency</th>
                                                    <th style='vertical-align: middle;'>Quantity</th>
                                                    <th style='vertical-align: middle;'>Total Amount Price</th>
                                                </tr>
                                                </thead>
                                                <tbody id="tblBodyMeds">
                                                <?php
                                                if($hsa_transNo != null) {
                                                    for ($i = 0; $i < count($descMedicine); $i++) {
                                                        $pDrugCode = $descMedicine[$i]['DRUG_CODE'];
                                                        $pGenCode = $descMedicine[$i]['GEN_CODE'];
                                                        $pQty = $descMedicine[$i]['QUANTITY'];
                                                        $pStreCode = $descMedicine[$i]['INS_STRENGTH'];
                                                        $pFrequency = $descMedicine[$i]['INS_FREQUENCY'];
                                                        $pInsQty = $descMedicine[$i]['INS_QUANTITY'];
                                                        $pActualPrice = $descMedicine[$i]['DRUG_ACTUAL_PRICE'];
                                                        $pTotalPrice = $descMedicine[$i]['AMT_PRICE'];

                                                        if ($i % 2 != 1) {
                                                            echo '<tr style="background-color: #FBFCC7;">';
                                                        } else {
                                                            echo '<tr>';
                                                        }
                                                        echo '<td>' . $pGenCode . '</td>';
                                                        echo '<td>' . $pFrequency . '</td>';
                                                        echo '<td>' . $pFrequency . '</td>';
                                                        echo '<td>' . $pQty . '</td>';
                                                        echo '<td>' . $pTotalPrice . '</td>';
                                                        echo '<td></td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                            </table> <!--END DISPLAY ADDED MEDICINE-->
                                        </fieldset>

                                        <div style="text-align: center;">
                                            <input type="submit"
                                                   class="btn btn-primary"
                                                   name="submitCf4"
                                                   id="saveCf4"
                                                   value="Submit"
                                                   title="Submit CF4 Record"
                                                   style="margin-left: 10px;"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END TAB MEDICINE-->
                        </div>
                    </td>
                </tr>
                <tr style="">
                    <td><div align="left"><font color="red" style="font-size: 10px; font-family: Verdana, Geneva, sans-serif;"><i>NOTE: All fields marked with asterisk (*) are required.</i></font></div></td>
                </tr>
                <tr style="height: 10px;">
                    <td></td>
                </tr>
            </table>
        </form>
        <br/><br/><br/>

        <div id="result" style="margin: 30px 0px 30px 0px; display: none;" align="center">
        </div>

    </div>
</div>

<?php
include('footer.php');
?>

<script>
    $(function() {
        $( ".datepicker" ).datepicker();
    });

    $("#txtOBHistLastMens").mask("99/99/9999");
    $("#txtPerPatBirthday").mask("99/99/9999");
    $("#txtWardDateOrder").mask("99/99/9999");

    $("#txtOBHistLastMens").datepicker({ maxDate: new Date, minDate: new Date(2007, 6, 12) });
    $("#txtPerPatBirthday").datepicker({ maxDate: new Date, minDate: new Date(1900, 6, 12) });

</script>
