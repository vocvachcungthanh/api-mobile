<h1 class="dash-title">Trang chủ / Tài khoản</h1>
<div class="row">
    <div class="col-lg-12">
        <?= view('messages/message'); ?>
        <div class="card easion-card">
            <div class="card-header">
                <div class="easion-card-icon">
                    <i class="fas fa-table"></i>
                </div>
                <div class="easion-card-title">Danh sách tài khoản</div>
            </div>

            <div class="card-body ">
                <table id="datatable" class="cell-border">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach($users as $user) : ?>
                        <tr>
                            <td><?= $user['user_id']; ?> </td>
                            <td>
                                <?= $user['name'];?>
                            </td>
                            <td>
                                <?= $user['email'];?>
                            </td>

                            <td class="text-center">
                                <a href="admin/user/edit/<?=$user['user_id'];?>" class="btn btn-primary"><i
                                        class="fas fa-edit"></i></a>
                                <a data-url="<?= base_url(); ?>admin/user/delete/<?=$user['user_id'];?>"
                                    class="btn btn-danger btn-del-confirm">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>