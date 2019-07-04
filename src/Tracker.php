<?php
namespace Riesenia\SpsWebship;

/**
 * API client for getting shipment status.
 *
 * @author Tomas Saghy <segy@riesenia.com>
 */
class Tracker
{
    /** @var int */
    protected $customer;

    /** @var int */
    protected $customerType;

    /** @var string */
    protected $language;

    /** @var string */
    protected $wsdl = 'http://t-t.sps-sro.sk/service_soap.php?wsdl';

    /**
     * Constructor.
     *
     * @param string $language
     * @param int    $customer
     * @param int    $customerType
     */
    public function __construct(string $language, int $customer, int $customerType = 1)
    {
        $this->language = $language;
        $this->customer = $customer;
        $this->customerType = $customerType;

        $this->soap = new \SoapClient($this->wsdl);
    }

    /**
     * Get shipments by reference number.
     *
     * @param string $reference
     * @param string $date
     *
     * @return array
     */
    public function getShipments(string $reference, string $date = ''): array
    {
        $response = $this->soap->__call('getListOfShipments', [
            'kundenr' => $this->customer,
            'verknr' => $reference,
            'km_mandr' => $this->customerType,
            'versdat' => $date,
            'langi' => $this->language
        ]);

        return (array) $response;
    }
}
