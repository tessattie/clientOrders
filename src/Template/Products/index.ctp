<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="panel panel-default">
  <div class="panel-heading">
  <div class="row">
      <div class="col-md-9">
          <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span> Manage Products</h3>
      </div>
      <div class="col-md-3"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#newProduct" style="float:right">
                    <span class='glyphicon glyphicon-plus'></span> New Product
                  </button>
       <button type="button" class="btn btn-default" data-toggle="modal" data-target="#importProducts" style="float:right;margin-right:5px">
                    <span class='glyphicon glyphicon-import'></span> Import
      </button>             
    </div>
  </div>
    
    
  </div>
  <div class="panel-body">
    <div class="row">
    <div class="col-md-12">
        <table id="usersTable">
        <thead>
            <tr>

                <th scope="col" colspan="2" class="text-center">UPC</th>
                <th scope="col" class="text-center">Vendor Item #</th>
                <th scope="col" class="text-center">Brand</th>
                <th scope="col" class="text-center">Description</th>
                <th scope="col" class="text-center">Pack</th>
                <th scope="col" class="text-center">Size</th>
                <th scope="col" class="text-center">Onhand</th>
                <th scope="col" class="text-center">Retail</th>
                <th scope="col" class="text-center">Status</th>
                <th scope="col" class="actions text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
            <tr>
                <td class="text-center"><?= $this->Html->image('products/'.$product->featured_image, ["width" => "60px", "height" => "auto"]); ?></td>
                
                <td class="text-center"><?= $product->UPC ?></td>

                <td class="text-center"><?= $product->CertCode ?></td>

                <td class="text-center"><?= $product->has('brand') ? $this->Html->link($product->brand->name, ['controller' => 'Brands', 'action' => 'view', $product->brand->id]) : '' ?></td>
                
                <td class="text-center"><?= h($product->ItemDescription) ?></td>
                
                <td class="text-center"><?= h($product->Pack) ?></td>
                
                <td class="text-center"><?= h($product->SizeAlpha) ?></td>
                <td class="text-center"><?= h($product->onhand) ?></td>

                <td class="text-center"><?= $this->Number->format($product->Retail) ?> HTG</td>
                
                <?php if($product->status == 0) : ?>
                    <td class="text-center"><span class="label label-danger"><?= $status[$product->status] ?></span></td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-success"><?= $status[$product->status] ?><span></td>
                <?php endif; ?>

                <td class="actions text-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a href="#" data-toggle="modal" data-target="#edit_product_<?= $product->id ?>" ><i class='glyphicon glyphicon-pencil'></i> Edit</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#" data-toggle="modal" data-target="#delete_product_<?= $product->id ?>"><i class='glyphicon glyphicon-trash'></i> Delete</a></li>
                      </ul>
                    </div>
                </td>
            </tr>
            </tr>
            <div class="modal fade" id="delete_product_<?= $product->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Confirmation</h4>
                    
                  </div>
                  <div class="modal-body">
                    Are you sure you vould like to delete the product : <?= $product->description ?> ?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary"><a href="<?= ROOT_DIREC ?>/products/delete/<?= $product->id ?>" style="color:white">Yes</a></button>
                  </div>
                </div>
              </div>
            </div>
            <div id="edit_product_<?= $product->id ?>" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><span class='glyphicon glyphicon-pencil'></span> Edit : <?= $product->ItemDescription ?></h4>
              </div>
              <?php 
                if(!empty($currentEdit) && $currentEdit->id == $product->id){
                  echo $this->Form->create($currentEdit, array('enctype' => 'multipart/form-data'));
                  echo $this->Form->input('id', array('type' => "hidden", 'value' => $currentEdit->id));
                }else{
                  echo $this->Form->create($product, array('enctype' => 'multipart/form-data'));
                  echo $this->Form->input('id', array('type' => "hidden", 'value' => $product->id));
                } 
              ?>
              <?= $this->Form->input('formtype', array('type' => "hidden", 'value' => "1")); ?>
              <div class="modal-body">
                <div class="row">
          <div class="col-xs-6 col-md-6 col-md-offset-3 col-xs-offset-3">
            <label class="btn btn-default btn-file modallabel" id="fileInputLabel">
                <?php if(!empty($product->featured_image)) : ?>
                    <?= $this->Form->input('featured_image', array('type' => "hidden", "name" => "featured_image", "value" => $product->featured_image)); ?>
                    <img class="thumbnailImg" src="<?= ROOT_DIREC ?>/img/products/<?= $product->featured_image ?>" width="100%" height="auto">
                <?php else :  ?>
                    <img class="thumbnailImg" src="<?= ROOT_DIREC ?>/img/thumbnail.jpg" width="100%" height="auto">
                <?php endif ;  ?>
                 <input type="file" style="display: none;" class="inputFile" name="featured_image">
            </label>
            <?= (!empty($fileerror)) ? "<div class='error-message'>".$fileerror."</div>" : "" ?>
          </div>
        </div>
        <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">UPC :</label></div>
          <div class="col-md-8"><?= $this->Form->input('UPC', array('class' => "form-control", "label" => false, "placeholder" => "UPC", "value" => $product->UPC)); ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Vendor Item Code :</label></div>
          <div class="col-md-8"><?= $this->Form->input('CertCode', array('class' => "form-control", "label" => false, "placeholder" => "Vendor Item #", "value" => $product->CertCode)); ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Brand :</label></div>
          <div class="col-md-8"><?= $this->Form->input('brand_id', array('class' => "form-control", "label" => false, "options" => $brands, "value" => $product->brand_id, "empty"=> " -- Choose Brand -- ")); ?>
          </div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Pack :</label></div>
          <div class="col-md-8"><?= $this->Form->input('Pack', array('class' => "form-control", "label" => false, "value" => $product->Pack, "placeholder" => "Pack")); ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Size Alpha :</label></div>
          <div class="col-md-8"><?= $this->Form->input('SizeAlpha', array('class' => "form-control", "label" => false, "value" => $product->SizeAlpha, "placeholder" => "Size")); ?>
          </div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Retail :</label></div>
          <div class="col-md-8"><?= $this->Form->input('Retail', array('class' => "form-control", "label" => false, "value" => $product->Retail, "placeholder" => "Retail")); ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Status :</label></div>
          <div class="col-md-8"><?= $this->Form->input('status', array('class' => "form-control", "label" => false, "options" => $status, "value" => $product->status)); ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Onhand stock :</label></div>
          <div class="col-md-8"><?= $this->Form->input('onhand', array('class' => "form-control", "label" => false, "placeholder" => "Stock value", "value" => $product->onhand)); ?>
          </div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Item Description :</label></div>
          <div class="col-md-8"><?= $this->Form->input('ItemDescription', array('class' => "form-control", "label" => false, "placeholder" => "Description", "value" => $product->ItemDescription, "type" => "textarea")); ?>
          </div>
      </div>
              </div>
              <div class="modal-footer">
                <?= $this->Form->button(__('Submit'), array('class' => "btn btn-success")); ?>              
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
              <?= $this->Form->end() ?>
            </div>
          </div>
        </div></div>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
  </div>
