<?php $active= 'tables'; include_once 'includes/header.php' ?>
    <!--Container Main start-->
    <div class="container py-3">
        <div class="row justify-content-between mb-3">
            <div class="col-6">
            <h2>Tables</h2>
            </div>
            <div class="col-6 text-end">
                <a href="tables.php" class="btn btn-primary my-auto">New Table</a>
            </div>
        </div>
        <div class="card bg-dark shadow">
            <div class="card-body">
                <table class="table table-dark table-borderless table-hover">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--Container Main end-->
<?php include 'includes/footer.php' ?>