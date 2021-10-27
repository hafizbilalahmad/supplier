<?php $this->load->view('common/header.php');?>
<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script> -->

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<style>
    .Charts {
        width: 100%;
        height: 500px;
    }
</style>

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
                <label class="red_headings">Filtering by region</label>
                <hr class="red_bold_line">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 ">
                <p class="black_bold">What's your state</p>
                <select class="form-control col-sm-4" name="state" id="company_state" disabled>
                    <?php foreach ($states as $key => $state) {  ?>
                        <option value="<?=$state['id']?>" <?= ($state['id'] == $selected_state) ? "selected" : ''; ?> > <?=$state['state_name']?> </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <button class="btn btn-primary" id="btnPrint" >Export To PDF</button>
            </div>
        </div>
        <div class="row" id="graph_content">

            <?php foreach ($materials as $key => $value) {?>
                <?php if(isset($value['graph_data']) && !empty($value['graph_data'])){ ?>

                        <div id="<?= 'chartContainer'.$value['id']; ?>" style="height: 200px; width: 100%;margin-top:3%;"></div>

            <?php } } ?>

        </div>
    </div>
</div>
<script type="text/javascript">

window.onload = function () {
    <?php foreach ($materials as $key => $value) {?>
        var chart = new CanvasJS.Chart("<?= 'chartContainer'.$value['id'] ?>", {
    		title:{
    			text: "<?= $value['material_name'] ?>"
    		},
    		data: [
    		{
    			// Change type to "doughnut", "line", "splineArea", etc.
    			type: "column",
    			dataPoints: [
                    <?php if(isset($value['graph_data']) && !empty($value['graph_data'])){ ?>
                    <?php foreach ($value['graph_data'] as $key1 => $supplier) {?>
                        <?php if($supplier['count_of_rows'] > 0){ ?>
                        { label: "<?=$supplier['name'] ?>",  y: <?=$supplier['count_of_rows'] ?>  },
                    <?php } } } ?>
    				// { label: "grey", y: 15  },
    				// { label: "grey", y: 25  },
    				// { label: "grey",  y: 30  },
    				// { label: "grey",  y: 28  }
    			]
    		}
    		]
    	});
    	chart.render();

    <?php } ?>
    // document.getElementById("printChart").addEventListener("click",function(){
    //     // contnet.printElement();
    //     $("#contnet").printElement();
    // });
	// var chart = new CanvasJS.Chart("chartContainer1", {
	// 	title:{
	// 		text: "My First Chart in CanvasJS"
	// 	},
	// 	data: [
	// 	{
	// 		// Change type to "doughnut", "line", "splineArea", etc.
	// 		type: "column",
	// 		dataPoints: [
	// 			{ label: "grey",  y: 10  },
	// 			{ label: "grey", y: 15  },
	// 			{ label: "grey", y: 25  },
	// 			{ label: "grey",  y: 30  },
	// 			{ label: "grey",  y: 28  }
	// 		]
	// 	}
	// 	]
	// });
	// chart.render();

}
$('#btnPrint').on('click', function(event) {
        event.preventDefault();
        html2canvas($('#graph_content'), {
            onrendered: function(canvas) {
                // var imgData = canvas.toDataURL('image/jpeg');
                var imgData = canvas.toDataURL();
                var doc = new jsPDF('landscape');
                // const doc = new jsPDF("l", "mm", "a0"); //  use a4 for smaller page

                // doc.addImage(imgData, 'JPEG', 15, 45, 270, 125);
                doc.addImage(imgData, 'JPEG', 10, 20, 270, 125);
                doc.save('grapgh.pdf');
                return false;
            }
        });

        // debugger;
        // var doc = new jsPDF();  //create jsPDF object
        //  doc.fromHTML(document.getElementById("graph_content"), // page element which you want to print as PDF
        //  15,
        //  15,
        //  {
        //    'width': 170  //set width
        //  },
        //  function(a)
        //   {
        //    doc.save("HTML2PDF.pdf"); // save file name as HTML2PDF.pdf
        //  });


    });

</script>
<?php $this->load->view('common/footer.php'); ?>
