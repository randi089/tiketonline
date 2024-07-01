<?php
    require('views/essentials.php');
    require('views/db_config.php');
    adminLogin();

    if(isset($_GET['seen']))
    {
        $frm_data = filteration($_GET);
        
        if($frm_data['seen']=='all'){
        $q = "UPDATE `user_queries` SET `seen`=?";
        $values = [1];
        if(update($q,$values,'i')){
                alert('success','Telah Dibaca!');
            }
            else{
                alert('error','Gagal Terbaca!');
            }
        }
        else{
            $q = "UPDATE `user_queries` SET `seen`=? WHERE `no`=?";
            $values = [1,$frm_data['seen']];
            if(update($q,$values,'ii')){
                alert('success','Telah Dibaca!');
            }
            else{
                alert('error','Gagal Terbaca!');
            }
        }
    }

    if(isset($_GET['del']))
    {
        $frm_data = filteration($_GET);
        
        if($frm_data['del']=='all'){
            $q = "DELETE FROM `user_queries`";
            $values = [$frm_data['del']];
            if(update($q,$values,'i')){
                alert('success','Pesan Telah Dihapus!');
            }
            else{
                alert('error','Gagal!');
            }
        }
        else{
            $q = "DELETE `user_queries` WHERE `no`=?";
            $values = [$frm_data['del']];
            if(update($q,$values,'i')){
                alert('success','Pesan Telah Dihapus!');
            }
            else{
                alert('error','Gagal!');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Queries</title>
    <?php require('views/links.php'); ?>
</head>
<body class="bg-light">

    <?php require('views/header.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">User Queries</h3>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">

                <div class="text-end mb-4">
                    <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                        <i class="bi bi-check-all"></i> Tandai Semua Telah Dibaca
                    </a>
                </div>
                <div class="text-end mb-4">
                    <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                    <i class="bi bi-trash"></i> Hapus Semua
                    </a>
                </div>

                    <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                        <table class="table table-hover border">
                            <thead class="sticky-top">
                                <tr class="bg-dark text-light">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Message</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $q = "SELECT * FROM `user_queries` ORDER BY `no` DESC";
                                    $data = mysqli_query($conn,$q);
                                    $i=1;

                                    while($row = mysqli_fetch_assoc($data))
                                    {
                                        $seen='';
                                        if($row['seen']!=1){
                                            $seen = "<a href='?seen=$row[no]' class='btn btn-sm rounded-pill btn-primary'>Mark as Read!</a>";
                                        }
                                        $seen.= "<a href='?del=$row[no]' class='btn btn-sm rounded-pill btn-danger mt-2'>Delete!</a>";

                                        echo<<<query
                                            <tr>
                                                <td>$i</td>
                                                <td>$row[name]</td>
                                                <td>$row[email]</td>
                                                <td>$row[subject]</td>
                                                <td>$row[message]</td>
                                                <td>$row[date]</td>
                                                <td>$seen</td>
                                            </tr>
                                        query;
                                        $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
    
<?php require('views/scripts.php') ?>


</body>
</htm>