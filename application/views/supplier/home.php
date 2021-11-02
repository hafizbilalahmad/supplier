<?php $this->load->view('common/header.php');?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">

        <div class="row">
            <div class="col-lg-10">
                <!-- <h1>Guia de Fornecedores</h1> -->
                <label>Select Language</label>
            </div>
            <div class="col-lg-10">
                <a href="<?= base_url('myController/change_language/english'); ?>">English</a>
                <a href="<?= base_url('myController/change_language/portuguese'); ?>">Portuguese</a>
            </div>
        </div>

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
                <label class="red_headings"><?=$this->lang->line("msg_info_company")?></label>
                <hr class="red_bold_line">
            </div>
        </div>

        <form class="" action="<?= site_url('supplier/add_potiental_information'); ?>" method="post">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold"><?=$this->lang->line("msg_number_of_employees")?></p>
                    <input type="number" id="num_of_employess" name="num_of_employess" class="form-control col-sm-6" value="1">
                    <div id="num_of_employess_validation" hidden>
                        <br>
<<<<<<< Updated upstream
                        <label style="color:red;"> Please enter valid number of employees </label>
=======
                        <label style="color:red;"> <?=$this->lang->line("msg_number_of_employees_error")?> </label>
>>>>>>> Stashed changes
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold"><?=$this->lang->line("msg_company_status")?></p>

                    <label class="radio-inline"><input type="radio" name="company_status" value="pequena" checked> <?=$this->lang->line("msg_company_status_small")?> &nbsp&nbsp</label>
                    <label class="radio-inline"><input type="radio" name="company_status" value="media"> <?=$this->lang->line("msg_company_status_average")?> &nbsp&nbsp</label>
                    <label class="radio-inline"><input type="radio" name="company_status" value="grande"> <?=$this->lang->line("msg_company_status_great")?> &nbsp&nbsp</label>

                </div>
            </div><br><br>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold"><?=$this->lang->line("msg_company_management")?></p>
                    <label class="radio-inline"><input type="radio" name="company_system" value="planilhas" checked> <?=$this->lang->line("msg_company_management_spreadsheet")?> &nbsp&nbsp</label>
                    <label class="radio-inline"><input type="radio" name="company_system" value="sistema_integrado"> <?=$this->lang->line("msg_company_management_integrated")?> &nbsp&nbsp</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold"><?=$this->lang->line("msg_company_segment")?></p>
                    <select class="form-control col-sm-8" name="segment" id="company_segment">
                        <option value="" disabled selected> <?=$this->lang->line("msg_select_segment")?> </option>
                        <?php foreach ($segments as $key => $segment) {  ?>
                            <option value="<?=$segment['segment_key']?>"> <?=$segment['segment_name']?></option>
                        <?php } ?>
                    </select>
                    <div id="company_segment_validation" hidden>
                        <br>
                        <label style="color:red;"> <?=$this->lang->line("msg_company_segment_error")?> </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 ">
                    <label class="red_headings"><?=$this->lang->line("msg_state_select")?></label>
                    <hr class="red_bold_line">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 ">
                    <p class="black_bold"><?=$this->lang->line("msg_state")?></p>
                    <select class="form-control col-sm-4" name="state" id="company_state">
                        <option value="" disabled selected> <?=$this->lang->line("msg_select_state")?> </option>
                        <?php foreach ($states as $key => $state) {  ?>
                            <option value="<?=$state['id']?>"> <?=$state['state_name']?> </option>
                        <?php } ?>
                    </select>

                    <div id="company_state_validation" hidden>
                        <br>
                        <label style="color:red;"> <?=$this->lang->line("msg_state_select_error")?> </label>
                    </div>
                </div><br><br>
                <div class="col-lg-12 ">
                    <input type="button" value="<?=$this->lang->line("msg_advance_button")?>" onclick="validate_and_submit()" id="add_potiental_information_button" class="btn btn-success floatRight" >
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
