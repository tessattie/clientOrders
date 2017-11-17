<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Product'), ['action' => 'edit', $product->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Product'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Brands'), ['controller' => 'Brands', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Brand'), ['controller' => 'Brands', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="products view large-9 medium-8 columns content">
    <h3><?= h($product->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('ItemDescription') ?></th>
            <td><?= h($product->ItemDescription) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pack') ?></th>
            <td><?= h($product->Pack) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Brand') ?></th>
            <td><?= $product->has('brand') ? $this->Html->link($product->brand->name, ['controller' => 'Brands', 'action' => 'view', $product->brand->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('SizeAlpha') ?></th>
            <td><?= h($product->SizeAlpha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Featured Image') ?></th>
            <td><?= h($product->featured_image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($product->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('UPC') ?></th>
            <td><?= $this->Number->format($product->UPC) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Retail') ?></th>
            <td><?= $this->Number->format($product->Retail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CertCode') ?></th>
            <td><?= $this->Number->format($product->CertCode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($product->status) ?></td>
        </tr>
    </table>
</div>
