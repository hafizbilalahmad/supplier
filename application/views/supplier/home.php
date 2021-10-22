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
                <label>List of most used suppliers in your region</label>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 ">
                <label class="red_headings">Understanding your company</label>
                <hr class="red_bold_line">
            </div>
        </div>

        <form class="" action="<?= site_url('supplier/add_potiental_information'); ?>" method="post">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold">How many employees <br> does your company have <br> in the adminitrative area?</p>
                    <input type="number" id="num_of_employess" name="num_of_employess" class="form-control col-sm-6" value="1">
                    <div id="num_of_employess_validation" hidden>
                        <br>
                        <label style="color:red;"> Please enter valid number of employees </label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold">How big do you think <br> your company is?</p>

                    <label class="radio-inline"><input type="radio" name="company_status" value="pequena" checked> Pequena &nbsp&nbsp</label>
                    <label class="radio-inline"><input type="radio" name="company_status" value="media"> Media &nbsp&nbsp</label>
                    <label class="radio-inline"><input type="radio" name="company_status" value="grande"> Grande &nbsp&nbsp</label>

                </div>
            </div><br><br>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold">Does your company use <br>seperate spreadsheets by<br>area or does it already have<br>
                        a management system?
                    </p>
                    <label class="radio-inline"><input type="radio" name="company_system" value="planilhas" checked> Planilhas &nbsp&nbsp</label>
                    <label class="radio-inline"><input type="radio" name="company_system" value="sistema_integrado"> Sistema integrado &nbsp&nbsp</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold">Which segment of your <br>company?</p>
                    <select class="form-control col-sm-8" name="segment" id="company_segment">
                        <option value="" disabled selected> Select Segment </option>
                        <?php foreach ($segments as $key => $segment) {  ?>
                            <option value="<?=$segment['segment_key']?>"> <?=$segment['segment_name']?></option>
                        <?php } ?>
                    </select>
                    <div id="company_segment_validation" hidden>
                        <br>
                        <label style="color:red;"> Please select segment </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 ">
                    <label class="red_headings">Filtering by region</label>
                    <hr class="red_bold_line">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 ">
                    <p class="black_bold">What's your state</p>
                    <select class="form-control col-sm-4" name="state" id="company_state">
                        <option value="" disabled selected> Select State </option>
                        <?php foreach ($states as $key => $state) {  ?>
                            <option value="<?=$state['id']?>"> <?=$state['state_name']?> </option>
                        <?php } ?>
                    </select>

                    <div id="company_state_validation" hidden>
                        <br>
                        <label style="color:red;"> Please select state </label>
                    </div>
                </div><br><br>
                <div class="col-lg-12 ">
                    <input type="button" value="Advance" onclick="validate_and_submit()" id="add_potiental_information_button" class="btn btn-success floatRight" >
                </div>

            </div>
        </form>

    </div>
</div>
<?php $this->load->view('common/footer.php'); ?>


<script>
function validate_and_submit(){
    var check = 0;
    if(!is_valid_employees()){
        $('#num_of_employess_validation').removeAttr('hidden');
        $('#num_of_employess_validation').show();
        // $('#num_of_employess').val('1');
        check = 1;
    }else{
        $('#num_of_employess_validation').hide();
    }
    let company_segment = $('#company_segment').val();
    if(!company_segment){
        $('#company_segment_validation').removeAttr('hidden');
        $('#company_segment_validation').show();
        check = 1;
    }else{
        $('#company_segment_validation').hide();
    }

    let company_state = $('#company_state').val();
    if(!company_state){
        $('#company_state_validation').removeAttr('hidden');
        $('#company_state_validation').show();
        check = 1;
    }else{
        $('#company_state_validation').hide();
    }

    if(check){
        return;
    }
    var button = document.getElementById('add_potiental_information_button');
    button.form.submit();


}

function is_valid_employees(){
    let num_of_employess = $('#num_of_employess').val();
    if(parseInt(num_of_employess) < 1 || !Number.isInteger(parseInt(num_of_employess))){
        return false;
    }
    return true;
}
</script>
