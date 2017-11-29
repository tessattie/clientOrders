<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="panel panel-default">
  <div class="panel-heading">
  <div class="row">
      <div class="col-md-11">
          <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span> Manage Brands</h3>
      </div>
      <div class="col-md-1"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#newBrand" style="float:right">
                    <span class='glyphicon glyphicon-plus'></span> New Brand
                  </button></div>
  </div>
    
    
  </div>
  <div class="panel-body">
    <div class="row">
    <div class="col-md-12">
        <table id="usersTable">
        <thead>
            <tr>
                <th scope="col" colspan="2" class="text-center">Brand</th>
                <th scope="col" class="text-center">Vendor</th>
                <th scope="col" class="actions text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($brands as $brand): ?>
            <tr>
                <td class="text-center"><?= $this->Html->image('brands/'.$brand->featured_image, ["width" => "60px", "height" => "auto"]); ?></td>
                <td class="text-center"><?= h($brand->name) ?></td>
                <td class="text-center"><?= h($brand->vendor) ?></td>
                <td class="actions text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="#" data-toggle="modal" data-target="#edit_brand_<?= $brand->id ?>" ><i class='glyphicon glyphicon-pencil'></i> Edit</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" data-toggle="modal" data-target="#delete_brand_<?= $brand->id ?>"><i class='glyphicon glyphicon-trash'></i> Delete</a></li>
                  </ul>
                </div>
                </td>
            </tr>
            <div class="modal fade" id="delete_brand_<?= $brand->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Confirmation</h4>
                    
                  </div>
                  <div class="modal-body">
                    Are you sure you vould like to delete the brand : <?= $brand->name ?> ?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary"><a href="<?= ROOT_DIREC ?>/brands/delete/<?= $brand->id ?>" style="color:white">Yes</a></button>
                  </div>
                </div>
              </div>
            </div>

            <div id="edit_brand_<?= $brand->id ?>" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class='menu-icon fa fa-pencil'></i> Edit : <?= $brand->name ?></h4>
              </div>
              <?php 
                if(!empty($currentEdit) && $currentEdit->id == $brand->id){
                  echo $this->Form->create($currentEdit, array('enctype' => 'multipart/form-data'));
                  echo $this->Form->input('id', array('type' => "hidden", 'value' => $currentEdit->id));
                }else{
                  echo $this->Form->create($brand, array('enctype' => 'multipart/form-data'));
                  echo $this->Form->input('id', array('type' => "hidden", 'value' => $brand->id));
                } 
              ?>
              <?= $this->Form->input('formtype', array('type' => "hidden", 'value' => "1")); ?>
              <div class="modal-body">
      <div class="row">
          <div class="col-xs-6 col-md-6 col-md-offset-3 col-xs-offset-3">
            <label class="btn btn-default btn-file modallabel" id="fileInputLabe">
                <?php if(!empty($brand->featured_image)) : ?>
                    <img class="thumbnailImg" src="<?= ROOT_DIREC ?>/img/brands/<?= $brand->featured_image ?>" width="100%" height="auto">
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
          <div class="col-md-4"><label class="modallabel">Brand name:</label></div>
          <div class="col-md-8"><?= $this->Form->input('name', array('class' => "form-control", "label" => false, "placeholder" => "Brand name", "required" => false, "value" => $brand->name)); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Vendor #:</label></div>
          <div class="col-md-8"><?= $this->Form->input('vendor', array('class' => "form-control", "label" => false, "placeholder" => "Vendor", "required" => false, "value" => $brand->vendor)); ?></div>
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
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
  </div>
</div>
<!-- Modal -->
<div id="newBrand" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class='glyphicon glyphicon-plus'></span> New Brand</h4>
      </div>
      <?= $this->Form->create($brd, array('enctype' => 'multipart/form-data')) ?>
      <?= $this->Form->control('formtype', array('type' => "hidden", 'value' => "2")); ?>
      <div class="modal-body">
      <div class="row">
          <div class="col-xs-6 col-md-6 col-md-offset-3 col-xs-offset-3">
            <label class="btn btn-default btn-file modallabel" id="fileInputLabel">
                <?php if(!empty($brd->logo)) : ?>
                    <?= $this->Form->input('featured_image', array('type' => "hidden", "name" => "featured_image", "value" => $brd->featured_image)); ?>
                    <img class="thumbnailImg" src="<?= ROOT_DIREC ?>/img/brd/<?= $brd->logo ?>" width="100%" height="auto">
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
          <div class="col-md-4"><label class="modallabel">Brand name:</label></div>
          <div class="col-md-8"><?= $this->Form->input('name', array('class' => "form-control", "label" => false, "placeholder" => "Brand name", "required" => false, "value" => $brd->name)); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Vendor #:</label></div>
          <div class="col-md-8"><?= $this->Form->input('vendor', array('class' => "form-control", "label" => false, "placeholder" => "Vendor", "required" => false, "value" => $brd->vendor)); ?></div>
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
        <h4 class="modal-title"><i class='menu-icon fa fa-plus'></i> Confirmation</h4>
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

<?php if(!empty($errors)) {
  echo "<script>$(document).ready(function(){ $('#newUser').modal(); })</script>";
  } ?>

  <?php if(!empty($modalToShow)) {
  echo "<script>$(document).ready(function(){ $('#".$modalToShow."').modal('show'); })</script>";
  } ?>



