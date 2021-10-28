<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Supplier_model extends CI_Model
{
    private $segments = 'segments';
    private $states = 'states';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_value($table, $where=[], $order_by='')
    {
        if ($order_by !=='') {
            $this->db->order_by($order_by, 'asc');
        }
        return $this->db->where($where)->get($table)->result_array();
    }

    public function get_selected_value($selected_items,$table, $where=[], $order_by='')
    {
        if ($order_by !=='') {
            $this->db->order_by($order_by, 'desc');
        }
        return $this->db->select($selected_items)->where($where)->get($table)->result_array();
    }

    public function get_count($table, $where=[])
    {
        return $this->db->where($where)->get($table)->num_rows();
    }

    public function insert_value($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function insert_data_in_bulk($table,$data)
    {
           $this->db->insert_batch($table, $data);
    }

    public function get_supplier_count_of_materials_by_state_id($state_id,$material_ids)
        {
            $sql = "SELECT
	           s.id as supplier_id,
                        COUNT(supplier_id) AS supplier_count,
                        material_id
                    FROM
                        `supplier_material` sm

                        JOIN suppliers s on (s.id = sm.supplier_id)
                    WHERE
                        sm.state_id = ".$state_id."
                        AND
                        sm.material_id IN (".$material_ids.")
                    GROUP BY
                        sm.material_id";
            $result = $this->db->query($sql)->result_array();
            return $result;
        }
    public function get_graph_data($state_id, $material_ids){
        // mat.material_name is deleted

        $sql = "SELECT
                    COUNT(*) as count_of_rows,
                    sm.supplier_id,
                    sup.name,
                    sm.material_id
                FROM
                    `supplier_material` sm
                    JOIN suppliers sup ON (sup.id = sm.supplier_id)
                    JOIN materials mat ON (mat.id = sm.material_id)
                WHERE
                    sm.state_id = ".$state_id."
                    AND
                    sm.material_id IN (".$material_ids.")
                GROUP BY
                    sm.supplier_id
                ORDER BY
                    sm.material_id ASC";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function get_value_wherein($table, $column, $where, $order_by='')
    {
        if ($order_by !=='') {
            $this->db->order_by($order_by, 'desc');
        }
        return $this->db->from($table)->where_in($column, $where)->get()->result_array();
    }

    public function get_value_where_and_wherein($table, $where, $colunm, $where_in ,$order_by = '')
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order_by, 'desc');
        $this->db->where_in($colunm, $where_in);
        $this->db->where($where);
        return $this->db->get()->result_array();
    }
}
