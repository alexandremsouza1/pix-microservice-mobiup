<?php

namespace App\Adapters;

use App\Adapters\Interfaces\PixAdapterInterface;
use App\Integrations\Getnet\Service\Factory;
use Carbon\Carbon;

class PixGetNetAdapter implements PixAdapterInterface
{

    const INFO = [
        'amount' => null,
        'currency' => 'BRL',
        'order_id'=> '',
        'customer_id' => ''
      ];


    public function getAdaptPix($data): array
    {
        $pixAdaptIntegration = $this->adaptIntegrationPix($data);
        $factory = new Factory();
        $resultPixAdaptIntegration = $factory->build($pixAdaptIntegration);
        return $this->adaptPix($data,$resultPixAdaptIntegration);
    }

    private function adaptIntegrationPix($data): array
    {
        $object = new \stdClass();

        foreach (self::INFO as $key => $value)
        {
            $object->$key = $value;
        }

        $object->amount = intval($data['amount']);


        $object->order_id = $data['paymentId'];

        $object->customer_id = $data['customer']['document'];


        return (array) $object;
    }

    private function adaptPix($origin,$data): array
    {
        return [
            '_id' => $data->payment_id,
            'status' => $this->getRealStatus($data->status),
            'amount' => $origin['amount'],
            'paymentId' => $origin['paymentId'],
            'customer' => $origin['customer'],
            'copyAndPaste'=> $data->additional_data->qr_code, 
            'qrCode' => ( new \chillerlan\QRCode\QRCode)->render($data->additional_data->qr_code),
            'expireAt' =>  $this->calculateExpirationPixDate($data->additional_data->expiration_date_qrcode)
        ];
    }

    private function calculateExpirationPixDate(string $date) : string
    {
        // Extract the creation date and expiration time from the provided data
        $expiracao = Carbon::parse($date);

        // Format the expiration date as desired (e.g., to a specific format)
        return $expiracao->format('Y-m-d\TH:i:s.u\Z');
    }

    private function getRealStatus($status)
    {
        $result = 'PENDING';
        switch ($status) {
            case 'WAITING':
                $result = 'WAITING';
                break;
            case 'APPROVED':
                $result = 'APPROVED';
                break;
            case 'EXPIRED':
                 $result = 'EXPIRED';
                break;

        }
       return $result;
    }
}