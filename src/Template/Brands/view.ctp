<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Brand'), ['action' => 'edit', $brand->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Brand'), ['action' => 'delete', $brand->id], ['confirm' => __('Are you sure you want to delete # {0}?', $brand->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Brands'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Brand'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="brands view large-9 medium-8 columns content">
    <h3><?= h($brand->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($brand->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($brand->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Products') ?></h4>
        <?php if (!empty($brand->products)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Code') ?></th>
                <th scope="col"><?= __('Brand Id') ?></th>
                <th scope="col"><?= __('Fob') ?></th>
                <th scope="col"><?= __('Door Cost') ?></th>
                <th scope="col"><?= __('Selling Price') ?></th>
                <th scope="col"><?= __('Real Selling') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Stock Status') ?></th>
                <th scope="col"><?= __('Pack') ?></th>
                <th scope="col"><?= __('Size') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Featured Image') ?></th>
                <th scope="col"><?= __('Size Type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($brand->products as $products): ?>
            <tr>
                <td><?= h($products->id) ?></td>
                <td><?= h($products->name) ?></td>
                <td><?= h($products->price) ?></td>
                <td><?= h($products->code) ?></td>
                <td><?= h($products->brand_id) ?></td>
                <td><?= h($products->fob) ?></td>
                <td><?= h($products->door_cost) ?></td>
                <td><?= h($products->selling_price) ?></td>
                <td><?= h($products->real_selling) ?></td>
                <td><?= h($products->status) ?></td>
                <td><?= h($products->stock_status) ?></td>
                <td><?= h($products->pack) ?></td>
                <td><?= h($products->size) ?></td>
                <td><?= h($products->description) ?></td>
                <td><?= h($products->featured_image) ?></td>
                <td><?= h($products->size_type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Products', 'action' => 'view', $products->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Products', 'action' => 'edit', $products->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Products', 'action' => 'delete', $products->id], ['confirm' => __('Are you sure you want to delete # {0}?', $products->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
