<!-- Modal Sub Menu-->
<div class="modal fade" id="modalSubMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formSubMenu">
                    <input type="hidden" id="idSubMenu" class="idSubMenu" name="idSubMenu">
                    <div class="form-group">
                        <label for="idMenu">Menu</label>
                        <select name="idMenu" id="idMenu" name="idMenu" class="custom-select" style="width: 100%;" onchange="showOrderNumber(this.value)">
                            <option value=""></option>
                            <?php foreach ($master_menu->result() as $data) : ?>
                                <option value="<?php echo $data->id_menu; ?>"><?php echo $data->menu_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="orderNumber">Order Number</label>
                        <input type="number" class="form-control" id="orderNumber" name="orderNumber">
                    </div>
                    <div class="form-group">
                        <label for="subMenuName">Sub Menu Name</label>
                        <input type="text" class="form-control" id="subMenuName" name="subMenuName">
                    </div>
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" class="form-control" id="link" name="link">
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
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
                        <select name="isActive" class="custom-select" id="isActive" name="isActive">
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSaveSubMenu" onclick="saveSubMenu()">Save changes</button>
            </div>
        </div>
    </div>
</div>