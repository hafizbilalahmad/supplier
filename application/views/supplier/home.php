<?php $this->load->view('common/header.php'); ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">

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
                <label class="red_headings">Informações sobre a sua empresa:</label>
                <hr class="red_bold_line">
            </div>
        </div>

        <form class="" action="<?= site_url('supplier/add_potiental_information'); ?>" method="post">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold">Quantos funcionários há na sua empresa <br>nas áreas de Engenharia, Compras, Financeiro, <br>Administrativo e Comercial?</p>
                    <input type="number" id="num_of_employess" name="num_of_employess" class="form-control col-sm-6" value="1">
                    <div id="num_of_employess_validation" hidden>
                        <br>
                        <label style="color:red;"> Por favor, insira um número válido de funcionários </label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold">Qual é o porte da sua empresa?</p>

                    <label class="radio-inline"><input type="radio" name="company_status" value="pequena" checked> Pequena &nbsp&nbsp</label>
                    <label class="radio-inline"><input type="radio" name="company_status" value="media"> Media &nbsp&nbsp</label>
                    <label class="radio-inline"><input type="radio" name="company_status" value="grande"> Grande &nbsp&nbsp</label>

                </div>
            </div><br><br>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold">Sua empresa usa planilhas separadas por<br>área ou já possui um sistema de gestão?</p>
                    <label class="radio-inline"><input type="radio" name="company_system" value="planilhas" checked> Planilhas &nbsp&nbsp</label>
                    <label class="radio-inline"><input type="radio" name="company_system" value="sistema_integrado"> Sistema integrado &nbsp&nbsp</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="black_bold">Qual é o segmento da sua empresa?</p>
                    <select class="form-control col-sm-8" name="segment" id="company_segment">
                        <option value="" disabled selected> Selecionar Segmento </option>
                        <?php foreach ($segments as $key => $segment) {  ?>
                            <option value="<?=$segment['segment_key']?>"> <?=$segment['segment_name']?></option>
                        <?php } ?>
                    </select>
                    <div id="company_segment_validation" hidden>
                        <br>
                        <label style="color:red;"> Selecione um segmento </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 ">
                    <label class="red_headings">Selecione o seu estado:</label>
                    <hr class="red_bold_line">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 ">
                    <p class="black_bold">Estado</p>
                    <select class="form-control col-sm-6" name="state" id="company_state" onchange="get_cities(this.value);">
                        <option value="" disabled selected> Selecionar Estado </option>
                        <?php foreach ($states as $key => $state) {  ?>
                            <option value="<?=$state['id']?>"> <?=$state['state_name']?> </option>
                        <?php } ?>
                    </select>

                    <div id="company_state_validation" hidden>
                        <br>
                        <label style="color:red;"> Selecione o Estado </label>
                    </div>
                </div>

                <div class="col-lg-6 ">
                    <p class="black_bold">Cities</p>

                    <div onclick="select_state_validation()" id="company_city_div">
                        <select class="form-control col-sm-6" name="city" id="company_city" disabled >
                            <option value="" disabled selected> Select City </option>
                            <!-- <?php foreach ($cities as $key => $city) {  ?> -->
                            <!-- <option value="<?=$city['id']?>"> <?=$city['city_name']?> </option> -->
                            <!-- <?php } ?> -->
                        </select>
                    </div>

                    <div id="company_city_validation" hidden>
                        <br>
                        <label style="color:red;"> Selecione uma cidade </label>
                    </div>
                </div><br><br>
                <div class="col-lg-12 ">
                    <input type="button" value="Avançar" onclick="validate_and_submit()" id="add_potiental_information_button" class="btn btn-success floatRight" >
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

    let company_city = $('#company_city').val();
    if(!company_city){
        $('#company_city_validation').removeAttr('hidden');
        $('#company_city_validation').show();
        check = 1;
    }else{
        $('#company_city_validation').hide();
    }

    if(check){
        return;
    }
    var button = document.getElementById('add_potiental_information_button');
    button.form.submit();


}
function select_state_validation(){
    alert("Please select a state fist");
}
function is_valid_employees(){
    let num_of_employess = $('#num_of_employess').val();
    if(parseInt(num_of_employess) < 1 || !Number.isInteger(parseInt(num_of_employess))){
        return false;
    }
    return true;
}

function get_cities(state_id){
    let api_url = $('#my_site_url').val() + '/supplier/get_cities';
    $.ajax({
        type: "post",
        url: api_url,
        data:{
            'state_id':state_id
        },
        success: function (response) {
            var cities = $.parseJSON(response);
            $('#company_city').removeAttr('disabled');
            $('#company_city_div').prop("onclick", null).off("click");
            $('#company_city').html('');

            let state_name = $('#company_state option:selected').text();

            selOpts = "<option value='' selected disabled>Select "+state_name+" City</option>";
            for (i=0;i<cities.length;i++)
            {
                var id = cities[i]['id'];
                var name = cities[i]['city_name'];
                selOpts += "<option value='"+id+"'>"+name+"</option>";
            }
            $('#company_city').append(selOpts);
        },
        error: function () {
            alert("fail");
        }
    });
}
</script>
