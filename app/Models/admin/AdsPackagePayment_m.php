<?php namespace App\Models\admin;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
class AdsPackagePayment_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }

    public function make_ads_package_payments($paymentId){
        $paymentId = (int)$paymentId;

        $date = date('Y-m-d H:i:s');
        $adminId  = (int)$_SESSION['admin']['admin_user_id'];


        if ($paymentId === 0)
            return false;

        $paymentsDetails = $this->db->query("SELECT *
                                            FROM 
                                            saputara_ads_package_payment_history
                                            WHERE
                                             payment_id  = {$paymentId} ");

        $payment_details = $paymentsDetails->getRowArray();

        $totalAmount = $payment_details['total_price'];

        if (!empty($payment_details)) {
            $update_payments = $this->db->query(" UPDATE
                                                 saputara_ads_package_payment_history
                                             SET
                                                payment_status = 1,
                                                amount_paid = '{$totalAmount}',
                                                actioned_by = {$adminId},
                                                payment_date = '{$date}',
                                                updated_at  = '{$date}'
                                             WHERE
                                                payment_id  = {$paymentId}");

            if ($update_payments) {

                // mark hotel payments as completed
                $this->db->query("UPDATE
                                saputara_hotel_modules
                              SET
                              ads_package_payment_status = 1                                               
                              WHERE
                              ads_payment_id  = {$paymentId}");


                // add top package payemts logs
                $topPackagepaymentsLog = array(
                    'payment_id' => $paymentId,
                    'credit_amount' => $totalAmount,
                    'is_ads' => 1,
                    'created_at' => $date,
                );
                $builder = $this->db->table('saputara_top_package_payments_logs');
                $builder->insert($topPackagepaymentsLog);
                return $this->db->insertID();
            }
        }

        return 0;
    }
}
