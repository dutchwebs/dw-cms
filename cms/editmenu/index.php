<!DOCTYPE html>
<html lang="en">
<head>

    <?php include("../../includes/db.php") ?>
    <?php include("../../includes/main-class.php") ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="stylesheet" href="http://server.dutchwebs.com/cms/editmenu/nestable.css">
    <link href="https://server.dutchwebs.com/cms/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <?php $menu = new Menu($db, 1) ?>

    <title>Bewerk <?= $menu->getMenuName() ?></title>

    <style>
        .nestableTable, .nestableTable tr {
            position: relative;
            width: 100%;
        }
        .nestableTable th {
            text-align: left;
        }
        .nestableTable td {
            position: relative;
            width: 40%;
            vertical-align: top;
            padding: 10px 0px 10px 10px;
        }
        .nestableTable td:first-child {
            position: relative;
            width: 60%;
            vertical-align: top;
            padding: 10px 10px 10px 0px;
        }
    </style>

</head>
<body>
    <div class="popupbox-inner">
        <table class="nestableTable">
            <tr>
                <th><?= $menu->getMenuName() ?></th>
                <th>Beschikbaar</th>
            </tr>
            <tr>
                <td>
                    <div class="dd" id="main-menu">

                        <?php
                            $allMenuItems = $menu->getMenuForNestable();

                            if(empty($allMenuItems)) {
                                echo '<ol class="dd-empty"></ol>';
                            }else {
                                echo '<ol class="dd-list">' . $allMenuItems . '</ol>';
                            }
                        ?>
                    </div>
                </td>
                <td>
                    <div class="dd" id="available-items">

                        <?php
                            $allAvailableItems = $menu->getMenuForNestableAllAvailable();

                            if(empty($allAvailableItems)) {
                                echo '<ol class="dd-empty"></ol>';
                            }else {
                                echo '<ol class="dd-list">' . $allAvailableItems . '</ol>';
                            }
                        ?>
                    </div>
                </td>
            </tr>
        </table>

        <div class="operation-buttons" style="width:100%;position:fixed;bottom:0px;left;0px;padding:20px;">
            <div id="resultDiv"></div>
        </div>
    </div>
<script src="http://server.dutchwebs.com/cms/js/jquery.js"></script>
<script src="http://server.dutchwebs.com/cms/editmenu/jquery.nestable.js"></script>
<script>

$(document).ready(function()
{

    var updateOutput = function(e)
    {
        var list = e.length ? e : $(e.target), output = list.data('output');
        var JSONlist = window.JSON.stringify(list.nestable('serialize'));

        $("#resultDiv").html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');

        $.ajax({
            method: "POST",
            url: "../includes/ajax/UpdateMenuOrder.php",
            data: { JSONlist: JSONlist, MenuId: 1 }
        }).done(function( data ) {

            var result = $.parseJSON(data);

            if(result.status == "done") {
                setTimeout(function(){
                    $("#resultDiv").html('<i class="fa fa-check fa-3x" aria-hidden="true"></i>');
                }, 500);
            }

        });

    };

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target), action = target.data('action');

        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('#main-menu').nestable().on('change', updateOutput);
    $('#available-items').nestable();

});
</script>
</body>
</html>
