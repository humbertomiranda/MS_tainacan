<?php

class RadioClass extends FormItem{
    public function generate($compound,$property,$item_id,$index_id) {
        $compound_id = $compound['id'];
        $property_id = $property['id'];
        if ($property_id == 0) {
            $property = $compound;
        }
        $this->isRequired = ($property['metas'] && $property['metas']['socialdb_property_required'] && $property['metas']['socialdb_property_required'] != 'false') ? true : false;
        ?>
        <?php if ($this->isRequired): ?> 
        <div class="form-group" 
             id="validation-<?php echo $compound['id'] ?>-<?php echo $property_id ?>-<?php echo $index_id; ?>"
             style="border-bottom:none;"> 
                <?php endif; ?>
                <?php if($property['has_children'] && is_array($property['has_children'])): ?>
                    <?php foreach ($property['has_children'] as $child): ?>
                        <input type="radio"
                               name="radio-field-<?php echo $compound_id ?>-<?php echo $property_id ?>-<?php echo $index_id; ?>[]"
                               value="<?php echo $child->term_id ?>">&nbsp;<?php echo $child->name ?>
                    <?php endforeach; ?>      
                <?php endif;
        if ($this->isRequired): ?> 
                <span style="display: none;" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                <span id="input2Status" class="sr-only">(status)</span>
                <input type="hidden" 
                       <?php if($property_id !== 0): ?>
                       compound="<?php echo $compound['id'] ?>"
                       <?php endif; ?>
                      property="<?php echo $property['id'] ?>"
                       class="validate-class validate-compound-<?php echo $compound['id'] ?>"
                       value="false">
        </div> 
        <?php elseif($property_id !== 0): ?> 
        <input  type="hidden" 
                compound="<?php echo $compound['id'] ?>"
                property="<?php echo $property['id'] ?>"
                id="validation-<?php echo $compound['id'] ?>-<?php echo $property_id ?>-<?php echo $index_id; ?>"
                class="compound-one-field-should-be-filled-<?php echo $compound['id'] ?>"
                value="false">
        <?php endif;         
        $this->initScriptsRadioBoxClass($compound_id, $property_id, $item_id, $index_id);
    }

    /**
     * 
     * @param type $property
     * @param type $item_id
     * @param type $index
     */
    public function initScriptsRadioBoxClass($compound_id,$property_id, $item_id, $index_id) {
        ?>
        <script>
            $('input[name="radio-field-<?php echo $compound_id ?>-<?php echo $property_id ?>-<?php echo $index_id; ?>[]"]').change(function(){
                $.ajax({
                    url: $('#src').val() + '/controllers/object/form_item_controller.php',
                    type: 'POST',
                    data: {
                        operation: 'saveValue',
                        type:'term',
                        value: $(this).val(),
                        item_id:'<?php echo $item_id ?>',
                        compound_id:'<?php echo $compound_id ?>',
                        property_children_id: '<?php echo $property_id ?>',
                        index: <?php echo $index_id ?>,
                        indexCoumpound: 0
                    }
                });
                <?php if($this->isRequired):  ?>
                    validateFieldsMetadataText($(this).val(),'<?php echo $compound_id ?>','<?php echo $property_id ?>','<?php echo $index_id ?>')
                <?php endif; ?>
            });
        </script>
        <?php
    }
}
