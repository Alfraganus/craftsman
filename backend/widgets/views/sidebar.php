<?php
$app = Yii::$app;

use yii\helpers\Url; ?>

<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="<?= Url::to(['/']); ?>" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-line-chart-line"></i>
                        <span>Orders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= Url::to(['/orders']); ?>">All orders</a></li>
                        <li><a href="<?= Url::to(['/orders/new']); ?>">New orders</a></li>
                        <li><a href="<?= Url::to(['/orders/processing']); ?>">Processing orders</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-shopping-cart-2-line"></i>
                        <span>Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= Url::to(['/products/action/create']); ?>">Add new</a></li>
                        <li><a href="<?= Url::to(['/products/all']); ?>">All products</a></li>
                        <li><a href="<?= Url::to(['/products/campaigns']); ?>">Campaigns</a></li>
                        <li><a href="<?= Url::to(['/products/sponsored']); ?>">Sponsored products</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-menu-2-fill"></i>
                        <span>Fields</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= Url::to(['/fields/brands']); ?>">Brands</a></li>
                        <li><a href="<?= Url::to(['/fields/category']); ?>">Categories</a></li>
                        <li><a href="<?= Url::to(['/fields/custom-fields']); ?>">Custom fields</a></li>
                        <li><a href="<?= Url::to(['/fields/product-variants']); ?>">Product variants</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-checkbox-multiple-blank-line"></i>
                        <span>Content</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= Url::to(['/content/posts']); ?>">Posts</a></li>
                        <li><a href="<?= Url::to(['/content/pages']); ?>">Pages</a></li>
                        <li><a href="<?= Url::to(['/content/tags']); ?>">Tags</a></li>
                        <li><a href="<?= Url::to(['/content/categories']); ?>">Categories</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-brush-2-fill"></i>
                        <span>Appearance</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= Url::to(['/appearance/customize']); ?>">Customize</a></li>
                        <li><a href="<?= Url::to(['/appearance/menus']); ?>">Menus</a></li>
                        <li><a href="<?= Url::to(['/appearance/themes']); ?>">Themes</a></li>
                        <li><a href="<?= Url::to(['/appearance/widgets']); ?>">Widgets</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-folder-3-line"></i>
                        <span>Media</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= Url::to(['/media/files']); ?>">Files</a></li>
                        <li><a href="<?= Url::to(['/media/images/?view=grid']); ?>">Images</a></li>
                        <li><a href="<?= Url::to(['/media/uploads']); ?>">Uploads</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-store-2-line"></i>
                        <span>Shops & Vendors</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= Url::to(['/vendors']); ?>">All vendors</a></li>
                        <li><a href="<?= Url::to(['/shops']); ?>">All shops</a></li>
                        <li><a href="<?= Url::to(['/shops/pending']); ?>">Pending shops</a></li>
                        <li><a href="<?= Url::to(['/shops/blocked']); ?>">Blocked shops</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-group-line"></i>
                        <span>Customers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= Url::to(['/users/create']) ?>">Add new</a></li>
                        <li><a href="<?= Url::to(['/users']) ?>">All customers</a></li>
                        <li><a href="<?= Url::to(['/users/pending']); ?>">Pending customers</a></li>
                        <li><a href="<?= Url::to(['/users/blocked']); ?>">Blocked customers</a></li>
                        <li><a href="<?= Url::to(['/users/roles']); ?>">User roles</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-settings-3-line"></i>
                        <span>System</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= Url::to('/system/settings') ?>">Settings</a></li>
                        <li><a href="<?= Url::to(['/system/languages']); ?>">Languages</a></li>
                        <li><a href="<?= Url::to(['/system/payments']) ?>">Payments & Currency</a></li>
                        <li><a href="<?= Url::to(['/system/locations']); ?>">Locations</a></li>
                        <li><a href="<?= Url::to(['/system/trashbox']); ?>">Trashbox</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-code-fill"></i>
                        <span>Developer</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?= Url::to('/system/settings/create') ?>">Settings Create</a></li>
                        <li><a href="<?= Url::to(['/developer/submenu']); ?>">Sub menu</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>