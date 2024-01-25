<?php
    require("function.php");
    $zipCode = getZipCode($_GET["pMunCode"], $_GET["pProvCode"]);
?>
<?php
//    foreach($zipCode as $zipcode) {
//        ?>
<!--        <option value="--><?php //echo $zipcode["ZIP_CODE"]; ?><!--">--><?php //echo $zipcode["ZIP_CODE"]; ?><!--</option>-->
<!--        --><?php
//    }
//?>
<?php
    foreach($zipCode as $zipcode){
        echo $zipcode["ZIP_CODE"];
    }
?>
<script type="text/javascript" language="javascript">
    $(function() {
        $('#pPatientZIPCode').val('<?php echo $zipcode["ZIP_CODE"]; ?>');
    });

    $(function() {
        $('#pHospZIPCode').val('<?php echo $zipcode["ZIP_CODE"]; ?>');
    });
</script>
