<?php

require_once '../lib/siteConstant.php';
require_once '../lib/Connection.php';
//Update stattus of employee
if ($_POST['action'] == 'updateStatus') {
    $conn = new Connection();

    $dataArr1 = array(
        'status' => '0'
    );
    $result1 = $conn->update('theme', $dataArr1);
    $dataArr = array(
        'status' => $_POST['statusValue'],
        'id' => $_POST['id']
    );
    $result = $conn->update('theme', $dataArr, 'id = :id');
    echo $result;
    exit;
}
if ($_POST['action'] == 'deletedata') {
    $id = $_POST['value'];
    $conn = new Connection();
    $data = array(
        ":id" => array(
            "value" => $id,
            "type" => 'INT'
        ),
    );
    $conn->delete('theme', "id = :id", $data, 'no');
    exit;
}

require_once '../lib/header.php';
require_once '../lib/navbar_admin.php';


$conn = new Connection();
$result = $conn->select('theme', '*');

if (count($result) == 0) {
    $output = "<span class='display-6 text-danger'>Record Not Found!!</span>";
} else {
    $output = '';
    $srno = 1;
    foreach ($result as $value) {
        if ($value['status'] == '1') {
            $status = '<div class="form-check form-switch">
            <input class="form-check-input sts" type="checkbox" data-id="' . $value['id'] . '" role="switch" id="sts' . $value['id'] . '" checked>
          </div>';
        } else {
            $status = '<div class="form-check form-switch">
            <input class="form-check-input sts" type="checkbox" data-id="' . $value['id'] . '" role="switch" id="sts' . $value['id'] . '">
          </div>';
        }
        $action = "<div class='row d-flex flex-nowrap'>
        <div class='col'><a href='addTheme.php?id=" . $value['id'] . "' type='button' id='udp" . $value['id'] . "' class='udp btn btn-success upd'>UPDATE</a></div>
        <div class='col'><button type='button' id='deltheme" . $value['id'] . "' class='deltheme btn btn-danger deltheme'>DELETE</button></div>";

        $output .= "<tr>
                        <td class='text-center'>$srno.</td>
                        <td>" . $value['title'] . "</td>
                        <td>$status</td>
                        <td>$action</td>
                    </tr>";
        $srno++;
    }
}
?>
<div class="col-12 col-md-10 ">
    <div class="container-fluid">
        <main class='position-relative my-3'>
            <div class="row d-flex justify-content-between mb-3">
                <div class="col-12 d-flex justify-content-end">
                    <a class="btn btn-outline-success" href="<?php echo SITE_URL; ?>eCommerce/admin/addTheme.php"
                        role="button">Add Theme</a>
                </div>
                <!-- customer list tabel -->
                <div class="col-sm-12" style="overflow-x:auto;">
                    <table class="col-sm-12 table table-striped table-bordered mt-3">
                        <thead>
                            <tr class="text-center">
                                <th>SR NO.</th>
                                <th>TITLE</th>
                                <th>DEFAULT</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php echo $output; ?>
                        </tbody>
                    </table>
                </div>
        </main>
        <!-- Pagination -->
    </div>
</div>
<script>
    $(document).on('click', '.sts', function () {
        console.log($(this).data('id'))
        if ($(this).is(":checked")) {
            var status = 1;
        } else {
            var status = 0;
        }
        var delay = 2000;
        $.ajax({
            type: "post",
            data: {
                'action': 'updateStatus',
                'statusValue': status,
                'id': $(this).data('id')
            },
            success: function (response) {
                console.log(response);
                if (response == 1) {
                    Swal.fire(
                        'Status Changed Successfully!!',
                        '',
                        'success'
                    )
                    setTimeout(function () {
                        window.location.href = 'theme.php';
                    }, delay);
                }
            }
        });
    });
    //delete Customer data
    $(document).on('click', ".deltheme", function () {
        console.log(this.id.slice(8));
        Swal.fire({
            title: 'Do you want to delete this Theme?',
            showDenyButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
        }).then((result) => {
            var delay = 2000;
            if (result.isConfirmed) {
                Swal.fire('Saved!', '', 'success')
                $.ajax({
                    type: "post",
                    data: {
                        "action": "deletedata",
                        "value": this.id.slice(8)
                    },
                    success: function (response) {
                        setTimeout(function () {
                            window.location.href = 'theme.php';
                        }, delay);
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Theme\'s is not deletd!!', '', 'info')
            }
        })
    });
</script>
<?php
require_once '../lib/footer.php';
?>