<?php include "init.php" ?>
<?php

class Photo extends Db_object {
    
    protected static $db_table = "photos";
    protected static $db_table_fields = array('id', 
                                              'photo_title', 
                                              'photo_description', 
                                              'photo_file_name', 
                                              'photo_file_type', 
                                              'size',
                                              'photo_alternate_text',
                                              'caption'
                                             );
    public $id;
    public $photo_title;
    public $photo_description;
    public $photo_file_name;
    public $photo_file_type;
    public $photo_alternate_text;
    public $caption;
    public $size;
    public $tmp_path;
    public $upload_directory = "images";
    
    public function picture_path(){
        return $this->upload_directory.DS.$this->photo_file_name;
    }
    
    public function save() {
        if($this->id){
            $this->update();
        } else {
            if(!empty($this->errors)) {
                return false;
            }
            if(empty($this->photo_file_name) || empty($this->tmp_path)) {
                $this->errors[] = "The file was not available";
                return false;
            }
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->photo_file_name;
            
            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->photo_file_name} already exists";
                return false;
            }
            
            if(move_uploaded_file($this->tmp_path, $target_path)) {
                if($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }
            } else {
                $this->errors[] = "The file directory probably does not have permission";
                return false;
            }
        }
    }
    
    public function delete_photo() {
        if($this->delete()) {
            $target_path = SITE_ROOT.DS. 'admin' . DS . $this->picture_path();
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }
    
    public static function display_sidebar_data($photo_id) {
        $photo = Photo::find_by_id($photo_id);
        
        $output  = "<a class='thumbnail' href='#'><img width='100' src='{$photo->picture_path()}'";
        $output .= "<p>{$photo->photo_file_name}</p>";
        $output .= "<p>{$photo->photo_file_type}</p>";
        $output .= "<p>{$photo->size}</p>";
        
        echo $output;
    }
}