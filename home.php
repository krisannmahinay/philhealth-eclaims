<?php
    $page = 'home';
    include('header.php');
    checkLogin();
    include('menu.php');
?>
<div style="margin: 5px;">
    <div class="row">
        <div class="col-sm-7 col-xs-8"><b>HOME</b></div>
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

    <div class="row" align="center">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Version History</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Version</th>
                                    <th style="text-align: left;">Features</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-weight: bold;width:25%;">v.1.0.0</td>
                                    <td>
                                        <ul style="margin-left: 10px;text-align: left">
                                            <li>Enabled CF4 data entry</li>
                                            <li>Enabled Generation of Encrypted CF4 XML</li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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

<?php
    include('footer.php');
?>
