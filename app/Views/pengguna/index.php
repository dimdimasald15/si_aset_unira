<?= $this->extend('/layouts/template'); ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="col-12 col-md-12 viewdata shadow-sm-sm" style="display:none;"></div>
    <div class="card shadow mb-3">
        <div class="card-header shadow-sm">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-9">
                    <h4 class="card-title">Data Pengguna</h4>
                </div>
                <div class="col-lg-3 d-flex flex-row-reverse">
                    <button type="button" class="btn btn-success" onclick="util.getForm('add')">
                        <i class="bi bi-building"></i>
                        Tambah Pengguna
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive py-4">
                <table class="table table-flush" id="table-pengguna" width="100%">
                    <thead class=" thead-light">
                        <tr>
                            <th>No.</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
    $(document).ready(function() {
        users.initDocReady();
    });
</script>
<?= $this->endSection() ?>