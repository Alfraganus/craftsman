<?php

use backend\models\Currency;

$this->title = 'Payments & Currency'; ?>

<div class="card-top-links row">
    <div class="col-md-7">
        <div class="card-listed-links">
            <a href="<?= $main_url; ?>" class="active">
                Rates
            </a>
            <a href="<?= $main_url . '/settings'; ?>">
                Settings
            </a>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card-listed-links-right">
            <a href="<?= $main_url; ?>/refresh-rate" class="btn btn-success waves-effect">
                Refresh rates
            </a>
            <a href="<?= admin_url(); ?>" class="btn btn-secondary waves-effect">
                Close
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Currency</th>
                        <th class="text-center" width="150px">Price</th>
                        <th class="text-center" width="150px">Previuos</th>
                        <th class="text-center" width="150px">Change %</th>
                        <th class="text-center" width="150px">Change</th>
                        <th class="text-center" width="200px">Updated date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($rates) : ?>
                        <?php foreach ($rates as $rate) : ?>
                            <?php
                            if ($rate->cvalue > $rate->cvbefore) {
                                $class = "success";
                                $title_class = "success";
                            } elseif ($rate->cvalue == $rate->cvbefore) {
                                $class = "secondary";
                                $title_class = "primary";
                            } else {
                                $class = "danger";
                                $title_class = "danger";
                            }
                            $ratePercentage = ($rate->cvalue / $rate->cvbefore) * 100;
                            $ratePercentage = (100 - $ratePercentage);
                            $rateDifference = ($rate->cvalue - $rate->cvbefore); ?>
                            <tr>
                                <td>
                                    <strong style="font-size:17px;"><?= $rate->ckey ?></strong>
                                    <p class="m-0"><?= $rate->cname ?></p>
                                </td>
                                <td class="text-center">
                                    <span class="text-<?= $title_class ?>"><?= Currency::priceFormat($rate->cvalue) ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="text-secondary"><?= Currency::priceFormat($rate->cvbefore) ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="text-<?= $class ?>"><?= Currency::priceFormat($ratePercentage) ?> %</span>
                                </td>
                                <td class="text-center">
                                    <span class="text-<?= $class ?>"><?= Currency::priceFormat($rateDifference) ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="text-secondary"><?= $rate->update_on ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center table-not-found">
                                <i class="ri-error-warning-line"></i>
                                <div class="h5">
                                    Currency rates are not available.
                                    <br>
                                    Please click the <b>"Refresh rates"</b> button!
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>