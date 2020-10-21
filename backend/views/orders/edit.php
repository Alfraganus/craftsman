<?php 
$this->title = 'Order: AV-11977'; 
$this->breadcrumb_title = 'Edit Order';
$this->breadcrumbs[] = ['label' => 'Orders', 'url' => $main_url]; ?>

<?php 
$this->registerCss(<<< CSS
    .table-user-infos td {
        width: 50%;
    }

    .table-order-address {
        table-layout: fixed;
    }

    .table-order-address td:first-child {
        width: 180px;
    }

    .table-order-products-total-info table tr:first-child td {
        border-color: #fff;
    }

    img.order-product-image {
        width: 30px;
        height: 30px;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }
CSS
);?>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-tabs-custom nav-justified mb-3" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#products" role="tab">
            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
            <span class="d-none d-sm-block">Info & Products</span> 
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#payment" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
            <span class="d-none d-sm-block">Payment & Address</span>   
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#contract" role="tab">
            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
            <span class="d-none d-sm-block">Contract</span> 
        </a>
    </li>
</ul>

<div class="tab-content">
    <!-- Tab item -->
    <div class="tab-pane active" id="products" role="tabpanel">
        <form class="full-form" method="post">
            <div class="card mb-3">
                <div class="card-body row">
                    <div class="col-md-6 form-group">
                        <label for="customer-name">Customer:</label>
                        <input type="text" class="form-control" value="Ulugbek Nuriddinov" disabled>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="customer-name">Created date:</label>
                        <input type="text" class="form-control" value="16/30/2020 14:00" disabled>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="customer-name">Cargo type:</label>
                        <select name="" class="form-control custom-select">
                            <option value="Toshkent pochtasi">Toshkent pochtasi</option>
                            <option value="DHL">DHL</option>
                            <option value="MSN Cargo">MSN Cargo</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="customer-name">Cargo Track No:</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="customer-name">Status:</label>
                        <select name="" class="form-control custom-select">
                            <?php 
                            foreach(order_statuses() as $status_key => $status_name) {
                                echo '<option value="'. $status_key .'">'. $status_name .'</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="customer-name">Note for customer:</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Products name</th>
                                    <th>Count</th>
                                    <th>Price</th>
                                    <th>Sale</th>
                                    <th>Coupon</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>
                                        <a href="<?= images_url('default-image.png'); ?>" class="image-popup-no-margins">
                                            <img src="<?= images_url('default-image.png'); ?>" class="order-product-image" alt="image">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-primary">USB Cabel</a>
                                    </td>
                                    <td>5</td>
                                    <td>6.00 $</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>30.00 $</td>
                                    <td class="ta-icons-block">
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="edit-order-product" ta-single-id="10">
                                                <i class="ri-edit-line" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                            </a>
                                        </div>
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="add-coupon-order-product" ta-single-id="10">
                                                <i class="ri-coupon-line" data-toggle="tooltip" data-placement="top" title="Add coupon"></i>
                                            </a>
                                        </div>
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="delete-order-product" ta-single-id="10">
                                                <i class="ri-delete-bin-line" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>
                                        <a href="<?= images_url('default-image.png'); ?>" class="image-popup-no-margins">
                                            <img src="<?= images_url('default-image.png'); ?>" class="order-product-image" alt="image">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-primary">Charger</a>
                                    </td>
                                    <td>2</td>
                                    <td>12.50 $</td>
                                    <td>0</td>
                                    <td>5.00 $</td>
                                    <td>20.00 $</td>
                                    <td class="ta-icons-block">
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="edit-order-product" ta-single-id="10">
                                                <i class="ri-edit-line" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                            </a>
                                        </div>
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="delete-coupon-order-product" ta-single-id="10">
                                                <i class="ri-coupon-2-line" data-toggle="tooltip" data-placement="top" title="Delete coupon"></i>
                                            </a>
                                        </div>
                                        <div class="ta-icons-in">
                                            <a href="javascript:void(0);" ta-single-action="delete-order-product" ta-single-id="10">
                                                <i class="ri-delete-bin-line" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-order-products-total-info">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Products price:</td>
                                    <td>
                                        <b class="text-secondary">42.50 $</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total sale:</td>
                                    <td>
                                        <b class="text-danger">0.00 $</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total coupon:</td>
                                    <td>
                                        <b class="text-danger">- 5.00 $</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cargo price:</td>
                                    <td>
                                        <b class="text-primary">+ 10.00 $</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total:</td>
                                    <td>
                                        <b>60.00 $</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mb-3 full-form-btns">
                <button type="submit" class="btn btn-success waves-effect btn-with-icon">
                    <i class="ri-check-line mr-1"></i>
                    Save changes
                </button>

                <a href="<?= get_previous_url($main_url); ?>" class="btn btn-secondary waves-effect btn-with-icon">
                    <i class="ri-arrow-left-line mr-1"></i>
                    Back to orders
                </a>
            </div>
        </form>
    </div> <!-- /Tab item -->

    <!-- Tab item -->
    <div class="tab-pane" id="contract" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    ...
                </div>
            </div>
        </div>
    </div> <!-- /Tab item -->

    <!-- Tab item -->
    <div class="tab-pane" id="payment" role="tabpanel">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <h4 class="mb-4">Payment information</h4>

                    <table class="table table-order-address mb-4">
                        <tbody>
                            <tr>
                                <td>
                                    <b>Payment Type</b>
                                </td>
                                <td>Credit card</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Payment Date</b>
                                </td>
                                <td>30/06/2020 14:45</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Payed</b>
                                </td>
                                <td>840.00 $</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Card no</b>
                                </td>
                                <td>**** **** **** 4587</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Card type</b>
                                </td>
                                <td>Master Card</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="mb-4">Shipping address</h4>

                    <table class="table table-order-address mb-4">
                        <tbody>
                            <tr>
                                <td>
                                    <b>Name</b>
                                </td>
                                <td>Ulugbek Nuriddinov</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Phone</b>
                                </td>
                                <td>+90 541 481 9295</td>
                            </tr>
                            <tr>
                                <td>Email address:</td>
                                <td>ucoder92@gmail.com</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Address</b>
                                </td>
                                <td>
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusantium optio quaerat ab voluptate nostrum, autem labore? Eaque alias excepturi voluptate reprehenderit. Consequuntur perspiciatis fugit quibusdam optio iusto delectus dolorem. Mollitia!
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="mb-4">Contract address</h4>

                    <table class="table table-order-address mb-0">
                        <tbody>
                            <tr>
                                <td>
                                    <b>Name</b>
                                </td>
                                <td>Ulugbek Nuriddinov</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Phone</b>
                                </td>
                                <td>+90 541 481 9295</td>
                            </tr>
                            <tr>
                                <td>Email address:</td>
                                <td>ucoder92@gmail.com</td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Address</b>
                                </td>
                                <td>
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusantium optio quaerat ab voluptate nostrum, autem labore? Eaque alias excepturi voluptate reprehenderit. Consequuntur perspiciatis fugit quibusdam optio iusto delectus dolorem. Mollitia!
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- /Tab item -->
</div>