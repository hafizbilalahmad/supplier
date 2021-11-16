<?php $this->load->view('common/header.php'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">

        <div class="row">
            <div class="col-lg-12">
                <h1>Suppliers</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <label>Add Supplier Materials Of State</label>
            </div>
        </div>

        <!-- state -->
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
                <p class="black_bold">State</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <p class="black_bold">Select State</p>
                <select class="form-control col-sm-8" name="state" id="select_states">
                    <option value="" disabled selected> Select State </option>
                    <?php foreach ($states as $key => $state) {  ?>
                        <option value="<?=$state['id']?>"> <?=$state['state_name']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4"></div>
        </div><br>

        <!-- supplier -->
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
                <p class="black_bold">Supplier</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <p class="black_bold">Select Supplier</p>
                <select class="form-control col-sm-8" name="supplier" id="select_suppliers">
                    <option value="" disabled selected> Select Supplier </option>
                    <?php foreach ($suppliers as $key => $supplier) {  ?>
                        <option value="<?=$supplier['id']?>"> <?=$supplier['name']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4"></div>
        </div><br>

        <!-- materials -->
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
                <p class="black_bold">Materials</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <p class="black_bold">Select Materials</p>
                <select class="form-control col-sm-8" name="material" id="select_materials">
                    <option value="" disabled selected> Select Materials </option>
                    <?php foreach ($materials as $key => $material) {  ?>
                        <option value="<?=$material['id']?>"> <?=$material['material_name']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4"></div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <input type="button" onclick="add_supplier_material_relation()" name="add_supplier_material_btn" value="Add Relation" class="btn btn-success floatRight">
            </div>
        </div>

    </div>
</div>
<?php $this->load->view('common/footer.php'); ?>
<script>
    function add_supplier_material_relation(){
        // debugger
        let state_id = $('#select_states').val();
        let supplier_id = $('#select_suppliers').val();
        let material_id = $('#select_materials').val();
        if(state_id == undefined || supplier_id == undefined || material_id == undefined){
            alert("Please select all");
            return;
        }
        let api_url = $('#my_site_url').val() + '/supplier/add_supplier_material_relation';
    	$.ajax({
    		type: "post",
    		url: api_url,
            data:{
                'state_id':state_id,
                'supplier_id':supplier_id,
                'material_id':material_id
            },
    		success: function (response) {
                let state_name = $('#select_states option:selected').text();
                let supplier_name = $('#select_suppliers option:selected').text();
                let material_name = $('#select_materials option:selected').text();
    			alert("Inserted supplier "+supplier_name+" for material "+material_name+" and state "+state_name);
    		},
    		error: function () {
                alert("fail");
    			// show_error('Error', 'An error occured, Please try again later');
    		}
    	});
    }
</script>
