<?php

namespace Player;

class CategoryService {

    private $db;


    public function __construct($db) {
        $this->db = $db;
    }

    public function findBy($query) {
        $where = array();
        $binding = array();
        foreach ($query as $col => $val) {
            $where[] = "{$col} = :{$col}";
            $binding[":{$col}"] = $val;
        }

        $sql = 'SELECT * FROM fusion_pdp_cats WHERE ' . implode(' AND ', $where) . ' LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($binding);

        $category = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($category) {
            return $category;
        }

        return null;
    }
}
