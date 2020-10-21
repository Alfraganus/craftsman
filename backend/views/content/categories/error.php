<?php 
$this->title = 'Not found';
$this->breadcrumbs[] = ['label' => 'Categories', 'url' => $main_url]; ?>

<div class="card">
    <div class="card-body page-item-not-found">
        <i class="ri-error-warning-line"></i>
        <h3>Category not found!</h3>
        <p>The category you were looking for does not exist, unavailable for you or deleted.</p>

        <a href="<?= $main_url; ?>" class="btn btn-secondary waves-effect btn-with-icon">
            <i class="ri-arrow-left-line mr-1"></i>
            Back to Categories
        </a>
    </div>
</div>