</div>
<!-- Modal -->
<div id="newProduct" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class='glyphicon glyphicon-plus'></span> New Product</h4>
      </div>
      <?= $this->Form->create($prd, array('enctype' => 'multipart/form-data')) ?>
      <?= $this->Form->control('formtype', array('type' => "hidden", 'value' => "2")); ?>
      <div class="modal-body">
      <div class="row">
          <div class="col-xs-6 col-md-6 col-md-offset-3 col-xs-offset-3">
            <label class="btn btn-default btn-file modallabel" id="fileInputLabel">
                <?php if(!empty($prd->featured_image)) : ?>
                    <?= $this->Form->input('featured_image', array('type' => "hidden", "name" => "featured_image", "value" => $prd->featured_image)); ?>
                    <img class="thumbnailImg" src="<?= ROOT_DIREC ?>/img/products/<?= $prd->featured_image ?>" width="100%" height="auto">
                <?php else :  ?>
                    <img class="thumbnailImg" src="<?= ROOT_DIREC ?>/img/thumbnail.jpg" width="100%" height="auto">
                <?php endif ;  ?>
                 <input type="file" style="display: none;" class="inputFile" name="featured_image">
            </label>
            <?= (!empty($fileerror)) ? "<div class='error-message'>".$fileerror."</div>" : "" ?>
          </div>
        </div>
        <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">UPC :</label></div>
          <div class="col-md-8"><?= $this->Form->input('UPC', array('class' => "form-control", "label" => false, "placeholder" => "UPC", "value" => $prd->UPC)); ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Vendor Item Code :</label></div>
          <div class="col-md-8"><?= $this->Form->input('CertCode', array('class' => "form-control", "label" => false, "placeholder" => "Vendor Item #", "value" => $prd->CertCode)); ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Brand :</label></div>
          <div class="col-md-8"><?= $this->Form->input('brand_id', array('class' => "form-control", "label" => false, "options" => $brands, "value" => $prd->brand_id, "empty"=> " -- Choose Brand -- ")); ?>
          </div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Pack :</label></div>
          <div class="col-md-8"><?= $this->Form->input('Pack', array('class' => "form-control", "label" => false, "value" => $prd->Pack, "placeholder" => "Pack")); ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Size Alpha :</label></div>
          <div class="col-md-8"><?= $this->Form->input('SizeAlpha', array('class' => "form-control", "label" => false, "value" => $prd->SizeAlpha, "placeholder" => "Size")); ?>
          </div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Retail :</label></div>
          <div class="col-md-8"><?= $this->Form->input('Retail', array('class' => "form-control", "label" => false, "value" => $prd->Retail, "placeholder" => "Retail")); ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Status :</label></div>
          <div class="col-md-8"><?= $this->Form->input('status', array('class' => "form-control", "label" => false, "options" => $status, "value" => $prd->status)); ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Onhand stock :</label></div>
          <div class="col-md-8"><?= $this->Form->input('onhand', array('class' => "form-control", "label" => false, "placeholder" => "Stock value", "value" => $prd->onhand)); ?>
          </div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Item Description :</label></div>
          <div class="col-md-8"><?= $this->Form->input('ItemDescription', array('class' => "form-control", "label" => false, "placeholder" => "Description", "value" => $prd->ItemDescription, "type" => "textarea")); ?>
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <?= $this->Form->button(__('Submit'), array('class' => "btn btn-success")); ?>      
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      <?= $this->Form->end() ?>
      </div>
    </div>

  </div>
