<select data-placeholder="Change Currency ..." class="chzn-select" style="width:300px;" tabindex="4" onchange="setcurrency(this.value);">
    <option value=""></option>
    <?php
    $currency  = Yii::app()->session['currency'];
        foreach($model as $row){
            ?>
                <option <?php if($currency==$row->currency_code) echo 'selected="selected"'; ?> value="<?php echo $row->currency_code; ?>"><?php echo $row->currency; ?>(<?php echo $row->currency_code; ?>)</option>
            <?php
        }
    ?>
</select>
<script type="text/javascript">
    function setcurrency(curr){
        $.get('<?php echo Yii::app()->baseUrl; ?>/currencymanager/default/setcurrency/currency/'+curr, function(data) {
            //console.log('done');
            <?php if($reloadgrid) { ?>
            reloadGrid();
            <?php } ?>
        });

    }
</script>