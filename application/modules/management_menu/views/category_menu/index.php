<div class="row">
    <div class="col-md-4 col-lg-4">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h4 id="formTitle">Add New Data</h4>
                <hr>
                <div class="notifikasi"></div>
                <form id="form-add-category-menu">
                  <div class="form-group">
                    <label for="orderNumber">Order Number</label>
                    <input type="number" class="form-control" id="orderNumber" name="orderNumber" value="<?php echo $order_number; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="categoryName">Category Name</label>
                    <input type="text" class="form-control" id="categoryName" name="categoryName">
                  </div>
                  <div class="form-group">
                      <label for="categoryDescription">Category Description</label>
                      <textarea name="categoryDescription" class="form-control" id="categoryDescription" cols="30" rows="5"></textarea>
                  </div>
                  <label>Groups</label>
                  <?php foreach($master_group->result() as $group): ?>
                    <div class="form-check">
                      <label class="form-check-label" for="check<?php echo $group->id_group; ?>">
                        <input type="checkbox" class="form-check-input checkGroup" id="check<?php echo $group->id_group; ?>" name="group[<?php echo $group->id_group; ?>]" value="<?php echo $group->id_group; ?>"><?php echo $group->group_name; ?>
                      </label>
                    </div>
                  <?php endforeach ?>
                  <br>
                  <div class="form-group">
                    <label for="isActive">Active</label>
                      <select name="isActive" id="isActive" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary" id="btnSaveCategoryMenu">Save</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-lg-8">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="notif"></div>
                <table id="table-category-menu" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th width="1%">Order</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>