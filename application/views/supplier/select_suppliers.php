<?php $this->load->view('common/header.php'); ?>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
// function googleTranslateElementInit() {
//   new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
// }
</script>
<div id="google_translate_element"></div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <input type="hidden" id="hidden_supplier_count" value="<?=$materials_count?>" />
        <div class="row">
            <div class="col-lg-12">
                <h1><?=$this->lang->line("msg_main_heading")?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <label><?=$this->lang->line("msg_label_under_main_heading")?></label>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 ">
                <label class="red_headings">Filtrando por região</label>
                <hr class="red_bold_line">
            </div>
        </div>

        <form id="add_supplier_form" action="<?= site_url('supplier/save_suppliers_info'); ?>" method="post" autocomplete="on">

            <div class="row">
                <div class="col-lg-12 ">
                    <p class="black_bold">City:</p>
                    <select class="form-control col-sm-4" name="city" id="company_city" disabled>
                        <?php foreach ($cities as $key => $city) {  ?>
                            <option value="<?=$city['id']?>" <?= ($city['id'] == $selected_city_id) ? "selected" : ''; ?> > <?=$city['city_name']?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 ">
                    <label class="red_headings">Selecione os fornecedores que você utiliza </label>
                    <!-- <input type="button" name="" class="btn btn-primary floatRight" value="Add Supplier" onclick="add_new_supplier()"> -->
					<div class="col-lg-12">
                <label>Vamos calcular a média de mercado e apresentar na próxima tela</label>
            </div>
                    <hr class="red_bold_line">
                </div>
            </div>


            <div class="row" id="supplier_row">
                <?php foreach ($materials as $key => $material) {?>
                    <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:2%;">
                        <label class="black_bold"> <?=$material['material_name'] ?></label>
                        <select class="form-control col-10 supplier_class[]" name="<?= 'suppliers['.$material['id'].']' ?>">
                            <option value="" selected><?=$material['material_name'] ?> Fornecedor</option>
                            <?php if(isset($material['suppliers'])) {?>
                        <?php foreach ($material['suppliers'] as $supplier_key => $supplier): ?>
                                <option value="<?= $supplier['id'] ?>"> <?= $supplier['name'] ?> </option>
                        <?php endforeach; ?>
                    <?php } ?>
                        </select>
                        <br>
                        <input type="text" name="<?='other_unlisted['.$material['id'].']'?>" class="form-control col-10 other_unlisted" value="" placeholder="another unlisted">
                    </div>
                <?php } ?>

            </div>
            <input type="button" name="add_suppliers" id="add_state_material_supplier_btn" onclick="verify_selected()" class="btn btn-success floatRight" value="Avançar">
        </form>

    </div>
</div>
<?php $this->load->view('common/footer.php'); ?>

<script>
    function verify_selected(){
        //check if all inputs are empty
        var check_input = 1;
        var valueArray = $('.other_unlisted').map(function() {
            if(this.value != ''){
                check_input = 0;
            }
        }).get();

        // let sel = [];
        //check if no select is selected
        let check = 1;
        $("#supplier_row select").each(function() {
            // sel.push( $(this).val());
            if($(this).val() != ''){
                check = 0;
            }
        });

        //if both are empty, show message to enter atleast one value
        if(check && check_input){
            alert("Please select/enter atleaset one value");
            return;
        }

        $(':disabled').each(function(e) {
            $(this).removeAttr('disabled');
        })
        var button = document.getElementById('add_state_material_supplier_btn');
        button.form.submit();
    }


</script>
