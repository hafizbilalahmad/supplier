<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/MyController.php");
class Supplier extends MyController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_model');
    }

    public function index(){
        // $data["language_msg"] = ;
        // show($data);
        $segments = $this->supplier_model->get_selected_value('id,segment_name,segment_key','segments',['is_deleted' => 0]);
        $states = $this->supplier_model->get_selected_value('id,state_name,state_key','states',['is_deleted' => 0]);
        $cities = $this->supplier_model->get_selected_value('id,city_name,city_key','cities',['is_deleted' => 0]);
        // show($cities);
        $path = 'supplier/home';
        $data['segments'] = $segments;
        $data['states'] = $states;
        $data['cities'] = $cities;
        $data['title'] = "Home";
        $this->load->view($path,$data);
    }

    public function get_cities(){
        $state_id = $this->input->post('state_id');
        $cities = $this->supplier_model->get_selected_value('id,city_name,city_key','cities',['is_deleted' => 0,'state_id' => $state_id]);
        echo json_encode($cities);
    }

    public function add_potiental_information(){
        // show($_POST);
        $data['number_of_employees'] = $this->input->post('num_of_employess');
        $data['company_status'] = $this->input->post('company_status');
        $data['company_system'] = $this->input->post('company_system');
        $data['segment'] = $this->input->post('segment');
        // $selected_state = $this->input->post('state');
        $selected_city_id = $this->input->post('city');
        //insertion of potiental data
        $insert_id = $this->supplier_model->insert_value('company_details',$data);

        //states for dropwdown
        // $states = $this->supplier_model->get_selected_value('id,state_name,state_key','states',['is_deleted' => 0]);
        $cities = $this->supplier_model->get_selected_value('id,city_name,city_key','cities',['is_deleted' => 0]);

        //get all supppliers of selected state
        // $suppliers = $this->supplier_model->get_selected_value('*','suppliers',['is_deleted' => 0,'state_id' => $selected_state],'material_id');
        $suppliers = $this->supplier_model->get_selected_value('*','suppliers',['is_deleted' => 0,'city_id' => $selected_city_id],'material_id');

        //filter supplier data bt material id
        if(count($suppliers) > 0){
            $suppliers = set_subarray_multiple_index_by_coulnm_value($suppliers,'material_id');
        }

        //getting all materials
        $materials = $this->supplier_model->get_selected_value('id,material_name','materials',['is_deleted' => 0]);
        //setting above material suppliers data with respect to each material
        foreach ($materials as $key => $value) {
            if(isset($suppliers[$value['id']])){
                $materials[$key]['suppliers'] = $suppliers[$value['id']];
            }
        }

        // $data['states'] = $states;
        $data['cities'] = $cities;
        $data['selected_city_id'] = $selected_city_id;
        $data['materials'] = $materials;
        $data['materials_count'] = count($materials);
        $data['title'] = "Suppliers";
        $path = 'supplier/select_suppliers';
        // show($data);
        $this->load->view($path,$data);
    }

    public function save_suppliers_info(){
        // $state_id = $this->input->post('state');
        $city_id = $this->input->post('city');
        $suppliers = $this->input->post('suppliers');
        $other_unlisted = $this->input->post('other_unlisted');

        $count = 0;
        //save only those material ids which are selected on previous page in form of array
        $materials_material_ids = [];
        //save only those material ids which are selected on previous page in like 1,2,4
        $graph_material_ids = '';


        foreach ($suppliers as $material_id => $supplier_id) {

            if(empty($supplier_id) && empty($other_unlisted[$material_id])){
                continue;
            }

            $graph_material_ids .= $material_id.',';
            $materials_material_ids[$count] = $material_id;

                // $mydata[$count]['state_id'] = $state_id;
                $mydata[$count]['city_id'] = $city_id;
                $mydata[$count]['material_id'] = $material_id;

                //prefernce is given to input feild
                //so if input feild contain some data a new supplier will be created
                if(empty($other_unlisted[$material_id])){
                    $mydata[$count]['supplier_id'] = $supplier_id;
                }else{
                    // $new_supplier_data['state_id'] = $state_id;
                    $new_supplier_data['city_id'] = $city_id;
                    $new_supplier_data['material_id'] = $material_id;
                    $new_supplier_data['name'] = $other_unlisted[$material_id];
                    $inserted_supplier_id = $this->insert_new_supplier($new_supplier_data);
                    $mydata[$count]['supplier_id'] = $inserted_supplier_id;
                }

                $count++;
        }
        //removing the last comma
        $graph_material_ids =rtrim($graph_material_ids, ',');
        //inserting the data collectively
        $this->supplier_model->insert_data_in_bulk('supplier_material',$mydata);

        //states for dropdown
        $cities = $this->supplier_model->get_selected_value('id,city_name,city_key','cities',['is_deleted' => 0]);
        // $states = $this->supplier_model->get_selected_value('id,state_name,state_key','states',['is_deleted' => 0]);
        $data['cities'] = $cities;

        //getting only those materials which was selected on previous page
        $materials = $this->supplier_model->get_value_where_and_wherein('materials',['is_deleted' => 0],'id',$materials_material_ids);

        //this is for sql group by issue, we have to run this query before we run below get_graph_data
        // $sql_group_by_issue = $this->supplier_model->SQL_MODE_FULL_GROUP_BY_QUERY();
        //all grapgh data filter by state and material id and group by suppliers
        $graph_data = $this->supplier_model->get_graph_data($city_id,$graph_material_ids);
        $graph_data = set_subarray_multiple_index_by_coulnm_value($graph_data,'material_id');

        //combining grapgh data with each respective material
        foreach ($materials as $key => $material) {
            if(isset($graph_data[$material['id']])){
                $materials[$key]['graph_data'] = $graph_data[$material['id']];
            }

        }

        // $count_of_suppliers = $this->supplier_model->get_supplier_count_of_materials_by_state_id($state_id,$my_material_ids);
        $data['selected_city_id'] = $this->input->post('city');
        $data['title'] = "Graph";
        $data['materials'] = $materials;
        $path = 'supplier/display_graph';
        $this->load->view($path,$data);
    }

    private function insert_new_supplier($new_supplier_data){
        $supplier_insert_id = $this->supplier_model->insert_value('suppliers',$new_supplier_data);
        return $supplier_insert_id;
    }

    public function add_supplier_material(){

        $states = $this->supplier_model->get_selected_value('id,state_name,state_key','states',['is_deleted' => 0]);
        $suppliers = $this->supplier_model->get_selected_value('id,name','suppliers',['is_deleted' => 0]);
        $materials = $this->supplier_model->get_selected_value('id,material_name','materials',['is_deleted' => 0]);

        $data['states'] = $states;
        $data['suppliers'] = $suppliers;
        $data['materials'] = $materials;
        $data['title'] = "Add Supplier";
        $path = 'supplier/add_supplier_material';
        $this->load->view($path,$data);
    }
    public function add_supplier_material_relation(){
        show($_POST);
        $data['state_id'] = $this->input->post('state_id');
        $data['supplier_id'] = $this->input->post('supplier_id');
        $data['material_id'] = $this->input->post('material_id');
        $insert_id = $this->supplier_model->insert_value('supplier_material',$data);
        return $insert_id;
    }

}
