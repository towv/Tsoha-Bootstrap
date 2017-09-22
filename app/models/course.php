<?php

class Course extends BaseModel {
    
    public $id, $name, $holes, $par, $location, $description;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Rata');
        
        $query->execute();
        
        $rows = $query->fetchAll();
        $courses = array();
        
        foreach ($rows as $row) {
            $courses[] = new Course(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'holes' => $row['vaylia'],
                'par' => $row['ihannetulos'],
                'location' => $row['sijainti'],
                'description' => $row['kuvaus']
            ));            
        }
        return $courses;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Rata WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if ($row) {
            $course[] = new Course(array(
                'id' => $row['id'],
                'name' => $row['nimi'],
                'holes' => $row['vaylia'],
                'par' => $row['ihannetulos'],
                'location' => $row['sijainti'],
                'description' => $row['kuvaus']
            ));
            return $course;
        }
        
        
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Rata (nimi, vaylia, ihannetulos, sijainti, kuvaus) VALUES (:name, :holes, :par, :location, :description) RETURNING id');
        
        $query->execute(array('name'=> $this->name, 'holes' => $this->holes, 
            'par' => $this->par, 'location' => $this->location, 'description' => $this->description));
        
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
    
}
