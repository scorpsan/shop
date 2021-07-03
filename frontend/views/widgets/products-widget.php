<?php
/**
 * @var $items \frontend\models\ShopProducts
 * @var $params array
 * @var $options array
 */

$itemClass = '';
if ($options['count'] > 0) {
    if (!($options['count'] % 4)) {
        $itemClass = 'col-xl-3';
    } elseif (!($options['count'] % 3)) {
        $itemClass = 'col-xl-4';
    } elseif (!($options['count'] % 2)) {
        $itemClass = '';
    }
} else {
    $itemClass = 'col-xl-3';
}
?>
<!-- Products Widget -->
<section class="section-product-v1 <?= $params['style'] ?>">
    <div class="my-container">
        <?php if (isset($params['tagTitle']) && $params['tagTitle'] == 3) { ?>
            <h3 class="heading-3 text-center font-weight-bold"><?= $params['title'] ?></h3>
        <?php } else { ?>
            <div class="section-title">
                <h2><?= $params['title'] ?></h2>
            </div>
        <?php } ?>
        <div class="row">
            <?php foreach ($items as $product) { ?>
                <div class="<?= $itemClass ?> col-lg-4 col-md-4 col-sm-6 col-xs-6 col-6">
                    <?= $this->render('../shop/_one_product', ['product' => $product]) ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- End Products Widget -->