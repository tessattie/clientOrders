<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $customers
 */
?>
<div class="panel panel-default">
  <div class="panel-heading">
  <div class="row">
      <div class="col-md-11">
          <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span> Manage customers</h3>
      </div>
      <div class="col-md-1"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#newCustomer" style="float:right">
                    <span class='glyphicon glyphicon-plus'></span> New customer
                  </button></div>
  </div>
    
    
  </div>
  <div class="panel-body">
    <div class="row">
    <div class="col-md-12">
        <table id="usersTable">
        <thead>
            <tr>
                <th scope="col" class="text-center">Name</th>
                <th scope="col" class="actions text-center">Address</th>
                <th scope="col" class="actions text-center">Email</th>
                <th scope="col" class="actions text-center">Phone</th>
                <th scope="col" class="actions text-center">Customer message</th>
                <th scope="col" class="actions text-center">Username</th>
                <th scope="col" class="actions text-center">Status</th>
                <th scope="col" class="actions text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
            <tr>
                <td class="text-center"><?= $customer->name ?></td>
                <td class="text-center"><?= h($customer->address) ?></td>
                <td class="text-center"><?= h($customer->email) ?></td>
                <td class="text-center"><?= h($customer->phone) ?></td>
                <td class="text-center"><?= h($customer->customer_message) ?></td>
                <td class="text-center"><?= $customer->username ?></td>
                <?php if($customer->status == 0) : ?>
                    <td class="text-center"><span class="label label-danger"><?= $status[$customer->status] ?></span></td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-success"><?= $status[$customer->status] ?><span></td>
                <?php endif; ?>
                <td class="actions text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="#" data-toggle="modal" data-target="#edit_customer_<?= $customer->id ?>" ><i class='glyphicon glyphicon-pencil'></i> Edit</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" data-toggle="modal" data-target="#delete_customer_<?= $customer->id ?>"><i class='glyphicon glyphicon-trash'></i> Delete</a></li>
                  </ul>
                </div>
                </td>
            </tr>
            <div class="modal fade" id="delete_customer_<?= $customer->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Confirmation</h4>
                    
                  </div>
                  <div class="modal-body">
                    Are you sure you vould like to delete the customer : <?= $customer->name ?> ?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary"><a href="<?= ROOT_DIREC ?>/customers/delete/<?= $customer->id ?>" style="color:white">Yes</a></button>
                  </div>
                </div>
              </div>
            </div>
            <div id="edit_customer_<?= $customer->id ?>" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class='glyphicon glyphicon-pencil'></i> Edit : <?= $customer->name ?></h4>
              </div>
              <?php 
                if(!empty($currentEdit) && $currentEdit->id == $customer->id){
                  echo $this->Form->create($currentEdit);
                  $thiscust = $currentEdit;
                  echo $this->Form->input('id', array('type' => "hidden", 'value' => $currentEdit->id));
                }else{
                  echo $this->Form->create($customer);
                  $thiscust = $customer;
                  echo $this->Form->input('id', array('type' => "hidden", 'value' => $customer->id));
                } 
              ?>
              <?= $this->Form->input('formtype', array('type' => "hidden", 'value' => "1")); ?>
              <div class="modal-body">
                <div class="row">
          <div class="col-md-4"><label class="modallabel">Name :</label></div>
          <div class="col-md-8"><?= $this->Form->input('name', array('class' => "form-control", "label" => false, "placeholder" => "Customer name", "required" => false, "value" => $thiscust->name)); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Address :</label></div>
          <div class="col-md-8"><?= $this->Form->input('address', array('class' => "form-control", "label" => false, "placeholder" => "Customer address", "required" => false, "value" => $thiscust->address)); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Email :</label></div>
          <div class="col-md-8"><?= $this->Form->input('email', array('class' => "form-control", "label" => false, "placeholder" => "Customer email", "value" => $thiscust->email)); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Phone :</label></div>
          <div class="col-md-8"><?= $this->Form->input('phone', array('class' => "form-control", "label" => false, "placeholder" => "Customer phone", "value" => $thiscust->phone)); ?></div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Username :</label></div>
          <div class="col-md-8"><?= $this->Form->input('username', array('class' => "form-control", "label" => false, "placeholder" => "Customer username", "value" => $thiscust->username, "autocomplete" => "new-password")); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Password :</label></div>
          <div class="col-md-8"><?= $this->Form->input('password', array('class' => "form-control", "label" => false, "placeholder" => "Password", "required" => false, "value" => $thiscust->password, "autocomplete" => "new-password")); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Confirm Password :</label></div>
          <div class="col-md-8"><?= $this->Form->input('confirm_password', array('class' => "form-control", "label" => false, "placeholder" => "Confirm password", "value" => $thiscust->password, "autocomplete" => "new-password", "type" => "password")); ?></div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Status :</label></div>
          <div class="col-md-8"><?= $this->Form->input('status', array('class' => "form-control", "type" => "select", "label" => false, "options" => $status, 'value' => $thiscust->status)); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Customer message :</label></div>
          <div class="col-md-8"><?= $this->Form->input('customer_message', array('class' => "form-control", "label" => false, "type" => "textarea", "placeholder" => "Customer message", "required" => false, "value" => $thiscust->customer_message)); ?></div>
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
<div id="newCustomer" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class='glyphicon glyphicon-plus'></span> New Customer</h4>
      </div>
      <?= $this->Form->create($cust) ?>
      <?= $this->Form->control('formtype', array('type' => "hidden", 'value' => "2")); ?>
      <div class="modal-body">
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Name :</label></div>
          <div class="col-md-8"><?= $this->Form->input('name', array('class' => "form-control", "label" => false, "placeholder" => "Customer name", "required" => false, "value" => $cust->name)); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Address :</label></div>
          <div class="col-md-8"><?= $this->Form->input('address', array('class' => "form-control", "label" => false, "placeholder" => "Customer address", "required" => false, "value" => $cust->address)); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Email :</label></div>
          <div class="col-md-8"><?= $this->Form->input('email', array('class' => "form-control", "label" => false, "placeholder" => "Customer email", "value" => $cust->email)); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Phone :</label></div>
          <div class="col-md-8"><?= $this->Form->input('phone', array('class' => "form-control", "label" => false, "placeholder" => "Customer phone", "value" => $cust->phone)); ?></div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Username :</label></div>
          <div class="col-md-8"><?= $this->Form->input('username', array('class' => "form-control", "label" => false, "placeholder" => "Customer username", "value" => $cust->username, "autocomplete" => "new-password")); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Password :</label></div>
          <div class="col-md-8"><?= $this->Form->input('password', array('class' => "form-control", "label" => false, "placeholder" => "Password", "required" => false, "value" => $cust->password, "autocomplete" => "new-password")); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Confirm Password :</label></div>
          <div class="col-md-8"><?= $this->Form->input('confirm_password', array('class' => "form-control", "label" => false, "placeholder" => "Confirm password", "value" => $cust->password, "autocomplete" => "new-password", "type" => "password")); ?></div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Status :</label></div>
          <div class="col-md-8"><?= $this->Form->input('status', array('class' => "form-control", "type" => "select", "label" => false, "options" => $status, 'value' => 1)); ?></div>
      </div>
      <div class="row">
          <div class="col-md-4"><label class="modallabel">Customer message :</label></div>
          <div class="col-md-8"><?= $this->Form->input('customer_message', array('class' => "form-control", "label" => false, "type" => "textarea", "placeholder" => "Customer message", "required" => false, "value" => $cust->customer_message)); ?></div>
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
  echo "<script>$(document).ready(function(){ $('#newCustomer').modal(); })</script>";
  } ?>

  <?php if(!empty($modalToShow)) {
  echo "<script>$(document).ready(function(){ $('#".$modalToShow."').modal('show'); })</script>";
  } ?>



