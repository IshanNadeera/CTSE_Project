<?php

/**
 * Description of Report_model
 *
 * @author randeepac.cbl
 */
class Users_model extends CI_Model
{

    public function login($un,$pwd)
    {

        $user = $this->db->select('*')
        ->from ('ctse.users u')
        ->where('username',$un)
        ->get()
        ->result();

        if(sizeof($user)>0){
            if($user[0]->password == $pwd){
                $orders = $this->db->select('o.OrderID, o.OrderBy,o.total,o.apprived_by')
                ->from ('ctse.orders o')
                ->where('o.status','ACTIVE')
                ->get()
                ->result();

                foreach($orders as $o){

                    $dtls= $this->db->select('od.product_ID, p.ProductName,od.qunatity')
                    ->from ('ctse.orders o')
                    ->join('ctse.order_details od', 'o.OrderID = od.OrderID')
                    ->join('ctse.products p', 'p.productID = od.product_ID')
                    ->where('o.OrderID',$o->OrderID)
                    ->get()
                    ->result();
                    $o->details=$dtls;
                }

                $data=array(
                    "status"=>"1",
                    "data"=>$orders,
                    "msg"=>"Successfully Login!",
                );
            }else{
                $data=array(
                    "status"=>"0",
                    "data"=>"",
                    "msg"=>"Invalid Password!"
                );
            }
        }else{
            $data=array(
                "status"=>"2",
                "data"=>"",
                "msg"=>"Invalid Username!"
            );
        }
        return $data;
    }

}