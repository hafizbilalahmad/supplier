<?php $this->load->view('common/header.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <input type="hidden" id="hidden_supplier_count" value="<?=$materials_count?>" />
        <div class="row">
            <div class="col-lg-12">
                <h1>Guia de Fornecedores</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <label>Conheça os fornecedores mais utilizados na sua região</label>
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
                    <p class="black_bold">Estado:</p>
                    <select class="form-control col-sm-4" name="state" id="company_state" disabled>
                        <?php foreach ($states as $key => $state) {  ?>
                            <option value="<?=$state['id']?>" <?= ($state['id'] == $selected_state) ? "selected" : ''; ?> > <?=$state['state_name']?> </option>
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
                            <option value="" selected>Fornecedor</option>
                        <?php foreach ($suppliers as $key => $supplier): ?>
                                <option value="<?= $supplier['id'] ?>"> <?= $supplier['name'] ?> </option>
                        <?php endforeach; ?>
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
    // $('#add_supplier_form').submit(function(e) {
    //     $(':disabled').each(function(e) {
    //         $(this).removeAttr('disabled');
    //     })
    // });

</script>
