<?php
 
class Master {
    /**
        * Получить все записи
        */
    function get_all_data(){
        $json = (array) json_decode(file_get_contents('data.json'));
        $data = [];
        foreach($json as $row){
            $data[$row->id] = $row;
        }
        return $data;
    }
 
    /**
        * Получить запись о пользователе
        */
    function get_data($type = '', $key = ''){

        if(!empty($key)){
            $data = $this->get_all_data();
            if(isset($data[$key])){
                return $data[$key];
            }
        }
        $json = (array) json_decode(file_get_contents('data.json'));
        $data = [];
        foreach($json as $row){
            if ($row->$type == $key){
                $data = $row;
                return $data;
            }
        }
        
 
    }
 
    /**
        * Добавление в БД
        */
    function insert_to_json(){
        $login = $_POST['login'] ?? null;
        $password = $_POST['password'] ?? null;
        $passwordConfirmation = $_POST['password_confirmation'] ?? null;
        $email = $_POST['email'] ?? null;
        $name = $_POST['name'] ?? null;
 
        $data = $this->get_all_data();
        if ($data){
            $id = array_key_last($data) + 1;
        }else{
            $id = 1;
        }
        if ($password == $passwordConfirmation){ 
            $salt = $login;
            $hash = sha1($salt.$password);
            $data[$id] = (object) [
                "id" => $id,
                'login' => $login,
                'password'=> $hash,
                'email'=> $email,
                'name'=> $name
            ];
        
            $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
            $insert = file_put_contents('data.json', $json);
            if($insert){
                $resp['status'] = 'success';
            }else{
                $resp['failed'] = 'failed';
            }
            return $resp;
        }
    }
    /**
        * Редактирвоать данные о пользователе
        */
    function update_json_data(){
        $id = $_POST['id'];
        $login = $_POST['login'] ?? null;
        $password = $_POST['password'] ?? null;
        $passwordConfirmation = $_POST['password_confirmation'] ?? null;
        $email = $_POST['email'] ?? null;
        $name = $_POST['name'] ?? null;
        
 
        $data = $this->get_all_data();
        $data[$id] = (object) [
            'login' => $login,
            'password'=> password_hash($password, algo:PASSWORD_DEFAULT),
            'email'=> $email,
            'name'=> $name
        ];
        $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
        $update = file_put_contents('data.json', $json);
        if($update){
            $resp['status'] = 'success';
        }else{
            $resp['failed'] = 'failed';
        }
        return $resp;
    }
 
    /**
        * Удалить данные о пользователе
        */
 
        function delete_data($id = ''){
        if(empty($id)){
            $resp['status'] = 'failed';
            $resp['error'] = 'Given Member ID is empty.';
        }else{
            $data = $this->get_all_data();
            if(isset($data[$id])){
                unset($data[$id]);
                $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
                $update = file_put_contents('data.json', $json);
                if($update){
                    $resp['status'] = 'success';
                }else{
                    $resp['failed'] = 'failed';
                }
            }else{
                $resp['status'] = 'failed';
                $resp['error'] = 'Given Member ID is not existing on the JSON File.';
            }
        }
        return $resp;
        }
}