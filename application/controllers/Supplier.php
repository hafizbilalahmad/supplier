<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/MyController.php");
class Supplier extends MyController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('supplier_model');
        // $this->load->library('encryption');
    }

    public function index(){
        // $data["language_msg"] = ;
        // show($data);
        $segments = $this->supplier_model->get_selected_value('id,segment_name,segment_key','segments',['is_deleted' => 0]);
        $states = $this->supplier_model->get_selected_value('id,state_name,state_key','states',['is_deleted' => 0]);
        // show($states);
        $path = 'supplier/home';
        $data['segments'] = $segments;
        $data['states'] = $states;
        $data['title'] = "Home";
        $this->load->view($path,$data);
    }

    public function add_potiental_information(){
        $data['number_of_employees'] = $this->input->post('num_of_employess');
        $data['company_status'] = $this->input->post('company_status');
        $data['company_system'] = $this->input->post('company_system');
        $data['segment'] = $this->input->post('segment');
        $selected_state = $this->input->post('state');
        $insert_id = "";
        // if( empty( $this->session->userdata('id') )){
            // $insert_id = $this->supplier_model->insert_value('company_details',$data);
        // }
        // if($insert_id){
            // $this->eio_seekesseeion->set_userdata('id', $insert_id);
        // }

        //states for dropwdown
        $states = $this->supplier_model->get_selected_value('id,state_name,state_key','states',['is_deleted' => 0]);

        //fetching the realtions of state material and supplier
        // $relations = $this->supplier_model->get_value('supplier_material',['state_id' => $selected_state],'material_id');

        //setting the index of relations with respect to material ids
        // if(count($relations) > 0){
            // $relations = set_subarray_multiple_index_by_coulnm_value($relations,'material_id');
        // }

        $suppliers = $this->supplier_model->get_selected_value('id,name','suppliers',['is_deleted' => 0]);
        // if(count($suppliers) > 0){
        //     $suppliers = set_subarrays_index_by_column_value($suppliers,'id');
        // }

        $materials = $this->supplier_model->get_selected_value('id,material_name','materials',['is_deleted' => 0]);
        // if(count($materials) > 0){
        //     $materials = set_subarrays_index_by_column_value($materials,'id');
        // }

        // foreach ($relations as $key => $relation) {
        //     foreach ($relation as $key1 => $value) {
        //         if(isset($suppliers[$value['supplier_id']])){
        //             $relations[$key][$key1]['supplier_name'] = $suppliers[$value['supplier_id']]['name'];
        //         }
        //
        //     }
        // }
        //
        // foreach ($materials as $key => $material) {
        //     if(isset($relations[$key])){
        //         $materials[$key]['material_suppliers'] = $relations[$key];
        //     }
        // }
        // show($materials,'$materials',1);

        $data['states'] = $states;
        $data['selected_state'] = $selected_state;
        $data['materials'] = $materials;
        $data['suppliers'] = $suppliers;
        $data['materials_count'] = count($materials);
        $data['title'] = "Suppliers";
        $path = 'supplier/select_suppliers';
        $this->load->view($path,$data);
    }

    public function save_suppliers_info(){
        // show($_POST);
        $state_id = $this->input->post('state');
        $suppliers = $this->input->post('suppliers');
        $other_unlisted = $this->input->post('other_unlisted');

        $count = 0;
        $my_material_ids = [];

        foreach ($suppliers as $material_id => $supplier_id) {
            if(empty($supplier_id) && empty($other_unlisted[$material_id])){
                continue;
            }

            // $my_material_ids .= $material_id.',';
            $my_material_ids[$count] = $material_id;

                $mydata[$count]['state_id'] = $state_id;
                $mydata[$count]['material_id'] = $material_id;

                if(empty($other_unlisted[$material_id])){
                    $mydata[$count]['supplier_id'] = $supplier_id;
                }else{
                    $new_supplier_data['state_id'] = $state_id;
                    $new_supplier_data['name'] = $other_unlisted[$material_id];
                    $inserted_supplier_id = $this->insert_new_supplier($new_supplier_data);

                    // $new_relation['state_id'] = $state_id;
                    // $new_relation['supplier_id'] = $inserted_supplier_id;
                    // $new_relation['material_id'] = $material_id;
                    // $this->add_new_relation($new_relation);

                    $mydata[$count]['supplier_id'] = $inserted_supplier_id;
                }

                $count++;
        }
        // $my_material_ids =rtrim($my_material_ids, ',');
        $this->supplier_model->insert_data_in_bulk('supplier_material',$mydata);
        // show($mydata);

        $states = $this->supplier_model->get_selected_value('id,state_name,state_key','states',['is_deleted' => 0]);
        $data['states'] = $states;

<<<<<<< Updated upstream
        $suppliers = $this->supplier_model->get_selected_value('id,name','suppliers',['is_deleted' => 0]);
        // show($my_material_ids);
        $ret = [];
        foreach ($my_material_ids as $key1 => $material) {
            $ret[$key1]['material_id'] = $material;
            foreach ($suppliers as $key => $supplier) {
                $ret[$key1]['supplier_data'][$key]['supplier_id'] = $supplier['id'];
                $ret[$key1]['supplier_data'][$key]['supplier_name'] = $supplier['name'];
                $ret[$key1]['supplier_data'][$key]['count'] = $this->supplier_model->get_count('supplier_material',['state_id' => $state_id,'supplier_id'=>$supplier['id'],'material_id'=>$material]);
=======
        //getting only those materials which was selected on previous page
        $materials = $this->supplier_model->get_value_where_and_wherein('materials',['is_deleted' => 0],'id',$materials_material_ids);

        //this is for sql group by issue, we have to run this query before we run below get_graph_data
        $sql_group_by_issue = $this->supplier_model->SQL_MODE_FULL_GROUP_BY_QUERY();
        //all grapgh data filter by state and material id and group by suppliers
        $graph_data = $this->supplier_model->get_graph_data($state_id,$graph_material_ids);
        $graph_data = set_subarray_multiple_index_by_coulnm_value($graph_data,'material_id');

        //combining grapgh data with each respective material
        foreach ($materials as $key => $material) {
            if(isset($graph_data[$material['id']])){
                $materials[$key]['graph_data'] = $graph_data[$material['id']];
>>>>>>> Stashed changes
            }

        }
        // show($ret);

        // $count_of_suppliers = $this->supplier_model->get_supplier_count_of_materials_by_state_id($state_id,$my_material_ids);
        // show($count_of_suppliers);
        $data['selected_state'] = $this->input->post('state');
        $data['title'] = "Graph";
        $data['number_of_materials'] = count($my_material_ids);
        $data['materials'] = $ret;
        // show($data);
        $path = 'supplier/display_graph';
        $this->load->view($path,$data);
    }

    private function insert_new_supplier($new_supplier_data){
        $supplier_insert_id = $this->supplier_model->insert_value('suppliers',$new_supplier_data);
        return $supplier_insert_id;
    }

    // private function add_new_relation($new_relation){
    //     $new_relation_id = $this->supplier_model->insert_value('supplier_material',$new_relation);
    //     return $new_relation_id;
    // }

    public function add_supplier_material(){
        $states = $this->supplier_model->get_selected_value('id,state_name,state_key','states',['is_deleted' => 0]);
        $suppliers = $this->supplier_model->get_selected_value('id,name','suppliers',['is_deleted' => 0]);
        $materials = $this->supplier_model->get_selected_value('id,material_name,supplier_id','materials',['is_deleted' => 0]);
        $data['states'] = $states;
        $data['suppliers'] = $suppliers;
        $data['materials'] = $materials;
        $data['title'] = "Add Supplier";
        $path = 'supplier/add_supplier_material';
        $this->load->view($path,$data);
    }
    public function add_supplier_material_relation(){
        $data['state_id'] = $this->input->post('state_id');
        $data['supplier_id'] = $this->input->post('supplier_id');
        $data['material_id'] = $this->input->post('material_id');
        $insert_id = $this->supplier_model->insert_value('supplier_material',$data);
        return $insert_id;
    }

    // public function add_potiental_information(){
    //     $data['number_of_employees'] = $this->input->post('num_of_employess');
    //     $data['company_status'] = $this->input->post('company_status');
    //     $data['company_system'] = $this->input->post('company_system');
    //     $data['segment'] = $this->input->post('segment');
    //     $selected_state = $this->input->post('state');
    //     $insert_id = "";
    //     // if( empty( $this->session->userdata('id') )){
    //         // $insert_id = $this->supplier_model->insert_value('company_details',$data);
    //     // }
    //     // if($insert_id){
    //         // $this->eio_seekesseeion->set_userdata('id', $insert_id);
    //     // }
    //
    //     //states for dropwdown
    //     $states = $this->supplier_model->get_selected_value('id,state_name,state_key','states',['is_deleted' => 0]);
    //
    //     //fetching the realtions of state material and supplier
    //     $relations = $this->supplier_model->get_value('supplier_material',['state_id' => $selected_state],'material_id');
    //
    //     //setting the index of relations with respect to material ids
    //     if(count($relations) > 0){
    //         $relations = set_subarray_multiple_index_by_coulnm_value($relations,'material_id');
    //     }
    //
    //     $suppliers = $this->supplier_model->get_selected_value('id,name','suppliers',['is_deleted' => 0]);
    //     if(count($suppliers) > 0){
    //         $suppliers = set_subarrays_index_by_column_value($suppliers,'id');
    //     }
    //
    //     $materials = $this->supplier_model->get_selected_value('id,material_name','materials',['is_deleted' => 0]);
    //     if(count($materials) > 0){
    //         $materials = set_subarrays_index_by_column_value($materials,'id');
    //     }
    //
    //     foreach ($relations as $key => $relation) {
    //         foreach ($relation as $key1 => $value) {
    //             if(isset($suppliers[$value['supplier_id']])){
    //                 $relations[$key][$key1]['supplier_name'] = $suppliers[$value['supplier_id']]['name'];
    //             }
    //
    //         }
    //     }
    //
    //     foreach ($materials as $key => $material) {
    //         if(isset($relations[$key])){
    //             $materials[$key]['material_suppliers'] = $relations[$key];
    //         }
    //     }
    //     // show($materials,'$materials',1);
    //
    //     $data['states'] = $states;
    //     $data['selected_state'] = $selected_state;
    //     $data['materials'] = $materials;
    //     // $data['suppliers'] = $suppliers;
    //     $data['materials_count'] = count($materials);
    //     $data['title'] = "Suppliers";
    //     $path = 'supplier/select_suppliers';
    //     $this->load->view($path,$data);
    // }
}
