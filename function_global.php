<?php
error_reporting(0);
date_default_timezone_set('Asia/Manila');
/*Library Functions*/
/* Get Civil Status */
function getCivilStatus($list, $str) {
    $pCivilStatusLib = array(
        'S' => 'SINGLE',
        'M' => 'MARRIED',
        'W' => 'WIDOWED',
        'X' => 'SEPARATED',
        'A' => 'ANNULLED');

    if ($list == TRUE) {
        return $pCivilStatusLib;
    }
    else {
        foreach($pCivilStatusLib as $id => $value) {
            if ($id == $str) {
                return $value;
                break;
            }
        }
    }
}

/* Get Sex */
function getSex($list, $str) {
    $pSexLib = array(
        'M' => 'MALE',
        'F' => 'FEMALE');

    if ($list == TRUE) {
        return $pSexLib;
    }
    else {
        $pSexLib['0'] = 'MALE'; //savr 2016-04-08: added this part to handle 0 value of sex
        $pSexLib['1'] = 'FEMALE'; //savr 2016-04-08: added this part to handle 1 value of sex

        foreach($pSexLib as $id => $value) {
            if ($id == $str) {
                return $value;
                break;
            }
        }
    }
}

/* Get Patient Type */
function getPatientType($list, $str) {
    $pPatientTypeLib = array(
        'MM' => 'MEMBER',
        'DD' => 'DEPENDENT',
        'NM' => 'NON-MEMBER');

    if ($list == TRUE) {
        return $pPatientTypeLib;
    }
    else {
        foreach($pPatientTypeLib as $id => $value) {
            if ($id == $str) {
                return $value;
                break;
            }
        }
    }
}

/* Get Patient Type -added by ZIA*/
function getDependentType($list, $str) {
    $pDependentTypeLib = array(
        'S' => 'SPOUSE',
        'C' => 'CHILD',
        'P' => 'PARENT');

    if ($list == TRUE) {
        return $pDependentTypeLib;
    }
    else {
        foreach($pDependentTypeLib as $id => $value) {
            if ($id == $str) {
                return $value;
                break;
            }
        }
    }
}

/* Get Type of Generation*/
function getTypeOfSector($list, $str) {
    $pSector = array(
        'G' => 'GOVERNMENT',
        'P' => 'PRIVATE');

    if ($list == TRUE) {
        return $pSector;
    }
    else {
        foreach($pSector as $id => $value) {
            if ($id == $str) {
                return $value;
                break;
            }
        }
    }
}

