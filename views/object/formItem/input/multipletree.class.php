<?php

class MultipleTreeClass extends FormItem {

    public function generate($compound, $property, $item_id, $index_id) {
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
                <div class="row">
                    <div style='height: 150px;'
                         class='col-lg-12'
                         id='multiple-<?php echo $compound_id ?>-<?php echo $property_id ?>-<?php echo $index_id; ?>'>
                    </div>
                </div>
                <?php if ($this->isRequired): ?> 
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
        if ($property['has_children'] && is_array($property['has_children']))
            $this->initScriptsMultipleTreeClass($compound_id, $property_id, $item_id, $index_id, $property['has_children']);
    }

    /**
     *
     * @param type $property
     * @param type $item_id
     * @param type $index
     */
    public function initScriptsMultipleTreeClass($compound_id, $property_id, $item_id, $index_id, $children) {
        ?>
        <script>
            $("#multiple-<?php echo $compound_id ?>-<?php echo $property_id ?>-<?php echo $index_id; ?>").dynatree({
                selectionVisible: true, // Make sure, selected nodes are visible (expanded).
                checkbox: true,
                children: <?php echo $this->generateJson($children) ?>,
                onLazyRead: function (node) {
                    node.appendAjax({
                        url: $('#src').val() + '/controllers/collection/collection_controller.php',
                        data: {
                            collection: $("#collection_id").val(),
                            key: node.data.key,
                            classCss: node.data.addClass,
                            //operation: 'findDynatreeChild'
                            operation: 'expand_dynatree'
                        }
                    });
                },
                onSelect: function (flag, node) {
                    if (node.bSelected) {
                        $.ajax({
                            url: $('#src').val() + '/controllers/object/form_item_controller.php',
                            type: 'POST',
                            data: {
                                operation: 'saveValue',
                                type: 'term',
                                value: node.data.key,
                                item_id: '<?php echo $item_id ?>',
                                compound_id: '<?php echo $compound_id ?>',
                                property_children_id: '<?php echo $property_id ?>',
                                index: <?php echo $index_id ?>
                            }
                        });
                    } else {
                        $.ajax({
                            url: $('#src').val() + '/controllers/object/form_item_controller.php',
                            type: 'POST',
                            data: {
                                operation: 'removeValue',
                                type: 'term',
                                value: node.data.key,
                                item_id: '<?php echo $item_id ?>',
                                compound_id: '<?php echo $compound_id ?>',
                                property_children_id: '<?php echo $property_id ?>',
                                index: <?php echo $index_id ?>
                            }
                        });
                    }
                    var selKeys = $.map(node.tree.getSelectedNodes(), function (node) {
                        return node;
                    });
                    if(selKeys.length > 0){
                        validateFieldsMetadataText('true','<?php echo $compound_id ?>','<?php echo $property_id ?>','<?php echo $index_id ?>');
                    }else{
                        validateFieldsMetadataText('','<?php echo $compound_id ?>','<?php echo $property_id ?>','<?php echo $index_id ?>');
                    }
                }
            });
        </script>
        <?php
    }

    public function generateJson($array) {
        foreach ($array as $term) {
            if (mb_detect_encoding($term->name) == 'UTF-8' || mb_detect_encoding($term->name) == 'ASCII') {
                $dynatree[] = array('title' => ucfirst(Words($term->name, 30)), 'key' => $key, 'isLazy' => true, 'expand' => true, 'addClass' => 'color1');
            } else {
                $dynatree[] = array('title' => ucfirst(Words(utf8_decode(utf8_encode($term->name)), 30)), 'key' => $term->term_id, 'isLazy' => true, 'expand' => true, 'addClass' => 'color1');
            }
        }
        return json_encode($dynatree);
    }

}