</div></div>


<?php if(!empty($success)) : ?>
  <?php   echo "<script>$(document).ready(function(){ $('#successModal').modal('show'); })</script>"; ?>
<?php else :  ?>
<?php endif; ?>

  <div class="modal fade" id="successModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><i class='menu-icon fa fa-check'></i> Confirmation</h4>
      </div>
      <div class="modal-body">
        <p class="bg-success"><i class="glyphicon glyphicon-ok"></i> <?= $success ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="importProducts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel"><span class='glyphicon glyphicon-import'></span> Import Products</h4>
        
      </div>
      <?= $this->Form->create("", array('enctype' => 'multipart/form-data', "url" => "/products/importExcel")) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-6 col-md-6 col-md-offset-3 col-xs-offset-3">
            <label class="btn btn-default btn-file modallabel" id="fileInputLabel">

                  <img class="thumbnailImg" src="<?= ROOT_DIREC ?>/img/thumbnail.png" width="50%" height="auto">
                 <input type="file" style="display: none;" class="inputFiles" name="featured_image">
            </label>
            <?= (!empty($fileerror)) ? "<div class='error-message'>".$fileerror."</div>" : "" ?>
          </div>
        </div>
        <hr>
        <div class="row"> 
             <div class="col-md-3"><label>Uploaded file :</label> </div>
             <div class="col-md-9"><span id='uploadedFile'></span></div>
        </div>  
        <hr>
        <div class="row">
          <div class="col-md-3"><label class="modallabel">Brand :</label></div>
          <div class="col-md-9"><?= $this->Form->input('brand_id', array('class' => "form-control", "label" => false, "options" => $brands, "value" => $prd->brand_id, "empty"=> " -- Choose Brand -- ")); ?>
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <?= $this->Form->button(__('Submit'), array('class' => "btn btn-success")); ?>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      <?= $this->Form->end(); ?>
    </div>
  </div>
</div>

<?php if(!empty($errors)) {
  echo "<script>$(document).ready(function(){ $('#newProduct').modal(); })</script>";
  } ?>

  <?php if(!empty($modalToShow)) {
  echo "<script>$(document).ready(function(){ $('#".$modalToShow."').modal('show'); })</script>";
  } ?>