function generateCf4Xml($genResultEnlist, $genResultProfiling, $displayResultCourseWard, $genProfilingMedHist, $genProfilingMHspecific, $genProfilingPemisc,
                         $genResultConsultation,  $genResultMedicine)
{
    $epcb = new SimpleXMLElement("<EPCB></EPCB>");

    $pReportTransNo = generateTransNo('REPORT_TRANS_NO');
    $pDateRange = date('Y-m-d');

    $epcb->addAttribute("pUsername", strtoupper($_SESSION['pUserID']));
    $epcb->addAttribute("pPassword", strtoupper($_SESSION['pUserPassword']));
    $epcb->addAttribute("pHciAccreNo", $_SESSION['pAccreNum']);
    $epcb->addAttribute("pEnlistTotalCnt", 1);
    $epcb->addAttribute("pProfileTotalCnt", 1);
    $epcb->addAttribute("pSoapTotalCnt", 1);
    $epcb->addAttribute("pEmrId", "EXPS");
    $epcb->addAttribute("pCertificationId", "EPCB-00-10-2018-00001");
    $epcb->addAttribute("pHciTransmittalNumber", $pReportTransNo);

    /*ENLISTMENT XML GENERATION*/
    $enlistments = $epcb->addChild("ENLISTMENTS");
    $enlistment = $enlistments->addChild("ENLISTMENT");
    $enlistment->addAttribute("pEClaimId", $genResultEnlist['CLAIM_ID']);
    $enlistment->addAttribute("pEClaimsTransmittalId", $genResultEnlist['CLAIM_TRANS_ID']);
    $enlistment->addAttribute("pHciCaseNo", $genResultEnlist['CASE_NO']);
    $enlistment->addAttribute("pHciTransNo", $genResultEnlist['TRANS_NO']);
    $enlistment->addAttribute("pEffYear", $genResultEnlist['EFF_YEAR']);
    $enlistment->addAttribute("pEnlistStat", "1");
    $enlistment->addAttribute("pEnlistDate", $genResultEnlist['ENLIST_DATE']);
    $enlistment->addAttribute("pPackageType", $genResultEnlist['PACKAGE_TYPE']);
    $enlistment->addAttribute("pMemPin", $genResultEnlist['MEM_PIN']);
    $enlistment->addAttribute("pMemFname", "");
    $enlistment->addAttribute("pMemMname", "");
    $enlistment->addAttribute("pMemLname", "");
    $enlistment->addAttribute("pMemExtname", "");
    $enlistment->addAttribute("pMemDob", "");
    $enlistment->addAttribute("pMemCat", "");
    $enlistment->addAttribute("pMemNcat", "");
    $enlistment->addAttribute("pPatientPin", $genResultEnlist['PX_PIN']);
    $enlistment->addAttribute("pPatientFname", $genResultEnlist['PX_FNAME']);
    $enlistment->addAttribute("pPatientMname", $genResultEnlist['PX_MNAME']);
    $enlistment->addAttribute("pPatientLname", $genResultEnlist['PX_LNAME']);
    $enlistment->addAttribute("pPatientExtname", $genResultEnlist['PX_EXTNAME']);
    $enlistment->addAttribute("pPatientType", $genResultEnlist['PX_TYPE']);
    $enlistment->addAttribute("pPatientSex", $genResultEnlist['PX_SEX']);
    $enlistment->addAttribute("pPatientContactno", "NA");
    $enlistment->addAttribute("pPatientDob", $genResultEnlist['PX_DOB']);
    $enlistment->addAttribute("pPatientAddbrgy", "");
    $enlistment->addAttribute("pPatientAddmun", "");
    $enlistment->addAttribute("pPatientAddprov", "");
    $enlistment->addAttribute("pPatientAddreg", "");
    $enlistment->addAttribute("pPatientAddzipcode", "");
    $enlistment->addAttribute("pCivilStatus", $genResultEnlist['CIVIL_STATUS']);
    $enlistment->addAttribute("pWithConsent", "X");
    $enlistment->addAttribute("pWithLoa", "X");
    $enlistment->addAttribute("pWithDisability", "X");
    $enlistment->addAttribute("pDependentType", "X");
    $enlistment->addAttribute("pTransDate", $genResultEnlist['TRANS_DATE']);
    $enlistment->addAttribute("pCreatedBy", strtoupper($genResultEnlist['CREATED_BY']));
    $enlistment->addAttribute("pReportStatus", "U");
    $enlistment->addAttribute("pDeficiencyRemarks", "");
    $enlistment->addAttribute("pAvailFreeService", "X");

    /*PROFILING XML GENERATION*/
    $profiling = $epcb->addChild("PROFILING");
    $profile = $profiling->addChild("PROFILE");
    $profile->addAttribute("pHciTransNo", $genResultProfiling['TRANS_NO']);
    $profile->addAttribute("pHciCaseNo", $genResultProfiling['CASE_NO']);
    $profile->addAttribute("pPatientPin", $genResultProfiling['PX_PIN']);
    $profile->addAttribute("pPatientType", "");
    $profile->addAttribute("pMemPin", $genResultProfiling['MEM_PIN']);
    $profile->addAttribute("pProfDate", $genResultProfiling['PROF_DATE']);
    $profile->addAttribute("pRemarks", "");
    $profile->addAttribute("pEffYear", $genResultProfiling['EFF_YEAR']);
    $profile->addAttribute("pProfileATC", $genResultProfiling['PROFILE_OTP']);
    $profile->addAttribute("pReportStatus", $genResultProfiling['REPORT_STATUS']);
    $profile->addAttribute("pDeficiencyRemarks", $genResultProfiling['DEFICIENCY_REMARKS']);

    $oinfo = $profile->addChild("OINFO");
    $oinfo->addAttribute("pPatientPob", "");
    $oinfo->addAttribute("pPatientAge", $genResultProfiling['PX_AGE']);
    $oinfo->addAttribute("pPatientOccupation", "");
    $oinfo->addAttribute("pPatientEducation", "");
    $oinfo->addAttribute("pPatientReligion", "");
    $oinfo->addAttribute("pPatientMotherMnln", "");
    $oinfo->addAttribute("pPatientMotherMnmi", "");
    $oinfo->addAttribute("pPatientMotherFn", "");
    $oinfo->addAttribute("pPatientMotherExtn", "");
    $oinfo->addAttribute("pPatientMotherBday", "");
    $oinfo->addAttribute("pPatientFatherLn", "");
    $oinfo->addAttribute("pPatientFatherMi", "");
    $oinfo->addAttribute("pPatientFatherFn", "");
    $oinfo->addAttribute("pPatientFatherExtn", "");
    $oinfo->addAttribute("pPatientFatherBday", "");
    $oinfo->addAttribute("pReportStatus", "U");
    $oinfo->addAttribute("pDeficiencyRemarks", "");

    if ($genProfilingMedHist == NULL) {
        $medhist = $profile->addChild("MEDHIST");
        $medhist->addAttribute("pMdiseaseCode", "");
        $medhist->addAttribute("pReportStatus", "U");
        $medhist->addAttribute("pDeficiencyRemarks", "");
    } else {
        foreach ($genProfilingMedHist as $genProfilingMedHists) {
            if ($genResultProfiling['TRANS_NO'] == $genProfilingMedHists['TRANS_NO']) {
                $medhist = $profile->addChild("MEDHIST");
                $medhist->addAttribute("pMdiseaseCode", $genProfilingMedHists['MDISEASE_CODE']);
                $medhist->addAttribute("pReportStatus", "U");
                $medhist->addAttribute("pDeficiencyRemarks", "");
            }
        }
    }

    if ($genProfilingMHspecific == NULL) {
        $mhspecific = $profile->addChild("MHSPECIFIC");
        $mhspecific->addAttribute("pMdiseaseCode", "");
        $mhspecific->addAttribute("pSpecificDesc", "");
        $mhspecific->addAttribute("pReportStatus", "U");
        $mhspecific->addAttribute("pDeficiencyRemarks", "");
    } else {
        foreach ($genProfilingMHspecific as $genProfilingMHspecifics) {
            if ($genResultProfiling['TRANS_NO'] == $genProfilingMHspecifics['TRANS_NO']) {
                $mhspecific = $profile->addChild("MHSPECIFIC");
                $mhspecific->addAttribute("pMdiseaseCode", $genProfilingMHspecifics['MDISEASE_CODE']);
                $mhspecific->addAttribute("pSpecificDesc", $genProfilingMHspecifics['SPECIFIC_DESC']);
                $mhspecific->addAttribute("pReportStatus", "U");
                $mhspecific->addAttribute("pDeficiencyRemarks", "");
            }
        }
    }

    $surghist = $profile->addChild("SURGHIST");
    $surghist->addAttribute("pSurgDesc", "");
    $surghist->addAttribute("pSurgDate", "");
    $surghist->addAttribute("pReportStatus", "U");
    $surghist->addAttribute("pDeficiencyRemarks", "");

    $famhist = $profile->addChild("FAMHIST");
    $famhist->addAttribute("pMdiseaseCode", "");
    $famhist->addAttribute("pReportStatus", "U");
    $famhist->addAttribute("pDeficiencyRemarks", "");

    $fhspecific = $profile->addChild("FHSPECIFIC");
    $fhspecific->addAttribute("pMdiseaseCode", "");
    $fhspecific->addAttribute("pSpecificDesc", "");
    $fhspecific->addAttribute("pReportStatus", "U");
    $fhspecific->addAttribute("pDeficiencyRemarks", "");

    $sochist = $profile->addChild("SOCHIST");
    $sochist->addAttribute("pIsSmoker", "");
    $sochist->addAttribute("pNoCigpk", "");
    $sochist->addAttribute("pIsAdrinker", "");
    $sochist->addAttribute("pNoBottles", "");
    $sochist->addAttribute("pIllDrugUser", "");
    $sochist->addAttribute("pReportStatus", "U");
    $sochist->addAttribute("pDeficiencyRemarks", "");

    $immunization = $profile->addChild("IMMUNIZATION");
    $immunization->addAttribute("pChildImmcode", "");
    $immunization->addAttribute("pYoungwImmcode", "");
    $immunization->addAttribute("pPregwImmcode", "");
    $immunization->addAttribute("pElderlyImmcode", "");
    $immunization->addAttribute("pOtherImm", "");
    $immunization->addAttribute("pReportStatus", "U");
    $immunization->addAttribute("pDeficiencyRemarks", "");

    $menshist = $profile->addChild("MENSHIST");
    $menshist->addAttribute("pMenarchePeriod", "");
    $menshist->addAttribute("pLastMensPeriod", $genResultProfiling['LAST_MENS_PERIOD']);
    $menshist->addAttribute("pPeriodDuration", "");
    $menshist->addAttribute("pMensInterval", "");
    $menshist->addAttribute("pPadsPerDay", "");
    $menshist->addAttribute("pOnsetSexIc", "");
    $menshist->addAttribute("pBirthCtrlMethod", "");
    $menshist->addAttribute("pIsMenopause", "");
    $menshist->addAttribute("pMenopauseAge", "");
    $menshist->addAttribute("pIsApplicable", $genResultProfiling['IS_APPLICABLE']);
    $menshist->addAttribute("pReportStatus", "U");
    $menshist->addAttribute("pDeficiencyRemarks", "");

    $preghist = $profile->addChild("PREGHIST");
    $preghist->addAttribute("pPregCnt", $genResultProfiling['PREG_CNT']);
    $preghist->addAttribute("pDeliveryCnt", $genResultProfiling['DELIVERY_CNT']);
    $preghist->addAttribute("pDeliveryTyp", "");
    $preghist->addAttribute("pFullTermCnt", $genResultProfiling['FULL_TERM_CNT']);
    $preghist->addAttribute("pPrematureCnt", $genResultProfiling['PREMATURE_CNT']);
    $preghist->addAttribute("pAbortionCnt", $genResultProfiling['ABORTION_CNT']);
    $preghist->addAttribute("pLivChildrenCnt", $genResultProfiling['LIV_CHILDREN_CNT']);
    $preghist->addAttribute("pWPregIndhyp", "");
    $preghist->addAttribute("pWFamPlan", "");
    $preghist->addAttribute("pReportStatus", "U");
    $preghist->addAttribute("pDeficiencyRemarks", "");

    $pepert = $profile->addChild("PEPERT");
    $pepert->addAttribute("pSystolic", $genResultProfiling['SYSTOLIC']);
    $pepert->addAttribute("pDiastolic", $genResultProfiling['DIASTOLIC']);
    $pepert->addAttribute("pHr", $genResultProfiling['HR']);
    $pepert->addAttribute("pRr", $genResultProfiling['RR']);
    $pepert->addAttribute("pTemp", $genResultProfiling['TEMPERATURE']);
    $pepert->addAttribute("pHeight", "");
    $pepert->addAttribute("pWeight", "");
    $pepert->addAttribute("pVision", "");
    $pepert->addAttribute("pLength", "");
    $pepert->addAttribute("pHeadCirc", "");
    $pepert->addAttribute("pReportStatus", "U");
    $pepert->addAttribute("pDeficiencyRemarks", "");

    $bloodtype = $profile->addChild("BLOODTYPE");
    $bloodtype->addAttribute("pBloodType", "");
    $bloodtype->addAttribute("pBloodRh", "");
    $bloodtype->addAttribute("pReportStatus", "U");
    $bloodtype->addAttribute("pDeficiencyRemarks", "");

    $peadmin = $profile->addChild("PEGENSURVEY");
    $peadmin->addAttribute("pGenSurveyId", $genResultProfiling['GENSURVEY_ID']);
    $peadmin->addAttribute("pGenSurveyRem", $genResultProfiling['GENSURVEY_REM']);
    $peadmin->addAttribute("pReportStatus", "U");
    $peadmin->addAttribute("pDeficiencyRemarks", "");

    if ($genProfilingPemisc == NULL) {
        $pemisc = $profile->addChild("PEMISC");
        $pemisc->addAttribute("pSkinId", "");
        $pemisc->addAttribute("pHeentId", "");
        $pemisc->addAttribute("pChestId", "");
        $pemisc->addAttribute("pHeartId", "");
        $pemisc->addAttribute("pAbdomenId", "");
        $pemisc->addAttribute("pNeuroId", "");
        $pemisc->addAttribute("pRectalId", "");
        $pemisc->addAttribute("pGuId", "");
        $pemisc->addAttribute("pReportStatus", "U");
        $pemisc->addAttribute("pDeficiencyRemarks", "");
    } else {
        foreach ($genProfilingPemisc as $genProfilingPemiscs) {
            if ($genResultProfiling['TRANS_NO'] == $genProfilingPemiscs['TRANS_NO']) {
                $pemisc = $profile->addChild("PEMISC");
                $pemisc->addAttribute("pSkinId", $genProfilingPemiscs['SKIN_ID']);
                $pemisc->addAttribute("pHeentId", $genProfilingPemiscs['HEENT_ID']);
                $pemisc->addAttribute("pChestId", $genProfilingPemiscs['CHEST_ID']);
                $pemisc->addAttribute("pHeartId", $genProfilingPemiscs['HEART_ID']);
                $pemisc->addAttribute("pAbdomenId", $genProfilingPemiscs['ABDOMEN_ID']);
                $pemisc->addAttribute("pNeuroId", $genProfilingPemiscs['NEURO_ID']);
                $pemisc->addAttribute("pRectalId", $genProfilingPemiscs['RECTAL_ID']);
                $pemisc->addAttribute("pGuId", $genProfilingPemiscs['GU_ID']);
                $pemisc->addAttribute("pReportStatus", "U");
                $pemisc->addAttribute("pDeficiencyRemarks", "");
            }
        }
    }

    $pespecific = $profile->addChild("PESPECIFIC");
    $pespecific->addAttribute("pSkinRem", $genResultProfiling['SKIN_REM']);
    $pespecific->addAttribute("pHeentRem", $genResultProfiling['HEENT_REM']);
    $pespecific->addAttribute("pChestRem", $genResultProfiling['CHEST_REM']);
    $pespecific->addAttribute("pHeartRem", $genResultProfiling['HEART_REM']);
    $pespecific->addAttribute("pAbdomenRem", $genResultProfiling['ABDOMEN_REM']);
    $pespecific->addAttribute("pNeuroRem", $genResultProfiling['NEURO_REM']);
    $pespecific->addAttribute("pRectalRem", $genResultProfiling['RECTAL_REM']);
    $pespecific->addAttribute("pGuRem", $genResultProfiling['GU_REM']);
    $pespecific->addAttribute("pReportStatus", "U");
    $pespecific->addAttribute("pDeficiencyRemarks", "");

    $diagnostic = $profile->addChild("DIAGNOSTIC");
    $diagnostic->addAttribute("pDiagnosticId", "0");
    $diagnostic->addAttribute("pOthRemarks", "");
    $diagnostic->addAttribute("pReportStatus", "U");
    $diagnostic->addAttribute("pDeficiencyRemarks", "");

    $management = $profile->addChild("MANAGEMENT");
    $management->addAttribute("pManagementId", "0");
    $management->addAttribute("pOthRemarks", "");
    $management->addAttribute("pReportStatus", "U");
    $management->addAttribute("pDeficiencyRemarks", "");


    $advice = $profile->addChild("ADVICE");
    $advice->addAttribute("pRemarks", "NA");
    $advice->addAttribute("pReportStatus", "U");
    $advice->addAttribute("pDeficiencyRemarks", "");

    $ncdqans = $profile->addChild("NCDQANS");
    $ncdqans->addAttribute("pQid1_Yn", "");
    $ncdqans->addAttribute("pQid2_Yn", "");
    $ncdqans->addAttribute("pQid3_Yn", "");
    $ncdqans->addAttribute("pQid4_Yn", "");
    $ncdqans->addAttribute("pQid5_Ynx", "");
    $ncdqans->addAttribute("pQid6_Yn", "");
    $ncdqans->addAttribute("pQid7_Yn", "");
    $ncdqans->addAttribute("pQid8_Yn", "");
    $ncdqans->addAttribute("pQid9_Yn", "");
    $ncdqans->addAttribute("pQid10_Yn", "");
    $ncdqans->addAttribute("pQid11_Yn", "");
    $ncdqans->addAttribute("pQid12_Yn", "");
    $ncdqans->addAttribute("pQid13_Yn", "");
    $ncdqans->addAttribute("pQid14_Yn", "");
    $ncdqans->addAttribute("pQid15_Yn", "");
    $ncdqans->addAttribute("pQid16_Yn", "");
    $ncdqans->addAttribute("pQid17_Abcde", "");
    $ncdqans->addAttribute("pQid18_Yn", "");
    $ncdqans->addAttribute("pQid19_Yn", "");
    $ncdqans->addAttribute("pQid19_Fbsmg", "");
    $ncdqans->addAttribute("pQid19_Fbsmmol", "");
    $ncdqans->addAttribute("pQid19_Fbsdate", "");
    $ncdqans->addAttribute("pQid20_Yn", "");
    $ncdqans->addAttribute("pQid20_Choleval", "");
    $ncdqans->addAttribute("pQid20_Choledate", "");
    $ncdqans->addAttribute("pQid21_Yn", "");
    $ncdqans->addAttribute("pQid21_Ketonval", "");
    $ncdqans->addAttribute("pQid21_Ketondate", "");
    $ncdqans->addAttribute("pQid22_Yn", "");
    $ncdqans->addAttribute("pQid22_Proteinval", "");
    $ncdqans->addAttribute("pQid22_Proteindate", "");
    $ncdqans->addAttribute("pQid23_Yn", "");
    $ncdqans->addAttribute("pQid24_Yn", "");
    $ncdqans->addAttribute("pReportStatus", "U");
    $ncdqans->addAttribute("pDeficiencyRemarks", "");


    /*CONSULTATION XML GENERATION*/
    $consultations = $epcb->addChild("SOAPS");
    $consultation = $consultations->addChild("SOAP");
    $consultation->addAttribute("pHciCaseNo", $genResultConsultation['CASE_NO']);
    $consultation->addAttribute("pHciTransNo", $genResultConsultation['TRANS_NO']);
    $consultation->addAttribute("pPatientPin", $genResultConsultation['PX_PIN']);
    $consultation->addAttribute("pPatientType", $genResultConsultation['PX_TYPE']);
    $consultation->addAttribute("pMemPin", $genResultConsultation['MEM_PIN']);
    $consultation->addAttribute("pSoapDate", $genResultConsultation['SOAP_DATE']);
    $consultation->addAttribute("pEffYear", $genResultConsultation['EFF_YEAR']);
    $consultation->addAttribute("pSoapATC", $genResultConsultation['SOAP_OTP']);
    $consultation->addAttribute("pReportStatus", "U");
    $consultation->addAttribute("pDeficiencyRemarks", "");

    $subjective = $consultation->addChild("SUBJECTIVE");
    $subjective->addAttribute("pChiefComplaint", $genResultConsultation['CHIEF_COMPLAINT']);
    $subjective->addAttribute("pIllnessHistory", $genResultConsultation['ILLNESS_HISTORY']);
    $subjective->addAttribute("pOtherComplaint", $genResultConsultation['OTHER_COMPLAINT']);
    $subjective->addAttribute("pSignsSymptoms", $genResultConsultation['SIGNS_SYMPTOMS']);
    $subjective->addAttribute("pPainSite", $genResultConsultation['PAIN_SITE']);
    $subjective->addAttribute("pReportStatus", "U");
    $subjective->addAttribute("pDeficiencyRemarks", "");

    $pepert = $consultation->addChild("PEPERT");
    $pepert->addAttribute("pSystolic", "");
    $pepert->addAttribute("pDiastolic", "");
    $pepert->addAttribute("pHr", "");
    $pepert->addAttribute("pRr", "");
    $pepert->addAttribute("pHeight", "");
    $pepert->addAttribute("pWeight", "");
    $pepert->addAttribute("pTemp", "");
    $pepert->addAttribute("pVision", "");
    $pepert->addAttribute("pLength", "");
    $pepert->addAttribute("pHeadCirc", "");
    $pepert->addAttribute("pReportStatus", "U");
    $pepert->addAttribute("pDeficiencyRemarks", "");

    $pemisc = $consultation->addChild("PEMISC");
    $pemisc->addAttribute("pSkinId", "");
    $pemisc->addAttribute("pHeentId", "");
    $pemisc->addAttribute("pChestId", "");
    $pemisc->addAttribute("pHeartId", "");
    $pemisc->addAttribute("pAbdomenId", "");
    $pemisc->addAttribute("pNeuroId", "");
    $pemisc->addAttribute("pGuId", "");
    $pemisc->addAttribute("pRectalId", "");
    $pemisc->addAttribute("pReportStatus", "U");
    $pemisc->addAttribute("pDeficiencyRemarks", "");

    $pespecific = $consultation->addChild("PESPECIFIC");
    $pespecific->addAttribute("pSkinRem", "");
    $pespecific->addAttribute("pHeentRem", "");
    $pespecific->addAttribute("pChestRem", "");
    $pespecific->addAttribute("pHeartRem", "");
    $pespecific->addAttribute("pAbdomenRem", "");
    $pespecific->addAttribute("pNeuroRem", "");
    $pespecific->addAttribute("pRectalRem", "");
    $pespecific->addAttribute("pGuRem", "");
    $pespecific->addAttribute("pReportStatus", "U");
    $pespecific->addAttribute("pDeficiencyRemarks", "");

    $icds = $consultation->addChild("ICDS");
    $icds->addAttribute("pIcdCode", "000");
    $icds->addAttribute("pReportStatus", "U");
    $icds->addAttribute("pDeficiencyRemarks", "");

    $diagnostic = $consultation->addChild("DIAGNOSTIC");
    $diagnostic->addAttribute("pDiagnosticId", "0");
    $diagnostic->addAttribute("pOthRemarks", "");
    $diagnostic->addAttribute("pReportStatus", "U");
    $diagnostic->addAttribute("pDeficiencyRemarks", "");

    $management = $consultation->addChild("MANAGEMENT");
    $management->addAttribute("pManagementId", "0");
    $management->addAttribute("pOthRemarks", "");
    $management->addAttribute("pReportStatus", "U");
    $management->addAttribute("pDeficiencyRemarks", "");

    $advice = $consultation->addChild("ADVICE");
    $advice->addAttribute("pRemarks", "N/A");
    $advice->addAttribute("pReportStatus", "U");
    $advice->addAttribute("pDeficiencyRemarks", "");

    /*COURSE IN THE WARD XML GENERATION*/
    $courseward = $epcb->addChild("COURSEWARDS");
    if($displayResultCourseWard == NULL) {
        $course = $courseward->addChild("COURSEWARD");
        $course->addAttribute("pHciCaseNo", "");
        $course->addAttribute("pHciTransNo", "");
        $course->addAttribute("pDateAction", "");
        $course->addAttribute("pDoctorsAction", "");
        $course->addAttribute("pReportStatus", "U");
        $course->addAttribute("pDeficiencyRemarks", "");
    } else{
        foreach ($displayResultCourseWard as $displayResultCourseWards) {
            $course = $courseward->addChild("COURSEWARD");
            $course->addAttribute("pHciCaseNo", $displayResultCourseWards['CASE_NO']);
            $course->addAttribute("pHciTransNo", $displayResultCourseWards['TRANS_NO']);
            $course->addAttribute("pDateAction", $displayResultCourseWards['ACTION_DATE']);
            $course->addAttribute("pDoctorsAction", $displayResultCourseWards['DOCTORS_ACTION']);
            $course->addAttribute("pReportStatus", "U");
            $course->addAttribute("pDeficiencyRemarks", "");
        }
    }

    /*LABORATORY RESULTS XML GENERATION*/
    $labresults = $epcb->addChild("LABRESULTS");
        $labresult = $labresults->addChild("LABRESULT");
        $labresult->addAttribute("pHciCaseNo", "");
        $labresult->addAttribute("pPatientPin", "");
        $labresult->addAttribute("pPatientType", "");
        $labresult->addAttribute("pMemPin", "");
        $labresult->addAttribute("pEffYear", "");

            $cbc = $labresult->addChild("CBC");
            $cbc->addAttribute("pHciTransNo", "");
            $cbc->addAttribute("pReferralFacility", "");
            $cbc->addAttribute("pLabDate", "");
            $cbc->addAttribute("pHematocrit", "");
            $cbc->addAttribute("pHemoglobinG", "");
            $cbc->addAttribute("pHemoglobinMmol", "");
            $cbc->addAttribute("pMhcPg", "");
            $cbc->addAttribute("pMhcFmol", "");
            $cbc->addAttribute("pMchcGhb", "");
            $cbc->addAttribute("pMchcMmol", "");
            $cbc->addAttribute("pMcvUm", "");
            $cbc->addAttribute("pMcvFl", "");
            $cbc->addAttribute("pWbc1000", "");
            $cbc->addAttribute("pWbc10", "");
            $cbc->addAttribute("pMyelocyte", "");
            $cbc->addAttribute("pNeutrophilsBnd", "");
            $cbc->addAttribute("pNeutrophilsSeg", "");
            $cbc->addAttribute("pLymphocytes", "");
            $cbc->addAttribute("pMonocytes", "");
            $cbc->addAttribute("pEosinophils", "");
            $cbc->addAttribute("pBasophils", "");
            $cbc->addAttribute("pPlatelet", "");
            $cbc->addAttribute("pDateAdded", "");
            $cbc->addAttribute("pIsApplicable", "N");
            $cbc->addAttribute("pModule", "");
            $cbc->addAttribute("pDiagnosticLabFee", "");
            $cbc->addAttribute("pCoPay", "");
            $cbc->addAttribute("pReportStatus", "U");
            $cbc->addAttribute("pDeficiencyRemarks", "");

            $urinalysis = $labresult->addChild("URINALYSIS");
            $urinalysis->addAttribute("pHciTransNo", "");
            $urinalysis->addAttribute("pReferralFacility", "");
            $urinalysis->addAttribute("pLabDate", "");
            $urinalysis->addAttribute("pGravity", "");
            $urinalysis->addAttribute("pAppearance", "");
            $urinalysis->addAttribute("pColor", "");
            $urinalysis->addAttribute("pGlucose", "");
            $urinalysis->addAttribute("pProteins", "");
            $urinalysis->addAttribute("pKetones", "");
            $urinalysis->addAttribute("pPh", "");
            $urinalysis->addAttribute("pRbCells", "");
            $urinalysis->addAttribute("pWbCells", "");
            $urinalysis->addAttribute("pBacteria", "");
            $urinalysis->addAttribute("pCrystals", "");
            $urinalysis->addAttribute("pBladderCell", "");
            $urinalysis->addAttribute("pSquamousCell", "");
            $urinalysis->addAttribute("pTubularCell", "");
            $urinalysis->addAttribute("pBroadCasts", "");
            $urinalysis->addAttribute("pEpithelialCast", "");
            $urinalysis->addAttribute("pGranularCast", "");
            $urinalysis->addAttribute("pHyalineCast", "");
            $urinalysis->addAttribute("pRbcCast", "");
            $urinalysis->addAttribute("pWaxyCast", "");
            $urinalysis->addAttribute("pWcCast", "");
            $urinalysis->addAttribute("pAlbumin", "");
            $urinalysis->addAttribute("pPusCells", "");
            $urinalysis->addAttribute("pDateAdded", "");
            $urinalysis->addAttribute("pIsApplicable", "N");
            $urinalysis->addAttribute("pModule", "");
            $urinalysis->addAttribute("pDiagnosticLabFee", "");
            $urinalysis->addAttribute("pCoPay", "");
            $urinalysis->addAttribute("pReportStatus", "U");
            $urinalysis->addAttribute("pDeficiencyRemarks", "");

            $chestxray = $labresult->addChild("CHESTXRAY");
            $chestxray->addAttribute("pHciTransNo", "");
            $chestxray->addAttribute("pReferralFacility", "");
            $chestxray->addAttribute("pLabDate", "");
            $chestxray->addAttribute("pFindings", "");
            $chestxray->addAttribute("pRemarksFindings", "");
            $chestxray->addAttribute("pObservation", "");
            $chestxray->addAttribute("pRemarksObservation", "");
            $chestxray->addAttribute("pDateAdded", "");
            $chestxray->addAttribute("pIsApplicable", "N");
            $chestxray->addAttribute("pModule", "");
            $chestxray->addAttribute("pDiagnosticLabFee", "");
            $chestxray->addAttribute("pCoPay", "");
            $chestxray->addAttribute("pReportStatus", "U");
            $chestxray->addAttribute("pDeficiencyRemarks", "");

            $sputum = $labresult->addChild("SPUTUM");
            $sputum->addAttribute("pHciTransNo", "");
            $sputum->addAttribute("pReferralFacility", "");
            $sputum->addAttribute("pLabDate", "");
            $sputum->addAttribute("pDataCollection", "X");
            $sputum->addAttribute("pFindings", "");
            $sputum->addAttribute("pRemarks", "");
            $sputum->addAttribute("pNoPlusses", "");
            $sputum->addAttribute("pDateAdded", "");
            $sputum->addAttribute("pIsApplicable", "N");
            $sputum->addAttribute("pModule", "");
            $sputum->addAttribute("pDiagnosticLabFee", "");
            $sputum->addAttribute("pCoPay", "");
            $sputum->addAttribute("pReportStatus", "U");
            $sputum->addAttribute("pDeficiencyRemarks", "");

            $lipidprof = $labresult->addChild("LIPIDPROF");
            $lipidprof->addAttribute("pHciTransNo", "");
            $lipidprof->addAttribute("pReferralFacility", "");
            $lipidprof->addAttribute("pLabDate", "");
            $lipidprof->addAttribute("pLdl", "");
            $lipidprof->addAttribute("pHdl", "");
            $lipidprof->addAttribute("pTotal", "");
            $lipidprof->addAttribute("pCholesterol", "");
            $lipidprof->addAttribute("pTriglycerides", "");
            $lipidprof->addAttribute("pDateAdded", "");
            $lipidprof->addAttribute("pIsApplicable", "N");
            $lipidprof->addAttribute("pModule", "");
            $lipidprof->addAttribute("pDiagnosticLabFee", "");
            $lipidprof->addAttribute("pCoPay", "");
            $lipidprof->addAttribute("pReportStatus", "U");
            $lipidprof->addAttribute("pDeficiencyRemarks", "");

            $fbs = $labresult->addChild("FBS");
            $fbs->addAttribute("pHciTransNo", "");
            $fbs->addAttribute("pReferralFacility", "");
            $fbs->addAttribute("pLabDate", "");
            $fbs->addAttribute("pGlucoseMg", "");
            $fbs->addAttribute("pGlucoseMmol", "");
            $fbs->addAttribute("pDateAdded", "");
            $fbs->addAttribute("pIsApplicable", "N");
            $fbs->addAttribute("pModule", "");
            $fbs->addAttribute("pDiagnosticLabFee", "");
            $fbs->addAttribute("pCoPay", "");
            $fbs->addAttribute("pReportStatus", "U");
            $fbs->addAttribute("pDeficiencyRemarks", "");

            $ecg = $labresult->addChild("ECG");
            $ecg->addAttribute("pHciTransNo", "");
            $ecg->addAttribute("pReferralFacility", "");
            $ecg->addAttribute("pLabDate", "");
            $ecg->addAttribute("pFindings", "");
            $ecg->addAttribute("pRemarks", "");
            $ecg->addAttribute("pDateAdded", "");
            $ecg->addAttribute("pIsApplicable", "N");
            $ecg->addAttribute("pModule", "");
            $ecg->addAttribute("pDiagnosticLabFee", "");
            $ecg->addAttribute("pCoPay", "");
            $ecg->addAttribute("pReportStatus", "U");
            $ecg->addAttribute("pDeficiencyRemarks", "");

            $fecalysis = $labresult->addChild("FECALYSIS");
            $fecalysis->addAttribute("pHciTransNo", "");
            $fecalysis->addAttribute("pReferralFacility", "");
            $fecalysis->addAttribute("pLabDate", "");
            $fecalysis->addAttribute("pColor", "");
            $fecalysis->addAttribute("pConsistency", "");
            $fecalysis->addAttribute("pRbc", "");
            $fecalysis->addAttribute("pWbc", "");
            $fecalysis->addAttribute("pOva", "");
            $fecalysis->addAttribute("pParasite", "");
            $fecalysis->addAttribute("pBlood", "");
            $fecalysis->addAttribute("pOccultBlood", "");
            $fecalysis->addAttribute("pPusCells", "");
            $fecalysis->addAttribute("pDateAdded", "");
            $fecalysis->addAttribute("pIsApplicable", "N");
            $fecalysis->addAttribute("pModule", "");
            $fecalysis->addAttribute("pDiagnosticLabFee", "");
            $fecalysis->addAttribute("pCoPay", "");
            $fecalysis->addAttribute("pReportStatus", "U");
            $fecalysis->addAttribute("pDeficiencyRemarks", "");

            $paps = $labresult->addChild("PAPSSMEAR");
            $paps->addAttribute("pHciTransNo", "");
            $paps->addAttribute("pReferralFacility", "");
            $paps->addAttribute("pLabDate", "");
            $paps->addAttribute("pFindings", "");
            $paps->addAttribute("pImpression", "");
            $paps->addAttribute("pDateAdded", "");
            $paps->addAttribute("pIsApplicable", "N");
            $paps->addAttribute("pModule", "");
            $paps->addAttribute("pDiagnosticLabFee", "");
            $paps->addAttribute("pCoPay", "");
            $paps->addAttribute("pReportStatus", "U");
            $paps->addAttribute("pDeficiencyRemarks", "");

            $ogtt = $labresult->addChild("OGTT");
            $ogtt->addAttribute("pHciTransNo", "");
            $ogtt->addAttribute("pReferralFacility", "");
            $ogtt->addAttribute("pLabDate", "");
            $ogtt->addAttribute("pExamFastingMg", "");
            $ogtt->addAttribute("pExamFastingMmol", "");
            $ogtt->addAttribute("pExamOgttOneHrMg", "");
            $ogtt->addAttribute("pExamOgttOneHrMmol", "");
            $ogtt->addAttribute("pExamOgttTwoHrMg", "");
            $ogtt->addAttribute("pExamOgttTwoHrMmol", "");
            $ogtt->addAttribute("pDateAdded", "");
            $ogtt->addAttribute("pIsApplicable", "N");
            $ogtt->addAttribute("pModule", "");
            $ogtt->addAttribute("pDiagnosticLabFee", "");
            $ogtt->addAttribute("pCoPay", "");
            $ogtt->addAttribute("pReportStatus", "U");
            $ogtt->addAttribute("pDeficiencyRemarks", "");

    /*MEDICINE XML GENERATION*/
    $medicines = $epcb->addChild("MEDICINES");

    if ($genResultMedicine == NULL) {
        $meds = $medicines->addChild("MEDICINE");
        $meds->addAttribute("pHciCaseNo", "");
        $meds->addAttribute("pHciTransNo", "");
        $meds->addAttribute("pDrugCode", "");
        $meds->addAttribute("pGenericName", "");
        $meds->addAttribute("pGenericCode", "");
        $meds->addAttribute("pSaltCode", "");
        $meds->addAttribute("pStrengthCode", "");
        $meds->addAttribute("pFormCode", "");
        $meds->addAttribute("pUnitCode", "");
        $meds->addAttribute("pPackageCode", "");
        $meds->addAttribute("pRoute", "");
        $meds->addAttribute("pQuantity", "");
        $meds->addAttribute("pActualUnitPrice", "");
        $meds->addAttribute("pCoPayment", "");
        $meds->addAttribute("pTotalAmtPrice", "");
        $meds->addAttribute("pInstructionQuantity", "");
        $meds->addAttribute("pInstructionStrength", "");
        $meds->addAttribute("pInstructionFrequency", "");
        $meds->addAttribute("pPrescPhysician", "NA");
        $meds->addAttribute("pIsApplicable", "N");
        $meds->addAttribute("pDateAdded", "");
        $meds->addAttribute("pModule", "");
        $meds->addAttribute("pReportStatus", "U");
        $meds->addAttribute("pDeficiencyRemarks", "");
    } else{
        foreach ($genResultMedicine as $genResultMedicines) {
            $meds = $medicines->addChild("MEDICINE");
            $meds->addAttribute("pHciCaseNo", $genResultMedicines['CASE_NO']);
            $meds->addAttribute("pHciTransNo", $genResultMedicines['TRANS_NO']);
            $meds->addAttribute("pDrugCode", $genResultMedicines['DRUG_CODE']);
            $meds->addAttribute("pGenericName", $genResultMedicines['GENERIC_NAME']);
            $meds->addAttribute("pGenericCode", $genResultMedicines['GEN_CODE']);
            $meds->addAttribute("pSaltCode", $genResultMedicines['SALT_CODE']);
            $meds->addAttribute("pStrengthCode", $genResultMedicines['STRENGTH_CODE']);
            $meds->addAttribute("pFormCode", $genResultMedicines['FORM_CODE']);
            $meds->addAttribute("pUnitCode", $genResultMedicines['UNIT_CODE']);
            $meds->addAttribute("pPackageCode", $genResultMedicines['PACKAGE_CODE']);
            $meds->addAttribute("pRoute", $genResultMedicines['ROUTE']);
            $meds->addAttribute("pQuantity", $genResultMedicines['QUANTITY']);
            $meds->addAttribute("pActualUnitPrice", $genResultMedicines['DRUG_ACTUAL_PRICE']);
            $meds->addAttribute("pCoPayment", $genResultMedicines['CO_PAYMENT']);
            $meds->addAttribute("pTotalAmtPrice", $genResultMedicines['AMT_PRICE']);
            $meds->addAttribute("pInstructionQuantity", $genResultMedicines['INS_QUANTITY']);
            $meds->addAttribute("pInstructionStrength", $genResultMedicines['INS_STRENGTH']);
            $meds->addAttribute("pInstructionFrequency", $genResultMedicines['INS_FREQUENCY']);
            $meds->addAttribute("pPrescPhysician", $genResultMedicines['PRESC_PHYSICIAN']);
            $meds->addAttribute("pIsApplicable", $genResultMedicines['IS_APPLICABLE']);
            $meds->addAttribute("pDateAdded", $genResultMedicines['DATE_ADDED']);
            $meds->addAttribute("pModule", $genResultMedicines['XPS_MODULE']);
            $meds->addAttribute("pReportStatus", "U");
            $meds->addAttribute("pDeficiencyRemarks", "");
        }
    }

    $dom = dom_import_simplexml($epcb)->ownerDocument;
    $dom ->formatOutput = true;

    $xml = $dom->saveXML();
    $xmlString = str_replace("<?xml version=\"1.0\"?>\n", '', $xml);
    file_put_contents("tmp/genCf4XmlReport.xml", $xmlString);
    insertGeneratedXMLreport($xmlString, $pReportTransNo, $pDateRange);
    return $xmlString;
}


?>


