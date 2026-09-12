<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Kriteria_model extends CI_Model {

        public function tampil()
        {
            $query = $this->db->get('kriteria');
            return $query->result();
        }
		
		public function get_kriteria_order()
        {
            $query = $this->db->query("SELECT * FROM kriteria ORDER BY bobot_awal DESC");
            return $query->result();
        }

        public function insert($data = [])
        {
            $result = $this->db->insert('kriteria', $data);
            return $result;
        }

        public function show($id_kriteria)
        {
            $this->db->where('id_kriteria', $id_kriteria);
            $query = $this->db->get('kriteria');
            return $query->row();
        }

        public function update($id_kriteria, $data = [])
        {
            $ubah = array(
                'keterangan' => $data['keterangan'],
                'kode_kriteria' => $data['kode_kriteria'],
                'bobot_awal'  => $data['bobot_awal'],
                'jenis'  => $data['jenis']
            );

            $this->db->where('id_kriteria', $id_kriteria);
            $this->db->update('kriteria', $ubah);
        }
		
		public function update_bobot($id_kriteria, $data = [])
        {
            $ubah = array(
                'bobot_swara' => $data['bobot_swara']
            );

            $this->db->where('id_kriteria', $id_kriteria);
            $this->db->update('kriteria', $ubah);
        }

        public function delete($id_kriteria)
        {
            $this->db->where('id_kriteria', $id_kriteria);
            $this->db->delete('kriteria');
        }
    }
    