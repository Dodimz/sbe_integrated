<!-- Modal Master Module-->
<div class="modal fade" id="modalMasterModule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMasterModule">
                    <input type="hidden" id="idModule" class="idModule" name="idModule">
                    <div class="form-group">
                        <label for="moduleName">Module Name</label>
                        <input type="text" class="form-control" id="moduleName" name="moduleName">
                    </div>
                    <div class="form-group">
                        <label for="moduleDescription">Module Description</label>
                        <input type="text" class="form-control" id="moduleDescription" name="moduleDescription">
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
                        <select name="isActive" class="custom-select" id="isActive">
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="readonly">Readonly</label>
                        <select name="readonly" class="custom-select" id="readonly">
                            <option value="1">Y</option>
                            <option value="0">N</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSaveMasterModule" onclick="saveMasterModule()">Save changes</button>
            </div>
        </div>
    </div>
</div>